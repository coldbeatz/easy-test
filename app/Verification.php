<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Verification extends Model {

    public $timestamps = false;

    protected $fillable = [
        'hash'
    ];

    public function getUser() {
        return $this
            ->belongsTo(User::class, 'user_id')
            ->withDefault();
    }
}
