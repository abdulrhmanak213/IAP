<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\SettingRequest;
use App\Http\Resources\Admin\Setting\SettingResource;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    // Returns System Settings
    public function index(): \Illuminate\Http\Response
    {
        $settings = $this->settingService->getAll();
        return self::returnData('settings', SettingResource::collection($settings));
    }

    // Updates System Settings
    public function store(SettingRequest $request): \Illuminate\Http\Response
    {
        $this->settingService->store($request->validated());
        return self::success('Success!');
    }
}
