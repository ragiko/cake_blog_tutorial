<h2>マイページ</h2>
<img src="https://graph.facebook.com/<?php echo $facebookId;?>/picture?width=150" alt="" />
<p><?php echo $user['User']['gender']; ?></p>
<p><?php echo $user['User']['name']; ?></p>

<h2>異性の顔</h2>
<?php for($i=0; $i < count($friend_list['friends']['data']); $i++):?>
    <?php if($user['User']['gender'] != $friend_list['friends']['data'][$i]['gender']):?>
        <a href="https://www.facebook.com/<?php echo $friend_list['friends']['data'][$i]['id'];?>">
            <img src="https://graph.facebook.com/<?php echo $friend_list['friends']['data'][$i]['id'];?>/picture?width=100&height=100" alt="" />
        </a>
    <?php endif;?>
<?php endfor;?>

<p><?php echo $this->Html->link('トップページ', ['controller' => 'pages', 'action' => 'top']); ?></p>
<p><?php echo $this->Html->link('ログアウト', ['controller' => 'users', 'action' => 'logout']); ?></p>


