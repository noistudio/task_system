<?php


namespace App\Http\Controllers\Api;


use App\Status;
use http\Client\Request;

class StatusesController extends \App\Http\Controllers\Controller
{


    public function index()
    {


        $get_status = request()->get("status");

        $statuses = Status::query()->where(function ($query) use ($get_status) {
            if (isset($get_status) and strlen($get_status) > 0) {
                $query->where("title", "like", "%" . $get_status . "%");
            }
        })->get();

        return response($statuses);
    }

    public function show($id)
    {
        return Status::findOrFail($id);
    }

    public function update($id)
    {
        $request = request();
        $status = Status::findOrFail($id);
        $status->update($request->all());

        return $status;
    }

    public function store()
    {
        $request = request();
        $status = Status::create($request->all());
        return $status;
    }

    public function destroy($id)
    {
        $status = Status::findOrFail($id);
        $status->delete();
        return '';
    }
}
