<?php

class UsersController extends AppController {
    public $helpers = array('Html', 'Form');

    public function top() {
        // TODO 自分以外の女性ユーザ出力
        $this->set('users', $this->User->find('all'));
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

    // public function add() {
    //     if ($this->request->is('post')) {
    //         $this->User->create();
    //         print_r($this->request->data);
    //         if ($this->User->save($this->request->data)) {
    //             $this->Session->setFlash(__('Your user has been saved.'));
    //             return $this->redirect(array('action' => 'regist'));
    //         }
    //         $this->Session->setFlash(__('Unable to add your user.'));
    //     }
    // }

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
                return $this->redirect(array('action' => 'index'));
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
