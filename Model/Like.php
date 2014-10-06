<?php
App::uses('AppModel', 'Model');
/**
 * Like Model
 *
 */
class Like extends AppModel {
    // ユーザ同士がマッチングしているかどうかを調べる
    public function isMatchUsers($user_id1, $user_id2) {

        $count1 = $this->find('count', 
            array('conditions' => 
                 array (
                     'Like.send_user_id' => $user_id1,
                     'Like.receive_user_id' => $user_id2
                 )
            )
        );

        $count2 = $this->find('count', 
            array('conditions' => 
                 array (
                     'Like.send_user_id' => $user_id2,
                     'Like.receive_user_id' => $user_id1
                 )
            )
        );
       
        return ($count1 > 0 && $count2 > 0) ? true : false;
    }
}
