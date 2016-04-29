<?php

namespace Gladiator\Http\Controllers;

use Gladiator\Http\Requests;
use Gladiator\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,staff');
    }

    public function index()
    {
        return view('settings.index');
    }

    public function indexCategory($category)
    {
        $items = Setting::where('category', $category)->get();

        // dd($items);

        return view('settings.' . $category . '.index', compact('category', 'items'));
    }

    public function editCategory($category, $key)
    {
        return view('settings.' . $category. '.edit');
    }
}
