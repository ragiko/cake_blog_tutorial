<h1>topページ</h1>

<?php echo $this->Html->link(
    'login',
    array('controller' => 'pages', 'action' => 'login')
); ?>

<?php echo $this->Html->link(
    'logout',
    array('controller' => 'pages', 'action' => 'top')
); ?>


