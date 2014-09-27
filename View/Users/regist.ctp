<!-- File: /app/View/Users/index.ctp -->

<h1>users</h1>

<?php echo $this->Html->link(
    'Add User',
    array('controller' => 'users', 'action' => 'add')
); ?>

<table>
    <tr>
        <th>Id</th>
        <th>name</th>
        <th>action</th>
        <th>Created</th>
    </tr>

    <!-- ここから、$users配列をループして、投稿記事の情報を表示 -->

    <?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo $user['User']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($user['User']['name'],
array('controller' => 'users', 'action' => 'view', $user['User']['id'])); ?>
        </td>
        <td>
            <?php echo $this->Form->userLink(
                'Delete',
                array('action' => 'delete', $user['User']['id']),
                array('confirm' => 'Are you sure?'));
            ?>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id'])); ?>
        </td>
        <td><?php echo $user['User']['created']; ?></td>
        <td></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($user); ?>
</table>

