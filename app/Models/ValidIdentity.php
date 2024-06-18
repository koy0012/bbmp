<?php

namespace App\Models;

use App\Traits\DataTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidIdentity extends Model
{
    use HasFactory, DataTable;

    protected $fillable = [
        'user_id',
        'no',
        'type',
        'image'
    ];

    public $joinTable = [
        "users" => [
            "direction" => "left",
            "rel" => "user_id",
            "col" => [
                "name"
            ]
        ]
    ];

    protected function configAddon(&$model, $offset, $length, $search, $config)
    {
        if(isset($config['user_id'])){
            $model->where('user_id',$config['user_id']);
        }
    }

    public function getRowByUserId($user_id){
        return $this->makeJoin($this, $this->joinTable ?? [])->where("{$this->getTable()}.user_id",$user_id)->get();
    }

    protected function postList(&$data,$offset, $length, $search, $config){
        foreach($data as &$row){
            $row['type_name'] = config("constants.valid_ids.{$row['type']}","undefined");
        }
    }
}
