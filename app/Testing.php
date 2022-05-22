<?php

namespace App;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Builder;
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
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
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

    public function activatedTestings() {
        return $this->hasMany(ActiveTest::class, 'testing_id')->orderBy('start_time', 'desc');
    }

    public function getActiveTestings() {
        return $this->history()->where(function (Builder $query) {
            return $query
                ->whereNull('end_time')
                ->orWhere('end_time', '>', Carbon::now());
        })->get();
    }

    public function getArchivedTestings() {
        return $this->history()
            ->where('end_time', '<=', Carbon::now())
            ->get();
    }
}
