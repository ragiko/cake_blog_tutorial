<h2>マイページ</h2>
<img src="https://graph.facebook.com/<?php echo $facebookId;?>/picture?width=150" alt="" />
<p><?php echo $user['User']['gender']; ?></p>
<p><?php echo $user['User']['name']; ?></p>
<p><?php echo $this->Html->link('トップページ', ['controller' => 'pages', 'action' => 'top']); ?></p>
<p><?php echo $this->Html->link('ログアウト', ['controller' => 'users', 'action' => 'logout']); ?></p>
