<?php

namespace Hattori\ToDo;

use Hattori\ToDo\Models\Task;
use Hattori\ToDo\Models\Label;

trait ToDoRelationsTrait 
{
    public function tasks() {
        return $this->hasMany(Task::class);
    }

    public function labels() {
        return $this->hasMany(Label::class);
    }
}