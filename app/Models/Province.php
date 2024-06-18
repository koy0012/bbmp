<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\DataTable;

class Province extends Model
{
    use HasFactory, DataTable;

    protected $keyType = 'string';
    public $incrementing = false;

    public $searchable = [
        'name',
        'head_user_id'
    ];

    public $fillable = [
        'name',
        'head_user_id',
        'region_id'
    ];

    public $joinTable = [
        "regions" => [
            "direction" => "left",
            "rel" => "region_id",
            "col" => [
                "name as region"
            ]
        ],
        "users as u" => [
            "direction" => "left",
            "rel" => "head_user_id",
            "col" => [
                "name as province_head"
            ]
        ]
    ];

    protected function configAddon(&$model, $offset, $length, $search, $config)
    {
        if (!empty($config['region_id'])) {
            $model = $model->where('region_id', $config['region_id']);
        }
        
        $model->orderBy('provinces.name');
    }
}
