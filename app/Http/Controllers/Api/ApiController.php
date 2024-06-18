<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\CrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ApiController extends CrudController
{
    protected $baseLayout = "";
    protected $basePath = ''; 

    public function edit(string $id)
    {
    }
 
    public function show(string $id, Request $request)
    {
        $row = app($this->model)->getRow($id);

        if(empty($row)){
            abort(404);
        }

        return response()->json([ 
            'success' => true,
            'id' => $id,
            'data' => app($this->model)->getRow($id)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(app($this->model)->rules_create ?? $this->rules_create);

        $this->model::create($request->all());

        return response()->json([
            "success" => true
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(app($this->model)->rules_update ?? $this->rules_update);


        $arr = $request->all();
        $row_update = [];
        //filter request: only update what is allowed
        foreach (app($this->model)->updatable ?? app($this->model)->getFillable() as $row) {
            if (isset($arr[$row])) {
                $row_update[$row] = $arr[$row];
            }
        }

        $this->preUpdate($request, $row_update, $id);

        $res = app($this->model)::where(app($this->model)->getKeyName(), $id)->update($row_update);

        return response()->json([
            "success" => $res >= 1
        ]);
    }
}
