<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Course Entity
 *
 * @property string $id
 * @property int $user_id
 * @property int $student_id
 * @property string $weekday
 * @property string $time_slot_odd
 * @property string $time_slot_even
 * @property string $remarks
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Student $student
 */
class Course extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
