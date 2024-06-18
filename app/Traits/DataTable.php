<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

trait DataTable
{

    public static function list($search, $offset = 0, $length = 10, $config)
    {
        $length = max(1, min(100, $length));
        $modelName = static::class;
        $model = app($modelName);

        //throw exception if mtype is used in config, only shows on local env
        if(isset($config['mtype']) && env('APP_ENV') == 'local'){
            throw new \Exception("config.mtype is a reserve config");
        }

        $config['mtype'] = 'data';
        $data = $model->getRecordsTotal($model, $offset, $length, $search, $config);

        $config['mtype'] = 'total';
        $filter_data = $model->getRecordsFiltered($model, $offset, $length, $search, $config);

        $model->postList($data,$offset,$length,$search,$config);

        return [
            'search' => $search,
            'data' => $data,
            'recordsTotal' => count($data),
            'recordsFiltered' => $filter_data
        ];
    }

    //overridable
    protected function postList(&$data,$offset, $length, $search, $config){

    }

    public function getRecordsFiltered($model, $offset, $length, $search, $config)
    {  
        $model->configAddon($model, $offset, $length, $search, $config);   
        
        return $model->count() ?? 0;
    }

    public function makeSearch($model,$table,$columns,$search)
    {
        $model->where(function ($query) use ($table,$columns,$search) {
            foreach ($columns as $column) {
                $query->orWhere("{$table}.{$column}", 'LIKE', "%$search%");
            }
        });
    }

    public function getRecordsTotal($model, $offset, $length, $search, $config)
    {
        $model_data = $model
            ->makeJoin($model, $model->joinTable ?? [])
            ->offset($offset)
            ->limit($length);

        if (!empty($search) && !empty($model->searchable)) {
            $this->makeSearch($model_data,$model->getTable(),$model->searchable ?? [],$search); 
        }

        $model->configAddon($model_data, $offset, $length, $search, $config);
 

        // echo $model_data->toSql(); die();
        return $model_data->get();
    }

    //overidable
    /*
    $config - config has additional type

    */
    protected function configAddon(&$model, $offset, $length, $search, $config)
    {
    }

    protected function getAlias($name)
    {
        $pieces = explode(" ", $name);
        if (count($pieces) == 3) {
            return $pieces[2];
        } else {
            return $name;
        }
    }

    protected function getColumn($table, $key)
    {
        if (count(explode(".", $key['rel'])) == 1) {
            return "{$table}.{$key['rel']}";
        } else {
            return $key['rel'];
        }
    }

    public function makeJoin(Model $model, $join_data)
    {
        $main_column = "{$model->getTable()}.{$model->getKeyName()}";
        $table = $model->getTable();

        $arr = $this->makeSelect($model->getTable(), [$model->getKeyName(), ...$model->fillable]);

        foreach ($join_data as $row => $key) {
            $alias = $this->getAlias($row);
            $arr = array_merge($arr, $this->makeSelect($alias, $key['col']));
            $model = $model->select($arr);
        }

        foreach ($join_data as $row => $key) {
            $key['pointer'] = $key['pointer'] ?? 'id';
            $alias = $this->getAlias($row);

            if (count(explode(".", $key['rel']))) {
            }

            $model = $model->leftJoin($row, "{$this->getColumn($table,$key)}", '=', "{$alias}.{$key['pointer']}");
        }

        return $model;
    }

    public function makeSelect($table, array $data)
    {
        foreach ($data as &$row) {
            $row = "{$table}.{$row}";
        }

        return $data;
    }

    public function getRow($id, $where_column = null)
    {
        if(empty($where_column)){
            $where_column = "{$this->getTable()}.{$this->getKeyName()}";
        }

        return $this->makeJoin($this, $this->joinTable ?? [])->where($where_column, $id)->first();
    } 
}
