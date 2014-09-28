<!-- File: /app/View/Users/add.ctp -->

<h1>Add User</h1>
<?php
echo $this->Form->create('User', array('type' => 'file'));
echo $this->Form->input('name');
echo $this->Form->input('age');
echo $this->Form->input('phone_number');
echo $this->Form->input('gender');
echo $this->Form->input('address', array('rows' => '3'));
echo $this->Form->input('body', array('rows' => '3'));
echo $this->Form->input('User.photo', array('type' => 'file'));
echo $this->Form->input('User.photo_dir', array('type' => 'hidden'));
echo $this->Form->end('Save User');
?>
