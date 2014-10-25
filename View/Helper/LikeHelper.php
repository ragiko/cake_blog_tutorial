<?php
class LikeHelper extends AppHelper {

    function makeMessageHtml($send_user_id, $receive_user_id) {
        App::import("Model", "Like");  
        $model = new Like();

        $message = $model->findMessageUrlByUserIds($send_user_id, $receive_user_id);
        return "<audio src='$message' controls></audio>";
    }
}
