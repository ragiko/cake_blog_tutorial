<?php

App::uses('AppController', 'Controller');
 
App::import('Vendor', 'twilio/sdk/Services/Twilio');

class UsersController extends AppController {

    // 別のモデルを使うときは$usesを書く
    // http://book.cakephp.org/2.0/en/controllers.html#Controller::$uses
    public $uses = array('Like', 'User');

    public $helpers = array('Html', 'Form');

    public function top($id) {

        // ユーザが興味のあるユーザ群
        $like_user_ids = $this->User->find_like_user_by_id($id);
        $this->set('like_user_ids', $like_user_ids);

        // マッチングを調べる
        echo $this->Like->is_matching_users(1, 3);

        $this->set('users', 
            $this->User->find('all',
                array(
                    'conditions' => array(
                        'NOT' => array(
                            'User.id' => array($id)
                        )
                    )
                )
            )
        );
    }

    public function test() {
        $this->autoRender = false;

        $response = new Services_Twilio_Twiml();
        $response->say("初め", array('language' => 'ja-jp'));
        $record = $response->record(array( "action" => "http://153.121.51.112/cake_blog_tutorial/users/twiedit/1", 'method' => "POST", 'finishOnKey' => '#', 'maxLength' => 20));
        $response->say("レコード失敗", array('language' => 'ja-jp'));

        $this->response->type('text/xml');
        $this->response->body($response);
        return $this->response;
    }

    // twimlから帰ってきてデータをDBに入れる
    public function twiedit($id = null) {
        $this->autoRender = false;

        if (!$id) {
            throw new NotFoundException(__('Invalid id'));
        }

        $user = $this->User->findById($id);
        if (!$user) {
            throw new NotFoundException(__('Invalid user'));
        }

        // twilioからmessage のpathを取得
        $message_path = $_REQUEST['RecordingUrl'];
        if (!$message_path) {
            throw new NotFoundException(__('Invalid message'));
        }

        // データを新しく作るか更新するかは、モデルの id フィールドによって決まります。$Model->id がセットされていれば、このIDをプライマリーキーにもつレコードが更新されます。それ以外は新しくレコードが作られます。
        // 新しくデータを作るのではなく、データを更新したい場合は、data配列にプライマリーキーのフィールドを渡してください。
        // http://book.cakephp.org/2.0/ja/models/saving-your-data.html
        if ($this->request->is('post')) {
            $data = array('message_path' => $message_path);
            $this->User->id = $id;
            $this->User->save($data);
        }
    }

    public function view($id) {
        if (!$id) {
            throw new NotFoundException(__('Invalid user'));
        }

        $user = $this->User->findById($id);
        if (!$user) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $user);
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            print_r($this->request->data);
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Your user has been saved.'));
                return $this->redirect(array('action' => 'top/1'));
            }
            $this->Session->setFlash(__('Unable to add your user.'));
        }
    }

    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid user'));
        }

        $user = $this->User->findById($id);
        if (!$user) {
            throw new NotFoundException(__('Invalid user'));
        }

        if ($this->request->is(array('user', 'put'))) {
            $this->User->id = $id;
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Your user has been updated.'));
                return $this->redirect(array('action' => 'top/1'));
            }
            $this->Session->setFlash(__('Unable to update your user.'));
        }

        if (!$this->request->data) {
            $this->request->data = $user;
        }
    }

}
