<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;

class WxMsgTempController extends Controller
{

    protected $model = 'wx_msg_temp';

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
                'applicationId' => 'required|exists:applications,id',
                'tempId' => 'required',
                'dataJson' => 'required|json',
                'mapJson' => 'required|json',
                'name' => 'required',
            ];
            $isUpdate && $this->rules['id'] = 'exists:' . $this->table();
            $this->vld();
            return request('id') ? $this->update() : $this->store();
        }
        return $this->view('edit', ['d' => request('id') ? $this->builder()->find(request('id')) : null]);
    }

    private function store()
    {
        $this->vld();
        $item = $this->builder()->newModelInstance(request()->only(array_keys($this->rules)));
        $item->save();
        return $this->viewOk('edit');
    }

    private function update()
    {
        $this->vld();
        $item = $this->builder()->find(request('id'));
        $item->fill(request()->only(array_keys($this->rules)));
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
