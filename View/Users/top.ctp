<!-- File: /app/View/Users/index.ctp -->

<h1>users</h1>

<!-- twilioのlog -->
<h2>twilioのlog</h2>
<h2 id="log">a</h2>

<?php echo $this->Html->link(
    'profile',
    array('controller' => 'users', 'action' => 'view/1')
); ?>

<table>
    <tr>
        <th>Id</th>
        <th>name</th>
        <th>age</th>
        <th>gender</th>
        <th>address</th>
        <th>action</th>
        <th>photo</th>
        <th>Created</th>
        <th>like</th>
    </tr>

    <!-- ここから、$users配列をループして、投稿記事の情報を表示 -->

    <?php foreach ($users as $user): ?>
    <tr>
        <td class="other-user-id"><?php echo  $user['User']['id']; ?></td>
        <td><?php echo $user['User']['name']; ?></td>
        <td><?php echo $user['User']['age']; ?></td>
        <td><?php echo $user['User']['gender']; ?></td>
        <td><?php echo $user['User']['address']; ?></td>
        <td>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id'])); ?>
        </td>
        <td><img src="<?php echo  DS  . "files/user/photo/" . $user['User']['id'] . DS . "thumb150_".$user['User']['photo']?>" alt=""></td>
        <td><?php echo $user['User']['created']; ?></td>
        <td>
            <button class="like-btn">like</button>
            <?php echo (in_array($user['User']['id'], $like_user_ids)) ? 'is like' : ''; ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php unset($user); ?>
</table>


<p>test用</p>
<?php echo $this->Html->link(
    'Add User',
    array('controller' => 'users', 'action' => 'add')
); ?>

<!-- タイムラインを流しているユーザidを埋め込み -->
<div class="user-id" data-role="<?php echo $user_id ?>"></div>


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
        var other_user_id = $(this).parent().parent().find(".other-user-id").text();

        console.log("user-id: " + user_id);
        console.log("other-user-id: " +  other_user_id);

        $.ajax({
            type: "POST",
            url: "/cake_blog_tutorial/likes/push",
            data: {
                send_user_id: user_id,
                receive_user_id: other_user_id 
            }
        }).done(function( res ) {
            var is_match = $.parseJSON(res)[0].match;
            
            if (is_match) {
                // 告白メッセージを聞く
                call({
                    "type": "listen"
                });
            }
            else {
                // ボイスを登録
                call({
                    "type": "record",
                    "send": user_id,
                    "receive": other_user_id
                });
            }
        }).fail(function() {
            alert( "error" );
        }); 
    });
})(jQuery);
</script>

