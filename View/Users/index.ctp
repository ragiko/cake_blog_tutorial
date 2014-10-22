<h2>マイページ</h2>
<img src="https://graph.facebook.com/<?php echo $facebookId;?>/picture?width=150" alt="" />
<p><?php echo $user['User']['gender']; ?></p>
<p><?php echo $user['User']['name']; ?></p>
<p><?php echo $this->Html->link('トップページ', ['controller' => 'pages', 'action' => 'top']); ?></p>
<p><?php echo $this->Html->link('ログアウト', ['controller' => 'users', 'action' => 'logout']); ?></p>

<h2>異性の顔</h2>
<div class="row like-wrapper">
<?php for($i=0; $i < count($friend_list['friends']['data']); $i++):?>
    <?php if($user['User']['gender'] != $friend_list['friends']['data'][$i]['gender']):?>
        <div class="like-box col-xs-3" >
            <!-- <a href="https://www.facebook.com/<?php echo $friend_list['friends']['data'][$i]['id'];?>"></a> -->
            <img src="https://graph.facebook.com/<?php echo $friend_list['friends']['data'][$i]['id'];?>/picture?height=300" alt="" class="img-responsive" />
            <p><?php echo $friend_list['friends']['data'][$i]['name'];?></p>
            <button data-toggle="modal" data-target="#modal-<?php echo $friend_list['friends']['data'][$i]['id'];?>">kwsk</button>
            <span class="is-check-user">
                <?php echo in_array($friend_list['friends']['data'][$i]['id'], $like_user_ids) ? "check" : ""; ?>
            </span>

            <!-- Modal -->
            <div class="modal fade" id="modal-<?php echo $friend_list['friends']['data'][$i]['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo $friend_list['friends']['data'][$i]['name'];?></h4>
                  </div>
                  <div class="modal-body">
                    <img src="https://graph.facebook.com/<?php echo $friend_list['friends']['data'][$i]['id'];?>/picture?height=300" alt="" class="img-responsive" data-toggle="modal" data-target="#modal-<?php echo $friend_list['friends']['data'][$i]['id'];?>"/>

                    <button class="like-btn">like</button>
                    <button class="button1">1</button>
                    <button class="button2">2</button>

                    <!-- 相手をcheckしていた時 -->
                    <span class="is-check-user">
                        <?php echo in_array($friend_list['friends']['data'][$i]['id'], $like_user_ids) ? "check" : ""; ?>
                    </span>
                    <span class="like-delete">
                        <?php echo in_array($friend_list['friends']['data'][$i]['id'], $like_user_ids) ? "<button class='like-delete-btn'>delete</button>" : ""; ?>
                    </span>
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
<h2 id="log"></h2>
<div class="user-id" data-role="<?php echo $user['User']['facebook_num']; ?>"></div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<?php echo $this->Html->script('masonry.pkgd.min'); ?>
<script type="text/javascript" src="http://static.twilio.com/libs/twiliojs/1.2/twilio.min.js"></script>
<script type="text/javascript">
/*
 * Twilioの通信部分
 */
Twilio.Device.setup("<?php echo $token; ?>");
var connection=null;

Twilio.Device.ready(function (device) {
    $("#log").text("架電待機");
});

Twilio.Device.error(function (error) {
    $("#log").text("Error: " + error.message);
});

Twilio.Device.connect(function (conn) {
    connection=conn;
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




(function($){
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
            var is_match = $.parseJSON(res)[0].match;
            var call_type = (is_match)? "listen" : "record"; 

            console.log("is_match: " +  is_match);
            console.log("call_type: " +  call_type);

            call({
                "type": call_type,
                "send": user_id,
                "receive": other_user_id
            });

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
            url: "/cake_blog_tutorial/likes/delete_like",
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
        var url = "/cake_blog_tutorial/likes/is_like_data/" + send_user_id + "/" + receive_user_id  

        $.get(url, function(res){
            var is_like = $.parseJSON(res)[0].is_like;

            if (is_like) {
                $like_box.find(".is-check-user").text("check");
                $like_box.find(".like-delete").html("<button class='like-delete-btn'>delete</button>");
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
                        url: "/cake_blog_tutorial/likes/delete_like",
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
            }
        });
    }
})(jQuery);
</script>

