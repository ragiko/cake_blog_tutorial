<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <?php echo $this->Html->link('Many Heart', ['class'=>'navbar-brand', 'controller' => 'users', 'action' => 'index']); ?>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li>
            <form class="navbar-form navbar-right">
                <input type="text" class="form-control" placeholder="Search...">
            </form>
        </li>
        <li><a href="#">Profile</a></li>
        <li><?php echo $this->Html->link('Logout', [ 'controller' => 'users', 'action' => 'logout']); ?></li>
      </ul>
    </div>
  </div>
</div>

<h2>マイページ</h2>
<img src="https://graph.facebook.com/<?php echo $facebookId;?>/picture?width=150" alt="" />
<p><?php echo $user['User']['gender']; ?></p>
<p><?php echo $user['User']['name']; ?></p>
<p><?php echo $this->Html->link('トップページ', ['controller' => 'users', 'action' => 'index']); ?></p>

<h2>相手からの告白ボイスリスト</h2>
<table class="table">
<?php foreach ($matching_users as $user):?>
    <tr>
        <th><img src="https://graph.facebook.com/<?php echo $user['User']['facebook_num'];?>/picture?height=300" alt="" class="img-responsive" /></th>
        <th><p><?php echo $user['User']['name']; ?></p></th>
        <th><audio src="<?php echo $user['Like']['message_url']; ?>" controls></audio></th>
    </tr>
<?php endforeach;?>
</table>

<h2>自分の告白ボイスリスト</h2>
<table class="table">
<?php foreach ($like_users as $user):?>
    <tr>
        <th><img src="https://graph.facebook.com/<?php echo $user['id'];?>/picture?height=300" alt="" class="img-responsive" /></th>
        <th><p><?php echo $user['name']; ?></p></th>
        <th><audio src="<?php echo $user['message_url']; ?>" controls></audio></th>
    </tr>
<?php endforeach;?>
</table>


