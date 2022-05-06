<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Testing extends Model {

    use SoftDeletes;

    protected $table = 'testings';

    protected $fillable = [
        'created_at',
        'updated_at'
    ];

    protected $dates = [
        'deleted_at'
    ];

    protected $hidden = [
        'creator_id', 'real_id', 'deleted_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:00',
        'updated_at' => 'datetime:Y-m-d H:00'
    ];

    public $timestamps = true;

    public static function create(string $title, string $description):Testing {
        $test = new Testing();

        $test->title = $title;
        $test->description = $description;
        $test->creator_id = Auth::id();

        $test->regenerateRealId();
        return $test;
    }

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

    public function regenerateRealId():void {
        do {
            $id = Str::random(16);
            $testing = Testing::where('real_id', $id)->get();
        } while (!$testing->isEmpty());

        $this->real_id = $id;
    }
}
