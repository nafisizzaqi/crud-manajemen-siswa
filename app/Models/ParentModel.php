<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    protected $table = 'parent_models';
    protected $fillable = ['name', 'student_id'];

    public function student()
    {
        return $this->belongsTo(StudentModel::class, 'student_id');
    }
}
