<?php

namespace Gladiator\Http\Controllers;

use Gladiator\Http\Requests;
use Gladiator\Models\Setting;
use Gladiator\Services\Settings\SettingRepository;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    protected $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;

        $this->middleware('auth');
        $this->middleware('role:admin,staff');
    }

    public function index()
    {
        return view('settings.index');
    }

    public function indexCategory($category)
    {
        $settings = $this->settingRepository->getAllByCategory($category, true);

        return view('settings.' . $category . '.index', compact('category', 'settings'));
    }

    public function editCategory($category, $key)
    {
        return view('settings.' . $category. '.edit');
    }
}
