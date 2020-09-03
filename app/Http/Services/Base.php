<?php

namespace App\Http\Services;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class Base extends Controller
{
    abstract static function dryRun(Request $request);
}
