<?php


namespace App;


use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Str;

class ActiveTest extends Model {

    use SoftDeletes;

    protected $table = 'active_testings';

    protected $dates = [
        'deleted_at'
    ];

    protected $hidden = [
        'deleted_at',
    ];

    protected $casts = [
        'start_time' => 'datetime:Y-m-d H:i:s',
        'end_time' => 'datetime:Y-m-d H:i:s'
    ];

    public $timestamps = false;

    public function testing() {
        return $this->belongsTo(Testing::class, 'testing_id')->withDefault();
    }

    public function creator() {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function results() {
        return $this->hasMany(Result::class, 'activate_id')
            ->where('completion_time', '!=', null)
            ->get();
    }


    public function getEndDateTime() {
        $attr = $this->attributes['end_time'];
        if ($attr == null)
            return '–';

        return date('Y-m-d H:i', strtotime($this->attributes['end_time']));
    }

    public function isActive():bool {
        return $this->end_time == null || $this->end_time > Carbon::now();
    }

    public function generateUniqueAccessCode():string {
        do {
            $hash = Str::random(rand(6, 10));
        } while (!empty(ActiveTest::where('access_code', $hash)->first()));
        return $hash;
    }
}
