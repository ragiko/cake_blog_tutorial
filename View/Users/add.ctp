<!-- File: /app/View/Users/add.ctp -->

<h1>ユーザの登録</h1>
<?php
echo $this->Form->create('User');
echo $this->Form->hidden('facebook_num');
echo $this->Form->input('name', array('readonly' => 'readonly'));
echo $this->Form->input('gender', array('readonly' => 'readonly'));
echo $this->Form->input('phone_number');
echo $this->Form->end('登録');
?>
