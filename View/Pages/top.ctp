<h1>ランディングページ</h1>
<?php
    echo $this->Form->create('Users', ['action' => 'login', 'method' => 'post']);
    echo $this->Form->button('Facebookログイン');
?>

