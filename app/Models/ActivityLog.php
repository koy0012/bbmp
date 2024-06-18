<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\DataTable;

//todo: secure changes column, make it hidden on members 
class ActivityLog extends Model
{
    use HasFactory, DataTable;

    public $searchable = [
        'log',
        'user_id',
        'type'
    ];

    protected $joinTable = [
        "users as a" => [
            "direction" => "left",
            "rel" => "user_id",
            "col" => [
                "name"
            ]
        ],
        "users as b" => [
            "direction" => "left",
            "rel" => "modifier",
            "col" => [
                "name as modifier_name"
            ]
        ]
    ];

    public $fillable = [
        'log',
        'user_id',
        'type',
        'modifier',
        'changes',
        'created_at',
        'ref_one',
        'ref_two'
    ];

    public static function log(
        string $user_id,
        string $content,
        string $type,
        string $changes = null,
        string $modifier = null,
        array $other = []
    ) {

        $data = [
            'user_id' => $user_id,
            'log' => $content,
            'type' => $type,
            'changes' => $changes,
            'modifier' => $modifier
        ];

        $data = array_merge($data,$other);


        ActivityLog::create($data);
    }

    public static function filler(string $content, array $fillers){
        foreach($fillers as $fill => $key){ 
            $content = str_replace(":{$fill}",$key,$content);
        }

        return $content;
    }

    public static function recent($user_id, $limit = 5,array $where_array = null)
    {
        $log = app(ActivityLog::class);

        $model = $log->makeJoin($log, $log->joinTable ?? []);

        if(!empty($where_array)){
            $model = $model->where($where_array);
        }
        if(!empty($user_id)){
            $model = $model->where('user_id', $user_id);
        }

        $data = $model
            ->limit($limit)
            ->orderByDesc('created_at')
            ->get();

        foreach($data as &$row){
            $row['log'] = ActivityLog::filler($row['log'],[
                'user' => $row['name'],
                'modifier' => $row['modifier_name'],
            ]);  
        }

        return $data;
    }

    function configAddon(&$model, $offset, $length, $search, $config)
    {
        $model->orderBy('activity_logs.created_at', 'desc');

        if (isset($config['user_id'])) {
            $model = $model->where('user_id', $config['user_id']);
        }
    }
}
