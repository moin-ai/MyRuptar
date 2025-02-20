<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskAssignment extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'assigned_at',
        'completed_at',
        'proof',
    ];

    protected $dates = [
        'assigned_at',
        'completed_at'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'user_id');
    }
}
