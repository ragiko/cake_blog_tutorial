<div class="likes form">
<?php echo $this->Form->create('Like'); ?>
	<fieldset>
		<legend><?php echo __('Edit Like'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('send_user_id');
		echo $this->Form->input('receive_user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Like.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Like.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Likes'), array('action' => 'index')); ?></li>
	</ul>
</div>
