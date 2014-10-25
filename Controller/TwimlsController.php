<?php

App::uses('AppController', 'Controller');
App::import('Vendor', 'twilio/sdk/Services/Twilio');

class TwimlsController extends AppController {

    public $uses = array('Like', 'Twiml', 'User');

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
                $url = "/manyheart/likes/update_message_url/$send_user_id/$receive_user_id/";

                $response->say("告白を録音します", array('language' => 'ja-jp'));
                $response->record(array("action" => $url,  'method' => "POST", 'finishOnKey' => '#', 'maxLength' => 60));
                $response->say("レコード失敗", array('language' => 'ja-jp'));
            }
            else if ($type === "listen") {
                $send_user_id = $_REQUEST['send'];
                $receive_user_id = $_REQUEST['receive'];
                // 相手からmessageを受け取るため、引数を逆に設定
                $message_url = $this->Like->findMessageUrlByUserIds($receive_user_id, $send_user_id);

                $response->say("告白を再生します", array('language' => 'ja-jp'));
                $response->play($message_url);

                $gather = $response->gather(array('numDigits' => 1, 'timeout' => 60, 'action' => "http://153.121.51.112/manyheart/twimls/dial?r_user_id=$receive_user_id", 'method' => 'GET' ));
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

        $this->log($_GET['Digits']);
        if (empty($_GET['Digits'])) { 
        }
        else if ($_GET['Digits'] === "1") {
            $r_facebook_num = $_GET['r_user_id'];
            $phone_num = $this->User->findPhoneNumberByFacebookNumber($r_facebook_num);
            $call_id = "+81" . substr($phone_num, 1, strlen($phone_num));

            $response->say("電話を繋げます", array('language' => 'ja-jp'));
            $response->dial("+819071485047", array('callerId' => '+815031717728', 'timeout' => '10'));
            $response->say("電話が終了しました", array('language' => 'ja-jp'));
        } 
        else if ($_GET['Digits'] === "2") {
            $response->say("告白を終了します", array('language' => 'ja-jp'));
        }

        $this->response->type('text/xml');
        $this->response->body($response);
        return $this->response;
    }
}
