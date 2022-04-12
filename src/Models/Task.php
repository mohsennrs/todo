<?php

namespace Hattori\ToDo\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'status'];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function labels() {
        return  $this->belongsToMany(Label::class, 'label_task', 'task_id', 'label_id');
    }
}
