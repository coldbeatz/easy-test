<?php

namespace App\Http\Controllers;

use App\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultsController extends Controller {

    public function index() {
        return view("results", [
            'results' => Result::where('user_id', Auth::user()->id)
                ->orderBy('start_time', 'DESC')
                ->paginate(15)
        ]);
    }
}
