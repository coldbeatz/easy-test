<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model {

    protected $table = 'results';

    public $timestamps = false;

    protected $casts = [
        'start_time' => 'datetime:Y-m-d H:00',
        'completion_time' => 'datetime:Y-m-d H:00'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id')
            ->withDefault();
    }
}
