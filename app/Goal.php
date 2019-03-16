<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{

    protected $primaryKey = 'gid';

    protected $fillable = [
        'goalname', 'goalbody',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
