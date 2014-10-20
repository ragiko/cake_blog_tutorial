<?php
App::uses('AppController', 'Controller');

/**
 * Likes Controller
 *
 * @property Like $Like
 * @property PaginatorComponent $Paginator
 */
class LikesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

    public function beforeFilter() {
        $this->Auth->allow('push', 'message');
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Like->recursive = 0;
		$this->set('likes', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Like->exists($id)) {
			throw new NotFoundException(__('Invalid like'));
		}
		$options = array('conditions' => array('Like.' . $this->Like->primaryKey => $id));
		$this->set('like', $this->Like->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Like->create();
			if ($this->Like->save($this->request->data)) {
				$this->Session->setFlash(__('The like has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The like could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Like->exists($id)) {
			throw new NotFoundException(__('Invalid like'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Like->save($this->request->data)) {
				$this->Session->setFlash(__('The like has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The like could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Like.' . $this->Like->primaryKey => $id));
			$this->request->data = $this->Like->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Like->id = $id;
		if (!$this->Like->exists()) {
			throw new NotFoundException(__('Invalid like'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Like->delete()) {
			$this->Session->setFlash(__('The like has been deleted.'));
		} else {
			$this->Session->setFlash(__('The like could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

    /**
     * likeボタンを押してマッチングしているかどうかを調べてjsonを返す
     *
     * @throws 
     * @post param: $send_user_id, $receive_user_id 
     * @return void
     */
    public function push() {
        $this->autoRender = false;

        // 内部のメソッドにPOSTするならrequestAction() 
        // $result =  $this->requestAction('Controller/method', 
        //      array('return','user_id'=>$userId)
        // ); 

        // データをinsertする
        if ($this->request->is('post')) {
            $this->Like->create();
            $this->Like->save($this->request->data);
        }

        $res = array();

        // マッチングを調べる
        if ($this->Like->isMatchUsers($this->request->data['send_user_id'], $this->request->data['receive_user_id'])) {
            array_push($res, array('match' => true));
        }
        else {
            array_push($res, array('match' => false));
        }

        echo json_encode($res); 
    }

    // twimlからメッセージデータをDBに入れる
    public function message($send_user_id = null, $receive_user_id = null) {
        $this->autoRender = false;

        $like = $this->Like->find('first', 
            array('conditions' => 
                  array (
                      'Like.send_user_id' => $send_user_id,
                      'Like.receive_user_id' => $receive_user_id
                  )
            )
        );
        if (!$like) {
            throw new NotFoundException(__('Invalid user'));
        }

        // twilioからmessage のpathを取得
        $message_url = $_REQUEST['RecordingUrl'];
        if (!$message_url) {
            throw new NotFoundException(__('Invalid message'));
        }

        // データを新しく作るか更新するかは、モデルの id フィールドによって決まります。$Model->id がセットされていれば、このIDをプライマリーキーにもつレコードが更新されます。それ以外は新しくレコードが作られます。
        // 新しくデータを作るのではなく、データを更新したい場合は、data配列にプライマリーキーのフィールドを渡してください。
        // http://book.cakephp.org/2.0/ja/models/saving-your-data.html
        if ($this->request->is('post')) {
            $data = array('message_url' => $message_url);
            $this->Like->id = $like['Like']['id'];
            $this->Like->save($data);
        }
    }
}
