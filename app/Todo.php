<?php

namespace PageLab\ServerMail;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    /**
     * Fields for mass assignable
     *
     * @var array
     */
    protected $fillable = ['title'];
}
