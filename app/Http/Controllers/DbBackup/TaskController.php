<?php

namespace App\Http\Controllers\DbBackup;

use App\Http\Controllers\Controller;
use App\Models\DbBackup\Task;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    protected $model = 'db-backup_task';

    public function list()
    {
        $builder = $this->mSearch($this->builder())->with(['conn', 'database']);
        return $this->view('list', ['l' => $builder->paginate()]);
    }

    public function edit()
    {
        if (request()->isMethod('get')) {
            return $this->view('edit', ['d' => request('id') ? $this->builder()->find(request('id')) : null]);
        }
        $this->rules = [
            'connectionId' => 'required|exists:db_backup_connections,id',
            'databaseId' => 'exists:db_backup_databases,id',
            'name' => 'required',
            'saveType' => ['required', Rule::in(Task::SAVE_TYPES)],
            'backupKeepCount' => 'required|int|min:0',
            'backupInterval' => 'required|int|min:0',
            'on' => 'required|bool',
            'ignoreDatabases' => 'json',
            'ignoreTables' => 'json',
        ];
        $isUpdate = request()->filled('id');
        $isUpdate && $this->rules['id'] = 'exists:' . $this->table();
        $this->vld();
        return $isUpdate ? $this->update() : $this->store();
    }

    public function update()
    {
        $item = $this->builder()->find(request('id'));
        $item->fill(request()->only(array_keys($this->rules)));
        $item->ignoreDatabases = json_decode($item->ignoreDatabases);
        $item->ignoreTables = json_decode($item->ignoreTables);
        $item->save();
        return $this->viewOk('edit', ['d' => $item]);
    }

    public function store()
    {
        $item = new Task(request()->only(array_keys($this->rules)));
        $item->ignoreDatabases = json_decode($item->ignoreDatabases);
        $item->ignoreTables = json_decode($item->ignoreTables);
        $item->save();
        return $this->directOk('list');
    }

}