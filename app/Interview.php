<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    protected $fillable = [
        'title', 'slug', 'video', 'time', 'note',
    ];

    // table name
    protected $table = 'interview';
}
