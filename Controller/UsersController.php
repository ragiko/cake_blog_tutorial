<?php

App::uses('AppController', 'Controller');
App::import('Vendor', 'twilio/sdk/Services/Twilio');
App::import('Vendor', 'facebook/php-sdk/src/facebook');

class UsersController extends AppController {

    // 別のモデルを使うときは$usesを書く
    // http://book.cakephp.org/2.0/en/controllers.html#Controller::$uses
    public $uses = array('Like', 'User');
    public $helpers = array('Html', 'Form');
    public $Facebook;

    public function beforeFilter() {
        $this->Facebook = new Facebook(array(
            'appId' => '374929902578634',
            'secret' => '2279d1bfb45e1cb14d61a5d66c6ae1cf',
            'cookie' => true,
        ));

        $this->Auth->allow('login', 'logout', 'add', 'a');

        ini_set('memory_limit', '512M');
    }

    public function index() {
        if ($this->Auth->loggedIn()) {
            $facebookId = $this->Facebook->getUser();
            $user = $this->User->find('first', ['conditions' => ['User.facebook_num' => $facebookId]]);
            $friend_list = $this->Facebook->api("/v1.0/me?fields=friends{name,gender}");

            $this->set(compact('user'));
            $this->set(compact('facebookId'));
            $this->set(compact('friend_list'));

            // ユーザがLikeを押した他のユーザ
            $like_user_ids = $this->_getLikeUserIds($facebookId);
            $this->set(compact('like_user_ids'));

            // twilioのtoken
            $accountSid = 'ACf29289f2c695bd6b271be0dff46b649a';
            $authToken = 'b48373aa8cc8f558aa727f073a1d0ff7';

            $capability = new Services_Twilio_Capability($accountSid, $authToken);
            $capability->allowClientOutgoing('AP25be2f04e359a0117a2853242b87784d');
            $capability->allowClientIncoming("take");
            $token = $capability->generateToken();

            $this->set(compact('token'));
        } else {
            $this->redirect(['action' => 'logout']);
        }
    }

    public function login() {
        $this->autoRender = false;

        // facebook OAuth login
        $facebookId = $this->Facebook->getUser();
        if (!$facebookId) {
            $this->_authFacebook();
        }

        $user = $this->User->find('first', ['conditions' => ['User.facebook_num' => $facebookId]]);
        if (!empty($user['User'])) {
            // $this->Auth->login() では、ユーザー名とパスワードをチェック
            // http://www.moonmile.net/blog/archives/4855
            if ($this->Auth->login($user['User'])) {
                $this->redirect(['action' => 'index']);
            }
        } else {
            $this->redirect(['action' => 'add']);
        }

        $this->redirect(['action' => 'logout']);
    }

    public function logout() {
        $this->Facebook->destroySession();
        $this->redirect($this->Auth->logout());
    }

    public function add() {

        // TODO: ロジックを要修正 and refactor
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('登録が完了しました。'));
                $this->redirect(['action' => 'index']);
            } else {
                $this->Session->setFlash(__('登録てきません.'));
            }
        }
        else {
            $facebookInfo = $this->Facebook->api('/me', 'GET');
            $user = array(
                'User' => [
                    'facebook_num' => $facebookInfo['id'],
                    'name' => $facebookInfo['name'],
                    'gender' => $facebookInfo['gender'],
                    // TODO: birthdayからage変換したい
                    // 'age' => $facebookInfo['birthday'],
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s'),
                ]
            );

            $this->request->data = $user;
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

    /*
     * PROTECTED METHODS
     */
    protected function _authFacebook() {
        $loginUrl = $this->Facebook->getLoginUrl(['scope' => 'email,publish_stream,user_birthday,user_education_history,user_likes', 'redirect_uri' => Router::fullBaseUrl() . Router::url(['controller' => 'users', 'action' => 'login'])]);
        return $this->redirect($loginUrl);
    }

    // ユーザのfacebookidからユーザが好きな他のユーザのIDを返す
    protected function _getLikeUserIds($facebook_id) {
        $like_users = $this->Like->find('all', ['conditions' => ['Like.send_user_id' => $facebook_id]]);

        $receive_user_ids = array_map(function ($like) {
            return $like['Like']['receive_user_id'];
        }, $like_users);

        return $receive_user_ids;
    }


}
