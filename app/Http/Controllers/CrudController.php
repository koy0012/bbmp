<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CrudController extends BaseController
{
    protected $title_create = "";
    protected $title_update = "";
    protected $title_show = "";
    protected $model;
    protected $rules_create = [];
    protected $rules_update = [];
    protected $rules_list = [
        'search.value' => 'string|nullable|max:50',
        'draw' => 'numeric|nullable',
        'length' => 'numeric|between:0,100|nullable',
        'start' => 'numeric|nullable',
        'archive' => 'boolean|nullable'
    ];

    //use this if you won't be using the primary key provided in model
    protected $update_key_name = null;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->render('index', [
            'title' => $this->title
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return $this->render('create', [
            'title' => $this->title_create
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
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    { 
        $data = app($this->model)->getRow($id);

        if(empty($data)) abort(404);

        return $this->render('show', [
            'title' => $this->title_show,
            'id' => $id,
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = app($this->model)->getRow($id);
        if(empty($data)) abort(404);

        return $this->render('edit', [
            'title' => $this->title_update,
            'id' => $id,
            'data' => $data
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
            if (array_key_exists($row,$arr)) { 
                $row_update[$row] = $arr[$row];
            }
        } 

        $this->preUpdate($request, $row_update, $id);

        //Notice the first() method was called, the observers need it to trigger. 
        //@see: https://www.reddit.com/r/laravel/comments/12d7dz1/laravel_observers_whats_the_rule_of_thumb/
        $res = app($this->model)::where($this->update_key_name ?? app($this->model)->getKeyName(), $id)
            ->first()
            ->update($row_update);

        return response()->json([
            "success" => $res >= 1
        ]);
    }

    //overridable
    protected function preUpdate(Request $request, &$row_update, string $id){
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        if ($id == 'multiple') {
            app($this->model)::whereIn('id', $request->post('ids'))->delete();
            return response()->json([
                "message" => "all deleted",
                "success" => true,
                "data" => $request->post('ids'),
                "id" => $id
            ]);
        } else {
            $this->model::where('id', $id)->delete();
            return response()->json([
                "success" => true
            ]);
        }
    }

    public function list(Request $request)
    {
        $request->validate($this->rules_list);

        $search = $request->get('search')['value'] ?? '';

        $draw = $request->get('draw') ?? 0;
        $length = $request->get('length') ?? 10;
        $start = $request->get('start') ?? 0;

        $config = $request->get('config');

        $res = app($this->model)::list($search, $start, $length, $config);
        $res['draw'] = $draw;

        return response()->json($res);
    }
}
