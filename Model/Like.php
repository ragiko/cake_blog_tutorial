<?php
App::uses('AppModel', 'Model');
/**
 * Like Model
 *
 */
class Like extends AppModel {

    // ユーザ同士がマッチングしているかどうかを調べる
    public function is_matching_users($user_id1, $user_id2) {

        $c = $this->find('count', 
            array('conditions' => 
                array("OR" => 
                    array(
                        array (
                            'Like.send_user_id' => $user_id1,
                            'Like.receive_user_id' => $user_id2
                        ),
                        array (
                            'Like.send_user_id' => $user_id2,
                            'Like.receive_user_id' => $user_id1
                        )
                    )
                )
            )
        );
        
        return ($c >= 2) ? true : false;
    }    
}
