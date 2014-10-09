<h1>topページ</h1>
<?php
echo $this->Form->create('Users', ['action' => 'login', 'method' => 'post']);
echo $this->Form->button('Facebookログイン');
?>

<?php echo $this->Html->link(
    'login',
    array('controller' => 'pages', 'action' => 'login')
); ?>

<?php echo $this->Html->link(
    'logout',
    array('controller' => 'pages', 'action' => 'top')
); ?>


