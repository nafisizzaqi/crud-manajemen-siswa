<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherModel extends Model
{
    protected $table = 'teachers';
    protected $fillable = ['name', 'class_id'];

    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }
}
