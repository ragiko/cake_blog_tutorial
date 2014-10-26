<?php

App::uses('AppModel', 'Model');

class User extends AppModel {

    var $name = 'User';                
    var $hasMany = array(
        'Like' => array(
            'className'     => 'Like',
            'foreignKey'    => 'send_user_id',
            'dependent'=> true
        ) 
    );

    public $validate = array(
        'facebook_num' => array(
            'rule' => 'notEmpty'
        ),
        'name' => array(
            'rule' => 'notEmpty'
        ),
        'gender' => array(
            'rule' => 'notEmpty'
        ),
        'phone_number' => array(
	    'rule1' => array(
		  'rule' => 'numeric',
		  'message' => '電話番号は数字のみで入力してください'
	    ),
	    'rule2' => array(
		  'rule' => array('between',7,15),
		  'message' => '7桁以上15桁以内で入力してください'
	    )
	)
    );

    // 画像アップロードの時の設定
    // public $actsAs = [
    //     'Upload.Upload' => [
    //         'photo' => [
    //             'fields' => [
    //                 'dir' => 'photo_dir'
    //             ],
    //             'thumbnailSizes' => [
    //                 'thumb150' => '150x150',
    //                 'normal' => '200x200',
    //                 'big' => '500x500'
    //             ],
    //             'path' => '{ROOT}webroot{DS}files{DS}{model}{DS}{field}{DS}',
    //             'thumbnailMethod' => 'php'
    //         ]
    //     ]
    // ];

    // // ユーザが好きなユーザidを取得
    // public function find_like_user_by_id($id) {
    //     $user = $this->find('first', array(
    //         'conditions' => array('User.id' => $id)
    //     ));

    //     $receive_user_ids = array_map(function ($like) {
    //         return $like['receive_user_id'];
    //     }, $user['Like']);

    //     return $receive_user_ids;
    // }

    public function findPhoneNumberByFacebookNumber($num) {
        $user = $this->find('first', 
            array('conditions' => 
                 array (
                     'User.facebook_num' => $num,
                 )
             )
         );
         return $user['User']['phone_number']; 
    }
}
