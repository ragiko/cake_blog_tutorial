<!-- File: /app/View/Users/view.ctp -->

<h1>PROFILE</h1>

<h1><?php echo h($user['User']['name']); ?></h1>

<p><small>Created: <?php echo $user['User']['created']; ?></small></p>

<p><?php echo h($user['User']['body']); ?></p>

<img src="<?php echo  DS  . "files/user/photo/" . $user['User']['id'] . DS . "big_".$user['User']['photo']?>" alt="">

<?php echo $this->Html->link(
    'edit',
    array('controller' => 'users', 'action' => 'edit/1')
); ?>

