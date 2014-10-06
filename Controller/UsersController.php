<?php

App::uses('AppController', 'Controller');
 
App::import('Vendor', 'twilio/sdk/Services/Twilio');

class UsersController extends AppController {

    // 別のモデルを使うときは$usesを書く
    // http://book.cakephp.org/2.0/en/controllers.html#Controller::$uses
    public $uses = array('Like', 'User');

    public $helpers = array('Html', 'Form');

    public function top($id) {
        // 自身のユーザをset
        $this->set('user_id', $id);

        // ユーザが興味のあるユーザ群
        $like_user_ids = $this->User->find_like_user_by_id($id);
        $this->set('like_user_ids', $like_user_ids);
        
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

    // ブラウザフォンのテスト
    public function phone() {
        // アカウント設定
        $accountSid = 'ACf29289f2c695bd6b271be0dff46b649a';
        $authToken = 'b48373aa8cc8f558aa727f073a1d0ff7';

        $capability = new Services_Twilio_Capability($accountSid, $authToken);
        $capability->allowClientOutgoing('APbcda1076e3aad2873a64f6549f6af1f6');
        // APbcda1076e3aad2873a64f6549f6af1f6
        // PN00cdf931452a284c6b400440a93a7ba0
        $capability->allowClientIncoming("takeda");
        $token = $capability->generateToken();

        $this->set('token', $token);
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
