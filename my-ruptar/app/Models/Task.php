<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name',
        'description',
        'due_date',
        'attachment',
    ];

    public function assignments()
    {
        return $this->hasMany(TaskAssignment::class);
    }
    
    protected static function boot()
{
    parent::boot();
    
    static::deleting(function($task) {
        $task->assignments()->delete();
    });
}

public function assignedStudents()
{
    return $this->hasManyThrough(Student::class, TaskAssignment::class, 'task_id', 'id', 'id', 'user_id');
}

}

