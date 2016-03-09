<?php

namespace Gladiator\Http\Controllers;

use Gladiator\Models\Contest;
use Gladiator\Http\Requests\ContestRequest;
use Gladiator\Http\Requests;

class ContestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contests = Contest::all();

        return view('contest.index', compact('contests'));
    }
}
