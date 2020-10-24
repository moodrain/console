<?php

namespace App\Http\Controllers\DbBackup;

use App\Http\Controllers\Controller;

class DatabaseController extends Controller
{
    protected $model = 'db-backup_database';

    public function list()
    {
        $builder = $this->mSearch($this->builder()->with('conn'));
        return $this->view('list', ['l' => $builder->paginate()]);
    }

    public function edit()
    {
        if (request()->isMethod('get')) {
            return $this->view('edit', ['d' => request('id') ? $this->builder()->find(request('id')) : null]);
        }
        $this->rules = [
            'connectionId' => 'required|exists:db_backup_connections,id',
            'name' => 'required',
        ];
        $isUpdate = request()->filled('id');
        $isUpdate && $this->rules['id'] = 'exists:db_backup_databases';
        $this->vld();
        return $isUpdate ? $this->update() : $this->store();
    }

    public function update()
    {
        $item = $this->builder()->find(request('id'));
        $item->fill(request()->only(array_keys($this->rules)));
        $item->save();
        return $this->viewOk('edit', ['d' => $item]);
    }

    public function store()
    {
        $item = $this->builder()->newModelInstance(request()->only(array_keys($this->rules)));
        $item->save();
        return $this->directOk('list');
    }

    public function destroy()
    {
        $this->vld([
            'id' => 'required_without:ids|exists:' . $this->table(),
            'ids' => 'required_without:id|array',
            'ids.*' => 'exists:' . $this->table() . ',id',
        ]);
        $ids = request('ids') ?? [];
        request('id') && $ids[] = request('id');
        $this->builder()->whereIn('id', $ids)->delete();
        return $this->backOk();
    }

}