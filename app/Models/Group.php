<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\DataTable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, DataTable, SoftDeletes;
    
    protected $keyType = 'string';
    public $incrementing = false;

    protected $joinTable = [
        "regions" => [
            "direction" => "left",
            "rel" => "group_id",
            "col" => [
                'name as region'
            ]
        ]
    ];

    protected $fillable = [
        'name',
        'description',
        'group_id',
        'group_type',
        'short_name'
    ];

    protected $searchable = [
        'name',
        'description',
        'short_name'
    ];

    public $rules_create = [
        "group_id" => "required|alpha_dash|max:255",
        "name" => "required|string|max:255",
        "short_name" => "required|string|unique:groups,short_name|max:14",
        "description" => "nullable|string|max:255"
    ];

    protected function configAddon(&$model, $offset, $length, $search, $config)
    {
        $model->where('group_type', Region::class);
    }

    protected $hidden = [
        'group_type'
    ];
}
