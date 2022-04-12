<?php

namespace Hattori\ToDo\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $fillable = ['text'];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function tasks() {
        return  $this->belongsToMany(Task::class, 'label_task', 'label_id', 'task_id');
    }
}
