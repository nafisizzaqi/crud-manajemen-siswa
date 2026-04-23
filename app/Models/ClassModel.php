<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassModel extends Model
{
    use HasFactory;
    protected $table = 'class';
    protected $fillable = ['class_name'];

    public function students()
    {
        return $this->hasMany(StudentModel::class);
    }

    public function teacher()
    {
        return $this->hasOne(TeacherModel::class);
    }
}
