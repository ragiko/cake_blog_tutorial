<?php

App::uses('AppController', 'Controller');
App::import('Vendor', 'twilio/sdk/Services/Twilio');

class TwimlsController extends AppController {

    public $uses = array('Like', 'Twiml');

    public function beforeFilter() {
        $this->Auth->allow('twiml');
    }

    // 録音 
    public function recode() {
        $this->autoRender = false;

        $response = new Services_Twilio_Twiml();
        $response->say("録音します", array('language' => 'ja-jp'));
        $record = $response->record(array( /* "action" => "http://153.121.51.112/cake_blog_tutorial/users/twiedit/1/2", */ 'method' => "POST", 'finishOnKey' => '#', 'maxLength' => 20));
        $response->say("レコード失敗", array('language' => 'ja-jp'));

        $this->response->type('text/xml');
        $this->response->body($response);
        return $this->response;
    }

    // 録音したデータの再生 
    public function play() {
        $this->autoRender = false;

        $response = new Services_Twilio_Twiml();
        $response->say("録音を再生します", array('language' => 'ja-jp'));
        $response->play("http://api.twilio.com/2010-04-01/Accounts/ACf29289f2c695bd6b271be0dff46b649a/Recordings/RE512c7a58961f580d4b3f3a7a13196e63");
        $response->say("通話が終了しました", array('language' => 'ja-jp'));

        $this->response->type('text/xml');
        $this->response->body($response);
        return $this->response;
    }

    public function twiml() {
        $this->autoRender = false;

        $response = new Services_Twilio_Twiml();

        if (isset($_REQUEST['type'])) {
            $type = $_REQUEST['type'];

            // 告白データをユーザに入れる
            if ($type === "record") {
                $send_user_id = $_REQUEST['send'];
                $receive_user_id = $_REQUEST['receive'];
                $url = "/cake_blog_tutorial/likes/message/$send_user_id/$receive_user_id/";

                $response->say("告白を録音します", array('language' => 'ja-jp'));
                $response->record(array("action" => $url,  'method' => "POST", 'finishOnKey' => '#', 'maxLength' => 5));
                $response->say("レコード失敗", array('language' => 'ja-jp'));
            }
            else if ($type === "listen") {
                $send_user_id = $_REQUEST['send'];
                $receive_user_id = $_REQUEST['receive'];
                // 相手からmessageを受け取るため、引数を逆に設定
                $message_url = $this->Like->findMessageUrlByUserIds($receive_user_id, $send_user_id);

                $response->say("告白を再生します", array('language' => 'ja-jp'));
                $response->play($message_url);
                $response->say("告白が終了しました", array('language' => 'ja-jp'));
            }
        }
        
        $this->response->type('text/xml');
        $this->response->body($response);
        return $this->response;
    }
}
