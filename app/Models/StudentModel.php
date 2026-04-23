<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentModel extends Model
{
    protected $table = 'students';
    protected $fillable = ['name', 'class_id'];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
