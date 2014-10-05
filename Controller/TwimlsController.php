<?php

App::uses('AppController', 'Controller');
App::import('Vendor', 'twilio/sdk/Services/Twilio');

class TwimlsController extends AppController {

    public function recode() {
        $this->autoRender = false;

        $response = new Services_Twilio_Twiml();
        $response->say("初め", array('language' => 'ja-jp'));
        $record = $response->record(array( /* "action" => "http://153.121.51.112/cake_blog_tutorial/users/twiedit/1/2", */ 'method' => "POST", 'finishOnKey' => '#', 'maxLength' => 20));
        $response->say("レコード失敗", array('language' => 'ja-jp'));

        $this->response->type('text/xml');
        $this->response->body($response);
        return $this->response;
    }
}
