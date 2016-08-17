<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Course'), ['action' => 'edit', $course->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Course'), ['action' => 'delete', $course->id], ['confirm' => __('Are you sure you want to delete this course?')]) ?> </li>
        <li><?= $this->Html->link(__('List Courses'), ['action' => 'index']) ?> </li>
    </ul>
</nav>
<div class="courses view large-9 medium-8 columns content">
    <h3><?= h($course->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Teacher') ?></th>
            <td><?= $course->has('user') ? $this->Html->link($course->user->name, ['controller' => 'Users', 'action' => 'view', $course->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Student') ?></th>
            <td><?= $course->has('student') ? $this->Html->link($course->student->name, ['controller' => 'Students', 'action' => 'view', $course->student->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Weekday') ?></th>
            <td><?= h($course->weekday) ?></td>
        </tr>
        <tr>
            <th><?= __('Start Time') ?></th>
            <td><?= h($course->start_time->format('H:i')) ?></td>
        </tr>
        <tr>
            <th><?= __('End Time') ?></th>
            <td><?= h($course->end_time->format('H:i')) ?></td>
        </tr>
        <tr>
            <th><?= __('Remarks') ?></th>
            <td><?= h($course->remarks) ?></td>
        </tr>
    </table>
</div>
