<?php

namespace App\Http\Controllers;

class LogController extends Controller
{
    protected $model = 'log';

    public function list()
    {
        $builder = $this->mSearch($this->builder())->with('application')->latest();
        return $this->view('list', ['l' => $builder->paginate()]);
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