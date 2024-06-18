<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\DataTable;

class Region extends Model
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
        'head_user_id'
    ];

    public $joinTable = [
        "users as u" => [
            "direction" => "left",
            "rel" => "head_user_id",
            "col" => [
                "name as region_head"
            ]
        ]
    ];

    protected function configAddon(&$model, $offset, $length, $search, $config)
    {
        $model->orderBy('regions.order');
    }
}
