<?php

namespace Gladiator\Http\Controllers\Settings;

use Gladiator\Http\Requests;
use Gladiator\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessagesSettingsController extends Controller
{
    public function index()
    {
        return view('settings.messages.index');
    }
}
