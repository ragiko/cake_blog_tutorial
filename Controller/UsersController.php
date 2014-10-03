<?php

App::uses('AppController', 'Controller');
 
App::import('Vendor', '/Twilio/Services/Twilio');

class UsersController extends AppController {
    public $helpers = array('Html', 'Form');

    public function top($id) {
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
        $gather = $response->gather(array('numDigits' => 10, 'finishOnKey' => '#', 'timeout' => 20, 'action' => 'http://各自のURL/check'));
        $gather->say("サンプル宅配サービス自動受付センターです。お手持ちのご不在連絡票に記載されている10桁のお問い合わせ番号を入力し、最後にシャープを押してください。", array('language' => 'ja-jp'));
        $response->say("20秒ボタンが押されませんでしたので、終了します。", array('language' => 'ja-jp'));

        $this->response->type('text/xml');
        $this->response->body($response);
        return $this->response;
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

    // public function delete($id) {
    //     if ($this->request->is('get')) {
    //         throw new MethodNotAllowedException();
    //     }

    //     if ($this->Post->delete($id)) {
    //         $this->Session->setFlash(__('The post with id: %s has been deleted.', h($id)));
    //         return $this->redirect(array('action' => 'index'));
    //     }
    // }


}
