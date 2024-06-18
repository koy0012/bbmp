<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\DataTable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, DataTable;

    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'regional_id',
        'municipal_id',
        'barangay_id',
        'role',
        'state',
        'profile',
        'username',
        'order',
        'updated_at',
        'last_active'
    ];

    public $updatable = [
        "role",
        "name",
        "municipal_id",
        "regional_id",
        "barangay_id"
    ];

    public $rules_update = [
        "role" => "nullable|in:member,municipal,regional,national,provincial,barangay",
        "name" => "nullable|alpha_space|max:255",
        "username" => "nullable|alpha_num|max:20",
        "municipal_id" => "nullable|alpha_dash|max:255",
        "regional_id" => "nullable|alpha_dash|max:255",
        "barangay_id" => "nullable|alpha_dash|max:255"
    ];

    protected $searchable = [
        'email',
        'username',
        'name',
        'role',
        'state'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $joinTable = [
        "user_info" => [
            "direction" => "left",
            "rel" => "id",
            "pointer" => "user_id",
            "col" => [
                'user_id',
                'position',
                'address',
                'birthday',
                'birthplace',
                'civil_status',
                'nationality',
                'contact_number',
                'voters_id',
                'precinct',
                'company_name',
                'company_position',
                'affiliations',
                'educational_attainment',
                'special_skills',
                'remarks',
                'referred_by',
                'encoded_by',
                'approved_by',
                'id as info_id',
                'sub_group',
                'updated_at as info_updated_at',
                'endorsed_by'
            ]
        ],
        "regions" => [
            "direction" => "left",
            "rel" => "regional_id",
            "col" => [
                "name as region"
            ]
        ],
        "municipals" => [
            "direction" => "left",
            "rel" => "municipal_id",
            "col" => [
                "name as municipal"
            ]
        ],
        "barangays" => [
            "direction" => "left",
            "rel" => "barangay_id",
            "col" => [
                "name as barangay"
            ]
        ],
        "users as t" => [
            "direction" => "left",
            "rel" => "user_info.approved_by",
            "col" => [
                "name as approver"
            ]
        ],
        "users as d" => [
            "direction" => "left",
            "rel" => "user_info.encoded_by",
            "col" => [
                "name as encoder"
            ]
        ], 
        "groups" => [
            "direction" => "left",
            "rel" => "user_info.sub_group",
            "col" => [
                "name as sub_group_name",
                "short_name as sub_group_short"
            ]
        ]
    ];

    protected function configAddon(&$model, $offset, $length, $search, $config)
    {
        //warning: if you uncomment this database will tremendously slow down on production
        // $model = $model->orderBy('users.state', 'asc')->orderBy('users.created_at', 'desc');
        // $model = $model->orderBy('users.created_at', 'desc');

        if (!empty($config['municipal_id'])) {
            $model = $model->where('users.municipal_id', $config['municipal_id']);
        }

        if (!empty($config['region_id'])) {
            $model = $model->where('users.regional_id', $config['region_id']);
        }

        if (!empty($config['barangay_id'])) {
            $model = $model->where('users.barangay_id', $config['barangay_id']);
        }

        if (!empty($config['role'])) {
            $model = $model->where('users.role', $config['role']);
        }

        if (!empty($config['status'])) {
            $model = $model->where('users.state', $config['status']);
        }
    }

    public function getPendingCount($municipal_id = '')
    {
        $model = $this->where('state', 'pending');
        if (!empty($municipal_id)) {
            $model = $model->where('municipal_id', $municipal_id);
        }

        return $model->count();
    }

    public function verify($id, $encoder_id)
    {
        $info =  UserInfo::where('user_id', $id)->first();

        if (!empty($info['approved_by'])) {
            return true;
        }

        $user = User::find($id);
        $update = [];

        switch ($user['state']) {
            case "pending":
                $user->update(['state'], 'approved');
                break;
        }

        $update['approved_by'] = $encoder_id;
        $res = $info->update($update);

        return $res;
    }

    public function verifyAll($ids, $encoder_id)
    {
        foreach ($ids as $id) {
            $this->verify($id, $encoder_id);
        }
    }

    public static function updatePing($user_id){  
        User::where('id',$user_id)
            ->update([
                'last_active' => date("Y-m-d H:i:s")
            ]); 
    }

    public static function getAllActive($config){
        $province_id = $config["province_id"] ?? "";
        $municipal_id = $config["municipal_id"] ?? "";
        $groups = $config["groups"] ?? [];

        $province = Province::find($province_id);
        $region_id =  $province['region_id'] ?? "";  

        $offline_threshold = env("OFFLINE_THRESHOLD") ?? 60000; 
        $offline_threshold = $offline_threshold/1000;

        $datetime = date("Y-m-d H:i:s",strtotime("-$offline_threshold sec"));

        $res = User::select(
            "users.*",
            "provinces.name as province",
            "provinces.id as province_id",
            "municipals.name as municipal"
            )->where("last_active",">=","$datetime")->limit(80);
        $res = $res->join('municipals','users.municipal_id','=','municipals.id');
        $res = $res->join('provinces','municipals.province_id','=','provinces.id');
        $res = $res->join('user_info','user_info.user_id','=','users.id');

        if(!empty($province)){
            $res = $res->where('provinces.id',$province_id);
        }
        
        if(!empty( $municipal_id)){ 
            $res = $res->where('municipal_id',$municipal_id); 
        }   

        if(!empty($groups)){
            $res = $res->whereIn('user_info.sub_group',$groups); 
        }
        
        return $res->get();
    }

    public static function hasTargetReferrer($target_referrer,$referred_by, $break_point = 5){
        if(strcmp($target_referrer,$referred_by) == 0){
            return true;
        }

        $count = $break_point;

        do {
            $model = UserInfo::select("referred_by")
            ->where("user_id",$referred_by)->first();

            if(!empty($model["referred_by"]) && strcmp($target_referrer,$model["referred_by"]) == 0){
                return true;
            }
            $count--;
        } while(!empty($model["referred_by"]) && $count > 0);

        return false;
    }
}
