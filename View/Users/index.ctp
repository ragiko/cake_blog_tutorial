<h2>マイページ</h2>
<img src="https://graph.facebook.com/<?php echo $facebookId;?>/picture?width=150" alt="" />
<p><?php echo $user['User']['gender']; ?></p>
<p><?php echo $user['User']['name']; ?></p>
<p><?php echo $this->Html->link('トップページ', ['controller' => 'pages', 'action' => 'top']); ?></p>
<p><?php echo $this->Html->link('ログアウト', ['controller' => 'users', 'action' => 'logout']); ?></p>

<h2>異性の顔</h2>
<?php for($i=0; $i < count($friend_list['friends']['data']); $i++):?>
    <?php if($user['User']['gender'] != $friend_list['friends']['data'][$i]['gender']):?>
        <div class="like-box">
            <a href="https://www.facebook.com/<?php echo $friend_list['friends']['data'][$i]['id'];?>">
                <img src="https://graph.facebook.com/<?php echo $friend_list['friends']['data'][$i]['id'];?>/picture?width=100&height=100" alt="" />
            </a>
            <p><?php echo $friend_list['friends']['data'][$i]['name'];?></p>
            <button class="like-btn">like</button>
            <span class="is-check-user">
                <?php echo in_array($friend_list['friends']['data'][$i]['id'], $like_user_ids) ? "check" : ""; ?>
            </span>
            <div class="other-user-id" data-role="<?php echo $friend_list['friends']['data'][$i]['id'];?>"></div>
        </div>
    <?php endif;?>
<?php endfor;?>

<!-- タイムラインを流しているユーザidを埋め込み -->
<h2 id="log"></h2>
<div class="user-id" data-role="<?php echo $user['User']['facebook_num']; ?>"></div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="http://static.twilio.com/libs/twiliojs/1.2/twilio.min.js"></script>

<script type="text/javascript">
/*
 * Twilioの通信部分
 */
Twilio.Device.setup("<?php echo $token; ?>");

Twilio.Device.ready(function (device) {
    $("#log").text("架電待機");
});

Twilio.Device.error(function (error) {
    $("#log").text("Error: " + error.message);
});

Twilio.Device.connect(function (conn) {
    $("#log").text("架電成功");
});

Twilio.Device.disconnect(function (conn) {
    $("#log").text("架電終了");
});

Twilio.Device.incoming(function (conn) {
    if (confirm('Accept incoming call from ' + conn.parameters.From + '?')){
        connection=conn;
        conn.accept();
    }
});

function call(params) {
    // get the phone number to connect the call to
    Twilio.Device.connect(params);
}

function hangup() {
    Twilio.Device.disconnectAll();
}

/*
 * LIKEボタンを押した時
 */
(function($){
    $(".like-btn").on("click", function (){
        var user_id = $(".user-id").data('role');
        var $other_user = $(this).parent();
        var other_user_id = $(this).parent().find(".other-user-id").data('role');

        console.log("user-id: " + user_id);
        console.log("other-user-id: " +  other_user_id);

        $.ajax({
            type: "POST",
            url: "/cake_blog_tutorial/likes/check_matching_users",
            data: {
                send_user_id: user_id,
                receive_user_id: other_user_id 
            }
        }).done(function( res ) {
            // checkをrender
            $other_user.find(".is-check-user").text("check");

            var is_match = $.parseJSON(res)[0].match;
            var call_type = (is_match)? "listen" : "record"; 

            console.log("is_match: " +  is_match);
            console.log("call_type: " +  call_type);

            call({
                "type": call_type,
                "send": user_id,
                "receive": other_user_id
            });
        }).fail(function(e) {
            console.log(e);
            alert( "error" );
        }); 
    });
})(jQuery);
</script>

