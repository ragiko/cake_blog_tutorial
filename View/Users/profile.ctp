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
        <li><a href="#">Profile</a></li>
        <li><?php echo $this->Html->link('Logout', [ 'controller' => 'users', 'action' => 'logout']); ?></li>
      </ul>
    </div>
  </div>
</div>


<div class="col-xs-3 my-profile" >
    <img src="https://graph.facebook.com/<?php echo $facebookId;?>/picture?width=150" alt="" />
    <h3><?php echo $user['User']['name']; ?> (<?php echo $user['User']['gender']; ?>)</h3>
</div>
<div class="col-xs-9" >
    <h2>相手からの告白ボイスリスト</h2>
    <div class="like-wrapper">
        <div class="row">
        <?php foreach ($matching_users as $user):?>
            <div class="like-box box pin col-xs-4" >
                <img src="https://graph.facebook.com/<?php echo $user['User']['facebook_num'];?>/picture?height=300" alt="" class="img-responsive" />
                <p><?php echo $user['User']['name']; ?></p>
                <a href="tel:<?php echo $user['User']['phone_number']; ?>">(<?php echo $user['User']['phone_number']; ?>)</a>
                <audio class="profile-message"src="<?php echo $user['Like']['message_url']; ?>" controls></audio>
            </div>
        <?php endforeach;?>
        </div>
    </div>
        
    <h2>自分の告白ボイスリスト</h2>
    <div class="like-wrapper">
        <div class="row">
        <?php foreach ($like_users as $user):?>
            <div class="like-box box pin col-xs-4" >
                <img src="https://graph.facebook.com/<?php echo $user['id'];?>/picture?height=300" alt="" class="img-responsive" />
                <p><?php echo $user['name']; ?></p>
                <audio class="profile-message" src="<?php echo $user['message_url']; ?>" controls></audio>
            </div>
        <?php endforeach;?>
        </div>
    </div>
</div>

<?php echo $this->Html->script('masonry.pkgd.min'); ?>
<script>
/*
 *  masonryの設定
 */
$('.like-wrapper').masonry({
    itemSelector : '.like-box'
});
</script>
