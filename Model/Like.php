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

    public function findMessageUrlByUserIds($send_user_id, $receive_user_id) {
        $like = $this->find('first', 
            array('conditions' => 
                array (
                        'Like.send_user_id' => $send_user_id,
                        'Like.receive_user_id' => $receive_user_id
                    )
                )
            );

        return $like['Like']['message_url'];
    }

    public function findIdByUserIds($send_user_id, $receive_user_id) {
        $like = $this->find('first', 
            array('conditions' => 
                 array (
                     'Like.send_user_id' => $send_user_id,
                     'Like.receive_user_id' => $receive_user_id
                 )
            )
        );

        return $like['Like']['id'];
    }

    public function isLikeData($send_user_id, $receive_user_id) {
        $cnt = $this->find('count', 
            array('conditions' => 
                 array (
                     'Like.send_user_id' => $send_user_id,
                     'Like.receive_user_id' => $receive_user_id
                 )
             )
         );

         return $cnt > 0 ? true : false; 
    }
}
