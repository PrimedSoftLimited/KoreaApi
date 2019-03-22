<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $primaryKey = 'tid';

    protected $fillable = [
        'taskname', 'completed',
    ];

    public function goal()
    {
        return $this->belongsTo('App\Goal');
    }
}
