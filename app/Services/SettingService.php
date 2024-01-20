<?php

namespace App\Services;

use App\Models\Setting;

class SettingService
{
    public function getSetting($key)
    {
        return Setting::query()->where('key', 'like', '%' . $key . '%')->firstOrFail()->value('value');
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Setting::all();
    }

    public function store($data)
    {
        $setting = Setting::query()->firstOrNew(['key' => $data['key']]);
        $setting->forceFill(['value' => $data['value']]);
        $setting->save();
    }
}
