<?php

App::uses('AppModel', 'Model');

class User extends AppModel {
    public $validate = array(
        'title' => array(
            'rule' => 'notEmpty'
        ),
        'body' => array(
            'rule' => 'notEmpty'
        )
    );

    public $actsAs = [
        'Upload.Upload' => [
            'photo' => [
                'fields' => [
                    'dir' => 'photo_dir'
                ],
                'thumbnailSizes' => [
                    'thumb150' => '150x150',
                    'normal' => '200x200',
                    'big' => '500x500'
                ],
                'path' => '{ROOT}webroot{DS}files{DS}{model}{DS}{field}{DS}',
                'thumbnailMethod' => 'php'
            ]
        ]
    ];
}
