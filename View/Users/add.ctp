<!-- File: /app/View/Users/add.ctp -->

<h1>Add User</h1>
<?php
echo $this->Form->create('User');
echo $this->Form->input('facebook_num');
echo $this->Form->input('name', array('readonly' => 'readonly'));
echo $this->Form->input('gender', array('readonly' => 'readonly'));
echo $this->Form->input('phone_number');
echo $this->Form->end('Save User');
?>
