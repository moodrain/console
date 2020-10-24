<?php

namespace App\Http\Controllers\DbBackup;

use App\Http\Controllers\Controller;
use App\Models\DbBackup\Connection;
use Illuminate\Validation\Rule;

class ConnectionController extends Controller
{
    protected $model = 'db-backup_connection';

    public function list()
    {
        $builder = $this->mSearch($this->builder());
        return $this->view('list', ['l' => $builder->paginate()]);
    }

    public function edit()
    {
        if (request()->isMethod('get')) {
            return $this->view('edit', ['d' => request('id') ? $this->builder()->find(request('id')) : null]);
        }
        $this->rules = [
            'host' => 'required',
            'name' => 'required',
            'username' => 'required',
            'driver' => ['required', Rule::in(Connection::DRIVERS)],
        ];
        $isUpdate = request()->filled('id');
        $isUpdate && $this->rules['id'] = 'exists:db_backup_connections';
        ! $isUpdate && $this->rules['password'] = 'required';
        $this->vld();
        return $isUpdate ? $this->update() : $this->store();
    }

    public function update()
    {
        $item = $this->builder()->find(request('id'));
        $item->fill(request()->only(array_keys($this->rules)));
        request('password') && $item->password = encrypt(request('password'));
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
            'id' => ['required_without:ids|exists:' . $this->table(), 'unique:db_backup_databases,connection_id'],
            'ids' => 'required_without:id|array',
            'ids.*' => ['exists:' . $this->table() . ',id', 'unique:db_backup_databases,connection_id'],
        ]);
        $ids = request('ids') ?? [];
        request('id') && $ids[] = request('id');
        $this->builder()->whereIn('id', $ids)->delete();
        return $this->backOk();
    }

}