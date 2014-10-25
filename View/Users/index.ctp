<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <?php 
              echo $this->Html->image("logo.png", array(
                  "width" => "90",
                  "alt" => "logo",
                      'url' => array('controller' => 'users', 'action' => 'index')
                  ));
            ?>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <form class="navbar-form navbar-right">
                        <input type="text" class="form-control" placeholder="Search...">
                    </form>
                </li>
                <li><?php echo $this->Html->link('Profile', ['controller' => 'users', 'action' => 'profile']); ?></li>
                <li><?php echo $this->Html->link('Logout', ['controller' => 'users', 'action' => 'logout']); ?></li>
            </ul>
        </div>
    </div>
</div>

<div class="row like-wrapper">
<?php for($i=0; $i < count($friend_list['friends']['data']); $i++):?>
    <?php if(isset($friend_list['friends']['data'][$i]['gender']) && $user['User']['gender'] != $friend_list['friends']['data'][$i]['gender']):?>
        <div class="like-box box pin col-xs-3" >
            <!-- <a href="https://www.facebook.com/<?php echo $friend_list['friends']['data'][$i]['id'];?>"></a> -->
            <img src="https://graph.facebook.com/<?php echo $friend_list['friends']['data'][$i]['id'];?>/picture?height=300" alt="" class="img-responsive" />
            <span><?php echo $friend_list['friends']['data'][$i]['name'];?></span>
            <?php echo in_array($friend_list['friends']['data'][$i]['id'], $like_user_ids) ? '<span class="is-check-user label label-default">告白済み</span>' : ""; ?>

            <div class="caption">
                <h4><?php echo $friend_list['friends']['data'][$i]['name'];?></h4>
                <button data-toggle="modal" data-target="#modal-<?php echo $friend_list['friends']['data'][$i]['id'];?>" href="#" class="btn btn-danger btn-large"><i class="icon-heart"></i>気になる ♡</button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modal-<?php echo $friend_list['friends']['data'][$i]['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <span class="modal-title" id="myModalLabel"><?php echo $friend_list['friends']['data'][$i]['name'];?></span>
                    <?php echo in_array($friend_list['friends']['data'][$i]['id'], $like_user_ids) ? '<span class="is-check-user label label-default">告白済み</span>' : ""; ?>

                  </div>
                  <div class="modal-body">
                    <img src="https://graph.facebook.com/<?php echo $friend_list['friends']['data'][$i]['id'];?>/picture?height=300" alt="" class="img-responsive" data-toggle="modal" data-target="#modal-<?php echo $friend_list['friends']['data'][$i]['id'];?>"/>

                    <p>録音準備: <span class="log">準備中</span></p>
                    <button class="like-btn btn btn-danger btn-large btn-block">告白する</button>
                    <button class="call-disconnect like-btn btn btn-info btn-large btn-block">切断</button>
                    <button class="button1 btn btn-warning btn-large btn-block">ありがとう</button>
                    <button class="button2 btn btn-success btn-large btn-block">ごめんなさい</button>
                    <div class="like-delete">
                        <?php echo in_array($friend_list['friends']['data'][$i]['id'], $like_user_ids) ? "<button class='like-delete-btn btn btn-large btn-block'>告白を削除</button>" : ""; ?>
                    </div>
                    <div class="like-message">
                        <?php echo in_array($friend_list['friends']['data'][$i]['id'], $like_user_ids) ? '<dl class="dl-horizontal"><dt>告白</dt><dd>' . $this->Like->makeMessageHtml($facebookId, $friend_list['friends']['data'][$i]['id']) . '</dd></dl>' : ""; ?>
                    </div>
                    <div class="other-user-id" data-role="<?php echo $friend_list['friends']['data'][$i]['id'];?>"></div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
    <?php endif;?>
<?php endfor;?>
</div>

<!-- タイムラインを流しているユーザidを埋め込み -->
<div class="user-id" data-role="<?php echo $user['User']['facebook_num']; ?>"></div>
<!-- like-user-now -->
<div class="like-user-now" data-role=""></div>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<?php echo $this->Html->script('masonry.pkgd.min'); ?>
<?php echo $this->Html->script('caption'); ?>
<script type="text/javascript" src="http://static.twilio.com/libs/twiliojs/1.2/twilio.min.js"></script>
<script type="text/javascript">
/*
 * Twilioの通信部分
 */
Twilio.Device.setup("<?php echo $token; ?>");
var connection=null;

Twilio.Device.ready(function (device) {
    $(".log").text("準備完了");
});

Twilio.Device.error(function (error) {
    $(".log").text("Error: " + error.message);
});

Twilio.Device.connect(function (conn) {
    connection=conn;
    $(".log").text("成功");
    
    // 切断ボタンを表示
    $(".call-disconnect").show();
});

Twilio.Device.disconnect(function (conn) {
    $(".log").text("終了");
    fetchMessageStatus();

    /*
     *  マッチング時の返信ボタン
     */
    $(".button1").hide();
    $(".button2").hide();
    // 切断ボタンを表示
    $(".call-disconnect").hide();
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

// modalにmessageのDomを追加
function fetchMessageStatus() {
    var send_user_id = $(".user-id").data('role');
    var receive_user_id = $(".like-user-now").data('role');
    var url = "/manyheart/likes/message/" + send_user_id + "/" + receive_user_id;

    $.get(url, function(res){
        var modal_id = "#modal-" + $(".like-user-now").data('role');
        var $modal = $(modal_id);
        var message_url = $.parseJSON(res).message_url;

        console.log(message_url);
        $modal.find(".like-message").html("<dl class='dl-horizontal'><dt>告白</dt><dd><audio src='" + message_url + "' controls></audio></dd></dl>");
    });
}


(function($){
    /*
     *  マッチング時の返信ボタン
     */
    $(".button1").hide();
    $(".button2").hide();
    $(".call-disconnect").hide();

    /*
     * 通話の切断用のボタン
     */
    $(".call-disconnect").on("click", function () {
        hangup();
    });


    /*
     *  masonryの設定
     */
    $('.like-wrapper').masonry({
        itemSelector : '.like-box'
    });

    /*
     * PHONEボタンを押したときの処理
     */
    $.each(['0','1','2','3','4','5','6','7','8','9','star','pound'], function(index, value) {
        $('.button' + value).click(function(){
            if(connection) {
                if (value=='star') {
                    connection.sendDigits('*')
                } else if (value=='pound') {
                    connection.sendDigits('#')
                } else {
                    connection.sendDigits(value)
                }
                return false;
            }
        });
    });

    /*
     * LIKEボタンを押した時
     */
    $(".like-btn").on("click", function (){

        
        var user_id = $(".user-id").data('role');
        // TODO: リファクター
        var $other_user = $(this).parent().parent().parent().parent().parent();
        var other_user_id = $(this).parent().find(".other-user-id").data('role');

        // 現在クリックしているuserを記録
        $(".like-user-now").data('role', other_user_id);

        console.log("user-id: " + user_id);
        console.log("other-user-id: " +  other_user_id);

        $.ajax({
            type: "POST",
            url: "/manyheart/likes/check_matching_users",
            data: {
                send_user_id: user_id,
                receive_user_id: other_user_id 
            }
        }).done(function( res ) {
            var is_match = $.parseJSON(res)[0].match;
            var call_type = (is_match)? "listen" : "record"; 

            console.log("is_match: " +  is_match);
            console.log("call_type: " +  call_type);

            call({
                "type": call_type,
                "send": user_id,
                "receive": other_user_id
            });

            // 返信buttonをrender
            if (is_match) {
                $other_user.find(".button1").show();
                $other_user.find(".button2").show();
            } 

            // checkをrender
            fetchLikeStatus($other_user, user_id, other_user_id);

        }).fail(function(e) {
            console.log(e);
            alert( "error" );
        }); 
    });

    $(".like-delete-btn").on("click", function () {
        var user_id = $(".user-id").data('role');
        // TODO: リファクター
        var $other_user = $(this).parent().parent().parent().parent().parent().parent();
    
        console.log($other_user);
        var other_user_id = $(this).parent().parent().find(".other-user-id").data('role');
    
        console.log("user-id: " + user_id);
        console.log("other-user-id: " +  other_user_id);
    
        $.ajax({
            type: "POST",
            url: "/manyheart/likes/delete_like",
            data: {
                send_user_id: user_id,
                receive_user_id: other_user_id 
            }
        }).done(function( res ) {
    
            fetchLikeStatus($other_user, user_id, other_user_id);
    
        }).fail(function(e) {
            console.log(e);
            alert( "error" );
        }); 
    });

    // TODO: セキュアーにすべし
    // likeの状態確認 (send_user, receive_user)
    function fetchLikeStatus($like_box, send_user_id, receive_user_id) {
        var url = "/manyheart/likes/is_like_data/" + send_user_id + "/" + receive_user_id  

        $.get(url, function(res){
            var is_like = $.parseJSON(res)[0].is_like;

            if (is_like) {
                $like_box.find(".is-check-user").text("check");
                $like_box.find(".like-delete").html("<button class='like-delete-btn btn btn-large btn-block'>告白を削除</button>");
                // 再bind
                $(".like-delete-btn").on("click", function () {
                    var user_id = $(".user-id").data('role');
                    // TODO: リファクター
                    var $other_user = $(this).parent().parent().parent().parent().parent().parent();
                
                    console.log($other_user);
                    var other_user_id = $(this).parent().parent().find(".other-user-id").data('role');
                
                    console.log("user-id: " + user_id);
                    console.log("other-user-id: " +  other_user_id);
                
                    $.ajax({
                        type: "POST",
                        url: "/manyheart/likes/delete_like",
                        data: {
                            send_user_id: user_id,
                            receive_user_id: other_user_id 
                        }
                    }).done(function( res ) {
                
                        fetchLikeStatus($other_user, user_id, other_user_id);
                
                    }).fail(function(e) {
                        console.log(e);
                        alert( "error" );
                    }); 
                });
            }
            else {
                $like_box.find(".is-check-user").text("");
                $like_box.find(".like-delete").html("");
                $like_box.find(".like-message").html("");
            }

        });
    }

})(jQuery);
</script>

