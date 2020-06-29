<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;

class JsonStorageController extends Controller
{

    protected $model = 'json_storage';

    public function list()
    {
        $builder = $this->mSearch($this->builder())->with('application');
        return $this->view('list', ['l' => $builder->paginate()]);
    }

    public function edit()
    {
        if (request()->isMethod('post')) {
            $isUpdate = request()->filled('id');
            $this->rules = [
                'applicationId' => 'exists:applications,id',
                'dataJson' => 'required|json',
                'token' => '',
            ];
            $this->rules['name'] = $isUpdate
                ? ['required', Rule::unique($this->table())->ignore(request('id'))]
                : 'required|unique:' . $this->table();
            $isUpdate && $this->rules['id'] = 'exists:' . $this->table();
            $this->vld();
            return request('id') ? $this->update() : $this->store();
        }
        return $this->view('edit', ['d' => request('id') ? $this->builder()->find(request('id')) : null]);
    }

    private function store()
    {
        $this->vld();
        $data = request()->only(array_keys($this->rules));
        $data['applicationId'] = $data['applicationId'] ?? 0;
        $item = $this->builder()->newModelInstance($data);
        $item->save();
        return $this->viewOk('edit');
    }

    private function update()
    {
        $this->vld();
        $item = $this->builder()->find(request('id'));
        $data = request()->only(array_keys($this->rules));
        $data['applicationId'] = $data['applicationId'] ?? 0;
        $item->fill($data);
        $item->save();
        return $this->viewOk('edit', ['d' => $item]);
    }

    public function destroy()
    {
        $this->rules = [
            'id' => 'required_without:ids|exists:' . $this->table(),
            'ids' => 'required_without:id|array',
            'ids.*' => 'exists:' . $this->table() . ',id',
        ];
        $this->vld();
        $ids = request('ids') ?? [];
        request('id') && $ids[] = request('id');
        $this->builder()->whereIn('id', $ids)->delete();
        return $this->backOk();
    }

}
