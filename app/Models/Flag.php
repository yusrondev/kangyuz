<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flag extends Model
{
    use HasFactory;

    protected $with = ['task'];

    public function task()
    {
        return $this->hasMany(Task::class)->where('tasks.status', '!=', 'deleted');
    }
}
