<div class="likes view">
<h2><?php echo __('Like'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($like['Like']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Send User Id'); ?></dt>
		<dd>
			<?php echo h($like['Like']['send_user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Receive User Id'); ?></dt>
		<dd>
			<?php echo h($like['Like']['receive_user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($like['Like']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($like['Like']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Like'), array('action' => 'edit', $like['Like']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Like'), array('action' => 'delete', $like['Like']['id']), array(), __('Are you sure you want to delete # %s?', $like['Like']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Likes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Like'), array('action' => 'add')); ?> </li>
	</ul>
</div>
