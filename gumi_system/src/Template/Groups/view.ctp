<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?php
            $role = $this->request->session()->read('Auth.User.role');
            if($role == 'admin' || $role == 'edu_admin'){
                echo $this->Html->link(__('Edit Group Information'), ['action' => 'edit', $group->id]);
            }?></li>
        <li><?php
            $role = $this->request->session()->read('Auth.User.role');
            if($role == 'admin' || $role == 'edu_admin'){
                echo $this->Form->postLink(__('Delete Group'), ['action' => 'delete', $group->id], ['confirm' => __('Are you sure you want to delete {0}?', $group->name)]);
            }?></li>
        <li><?= $this->Html->link(__('List Groups'), ['action' => 'index']) ?> </li>

    </ul>
</nav>
<div class="groups view large-9 medium-8 columns content">
    <h3><?= h($group->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($group->name) ?></td>
        </tr>
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $group->has('user') ? $this->Html->link($group->user->name, ['controller' => 'Users', 'action' => 'view', $group->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Week') ?></th>
            <td><?= h($group->week) ?></td>
        </tr>
        <tr>
            <th><?= __('Time Slot') ?></th>
            <td><?= h($group->time_slot) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($group->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Students') ?></h4>
        <?php if (!empty($group->students)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($group->students as $students): ?>
            <tr>
                <td><?= h($students->id) ?></td>
                <td><?= $this->Html->link($students->name, ['controller' => 'Students', 'action' => 'view', $students->id]) ?></td>
                <td class="actions">
                    <?= $this->Form->postLink(__('Remove from Group'), ['controller' => 'Groups', 'action' => 'remove', $group->id, $students->id], ['confirm' => __('Are you sure you want to remove {0}  from {1} ?', $students->name , $group->name)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
