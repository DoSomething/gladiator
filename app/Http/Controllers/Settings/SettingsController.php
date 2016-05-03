<?php

namespace Gladiator\Http\Controllers\Settings;

use Gladiator\Http\Requests;
use Gladiator\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Create new SettingsController instance.
     */
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
        if ($category === 'messages') {
            return (new MessagesSettingsController)->edit();
        }

        // @TODO: for when general settings with categories are added:
        // $settings = $this->settingRepository->getAllByCategory($category, true);
        // return view('settings.' . $category . '.index', compact('category', 'settings'));
    }
}
