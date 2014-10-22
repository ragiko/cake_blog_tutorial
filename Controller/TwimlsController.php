<?php

App::uses('AppController', 'Controller');
App::import('Vendor', 'twilio/sdk/Services/Twilio');

class TwimlsController extends AppController {

    public $uses = array('Like', 'Twiml');

    public function beforeFilter() {
        $this->Auth->allow('twiml',  'dial');
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
                $url = "/cake_blog_tutorial/likes/update_message_url/$send_user_id/$receive_user_id/";

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

                $gather = $response->gather(array('numDigits' => 1, 'timeout' => 10, 'action' => "http://153.121.51.112/cake_test/twimls/dial?r_user_id=$receive_user_id", 'method' => 'GET' ));
                $gather->say("告白を受けるならには1を拒否は2を押してください。", array('language' => 'ja-jp'));
            }
        }

        $this->response->type('text/xml');
        $this->response->body($response);
        return $this->response;
    }

    public function dial() {
        $this->autoRender = false;

        $response = new Services_Twilio_Twiml();

        if (empty($_POST['Digits'])) { }
        else if ($_POST['Digits'] === "1") {
            // $response->dial("+819071485047", array('callerId' => '+815031717728', 'timeout' => '10'));
        } 
        else if ($_POST['Digits'] === "2") {
            $response->say("告白を終了します", array('language' => 'ja-jp'));
        }

        $this->response->type('text/xml');
        $this->response->body($response);
        return $this->response;
    }
}
