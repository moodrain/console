<?php

namespace App\Http\Controllers\Api;


use App\Models\JsonStorage;

class JsonStorageController extends Controller
{
    public function get()
    {
        $this->validate(request(), ['name' => 'required']);
        $applicationId = request('applicationId', 0);
        $json = JsonStorage::query()->where('application_id', $applicationId)->where('name', request('name'))->first();
        return rs($json ? $json->data : null);
    }

    public function set()
    {
        $this->validate(request(), [
            'name' => 'required',
            'key' => 'required',
            'value' => 'required',
        ]);
        $applicationId = request('applicationId', 0);
        $json = JsonStorage::query()->where('application_id', $applicationId)->where('name', request('name'))->first();
        if (! $json) {
            return rs(null, 'json not found', 1);
        }
        $data = $json->data;
        $data[request('key')] = request('value');
        $json->data = $data;
        $json->save();
        return rs();
    }

    public function increment()
    {
        $this->validate(request(), [
            'name' => 'required',
            'key' => 'required',
            'number' => 'required',
        ]);
        $applicationId = request('applicationId', 0);
        $json = JsonStorage::query()->where('application_id', $applicationId)->where('name', request('name'))->first();
        if (! $json) {
            return rs(null, 'json not found', 1);
        }
        $data = $json->data;
        $data[request('key')] = isset($data[request('key')]) ? $data[request('key')] + request('number') : (int) request('number');
        $json->data = $data;
        $json->save();
        return rs();
    }

    public function destroy()
    {
        $this->validate(request(), ['name' => 'required']);
        $applicationId = request('applicationId', 0);
        $json = JsonStorage::query()->where('application_id', $applicationId)->where('name', request('name'))->first();
        if (! $json) {
            return rs(null, 'json not found', 1);
        }
        $json->delete();
        return rs();
    }

}