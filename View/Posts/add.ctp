<!-- File: /app/View/Posts/add.ctp -->

<h1>Add Post</h1>
<?php
echo $this->Form->create('Post', array('type' => 'file'));
echo $this->Form->input('title');
echo $this->Form->input('body', array('rows' => '3'));
echo $this->Form->input('Post.photo', array('type' => 'file'));
echo $this->Form->input('Post.photo_dir', array('type' => 'hidden'));
echo $this->Form->end('Save Post');
?>
