<!-- File: /app/View/Users/index.ctp -->

<h1>users</h1>

<?php echo $this->Html->link(
    'profile',
    array('controller' => 'users', 'action' => 'view/1')
); ?>

<table>
    <tr>
        <th>Id</th>
        <th>name</th>
        <th>age</th>
        <th>gender</th>
        <th>address</th>
        <th>photo</th>
        <th>Created</th>
    </tr>

    <!-- ここから、$users配列をループして、投稿記事の情報を表示 -->

    <?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo $user['User']['id']; ?></td>
        <td><?php echo $user['User']['name']; ?></td>
        <td><?php echo $user['User']['age']; ?></td>
        <td><?php echo $user['User']['gender']; ?></td>
        <td><?php echo $user['User']['address']; ?></td>
        <td>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id'])); ?>
        </td>
        <td><?php echo $user['User']['created']; ?></td>
        <td></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($user); ?>
</table>

