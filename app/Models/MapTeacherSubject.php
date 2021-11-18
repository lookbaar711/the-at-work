<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class MapTeacherSubject extends Eloquent
{
    protected $connection = 'mongodb';
	protected $collection = 'map_teacher_subject';

    protected $fillable = [
        'members_id',
        'members_name',
        'aptitude_id',
        'subject_id',
    ];
}
