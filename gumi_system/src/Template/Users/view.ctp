<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?php
            $role = $this->request->session()->read('Auth.User.role');
            if($role == 'admin' || $role == 'edu_admin'){
                echo $this->Html->link(__('List Users'), ['action' => 'index']);
            }?></li>
        <li><?= $this->Html->link(__('List Groups'), [
            'controller' =>'Groups',
            'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('List Students'), [
            'controller' =>'Students',
            'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('List Courses'), [
            'controller' =>'Courses',
            'action' => 'index']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= $user->username ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <!-- <tr>
            <th><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr> -->
        <tr>
            <th><?= __('Role') ?></th>
            <td><?= h($user->role) ?></td>
        </tr>
        <!-- <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr> -->
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
    </table>
</div>
