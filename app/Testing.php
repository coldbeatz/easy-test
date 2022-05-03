<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testing extends Model {

    use SoftDeletes;

    protected $table = 'testings';
    protected $fillable = ['created_at', 'updated_at'];
    protected $dates = ['deleted_at'];

    public $timestamps = true;

    public function creator() {
        return $this->belongsTo(User::class, 'creator_id')
            ->withDefault();
    }

    public function questions() {
        return $this->hasMany(Question::class, 'testing_id');
    }

    public static function getByRealId(string $realId):Testing {
        return Testing::where('real_id', $realId)->firstOrFail();
    }
}
