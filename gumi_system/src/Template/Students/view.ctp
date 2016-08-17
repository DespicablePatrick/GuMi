<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?php
            $role = $this->request->session()->read('Auth.User.role');
            if($role == 'admin' || $role == 'edu_admin'){
                echo $this->Html->link(__('Edit Student Information'), ['action' => 'edit', $student->id]);
            }?></li>
        <li><?php
            $role = $this->request->session()->read('Auth.User.role');
            if($role == 'admin' || $role == 'edu_admin'){
                echo $this->Form->postLink(__('Delete Student'), ['action' => 'delete', $student->id], ['confirm' => __('Are you sure you want to delete {0}?', $student->name)]);
            }?></li>
        <li><?= $this->Html->link(__('List Students'), ['action' => 'index']) ?> </li>
    </ul>
</nav>
<div class="students view large-9 medium-8 columns content">
    <h3><?= h($student->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($student->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Group') ?></th>
            <td><?= $student->has('group') ? $this->Html->link($student->group->name, ['controller' => 'Groups', 'action' => 'view', $student->group->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($student->id) ?></td>
        </tr>
    </table>
</div>
