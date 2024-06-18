<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\DataTable;

class Barangay extends Model
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
        'municipal_id',
        'head_user_id'
    ];

    public $joinTable = [
        "users as u" => [
            "direction" => "left",
            "rel" => "head_user_id",
            "col" => [
                "name as barangay_head"
            ]
        ],
        "municipals" => [
            "direction" => "left",
            "rel" => "municipal_id",
            "col" => [
                "name as municipal"
            ]
        ],
        "provinces" => [
            "direction" => "left",
            "rel" => "municipals.province_id",
            "col" => [
                "name as province"
            ]
        ],
        "regions" => [
            "direction" => "left",
            "rel" => "provinces.region_id",
            "col" => [
                "name as region"
            ]
        ]
    ];

    protected function configAddon(&$model, $offset, $length, $search, $config)
    {
        if (!empty($config['municipal_id'])) {
            $model = $model->where('barangays.municipal_id', $config['municipal_id']);
        }




        $model->orderBy('barangays.name');
    }

    public function getRecordsTotal(Barangay $model, $offset, $length, $search, $config)
    {
        $model_data = $model
            ->makeJoin($model, $model->joinTable ?? [])
            ->offset($offset)
            ->limit($length);

        if (!empty($search) && !empty($model->searchable)) {
            $this->makeSearch($model_data, $model->getTable(), $model->searchable ?? [], $search);
        }

        $model->configAddon($model_data, $offset, $length, $search, $config);


        $data = $model_data->get();

        if (!empty($config['list']) && $config['list'] == "public") {
            return $data->setHidden(['head_user_id', 'barangay_head']);
        } else {
            return $data;
        }
    }
}
