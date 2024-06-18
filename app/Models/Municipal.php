<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\DataTable;

class Municipal extends Model
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
        'province_id',
        'region_id'
    ];

    public $update_rule = [
        'name' => 'string|nullable|max:255',
        'head_user_id' => 'alpha_dash|exists:users,id|max:255'
    ];

    public $joinTable = [
        "regions as r" => [
            "direction" => "left",
            "rel" => "region_id",
            "col" => [
                "name as region"
            ]
        ],
        "provinces as p" => [
            "direction" => "left",
            "rel" => "province_id",
            "col" => [
                "name as province"
            ]
        ],
        "users" => [
            "direction" => "left",
            "rel" => "head_user_id",
            "col" => [
                "name as municipal_head",
                "email as municipal_email"
            ]
        ]
    ];

    public function getRowByRegionId($region_id)
    {
        return $this->makeJoin($this, $this->joinTable ?? [])->where("{$this->getTable()}.region_id", $region_id)->first();
    }

    public static function isMunicipalHead($user_id)
    {
        $res = Municipal::where('head_user_id', $user_id)->count();
        return $res != 0;
    }

    public static function getRandomMunicipal()
    {
        $region = Region::offset(rand(0, 2))->orderByDesc('created_at')->first();
        return Municipal::where('region_id', $region['id'])->first();
    }

    protected function configAddon(&$model, $offset, $length, $search, $config)
    {
        if (!empty($config['region_id'])) {
            $model = $model->where('municipals.region_id', $config['region_id']);
        }

        if (!empty($config['province_id'])) {
            $model = $model->where('municipals.province_id', $config['province_id']);
        }

        $model = $model->orderBy('municipals.name');
    }
}
