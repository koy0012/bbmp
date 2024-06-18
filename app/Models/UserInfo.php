<?php

namespace App\Models;

use App\Traits\DataTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory, DataTable;

    protected $table = 'user_info';

    protected $joinTable = [
        "users as d" => [
            "direction" => "left",
            "rel" => "encoded_by",
            "col" => [
                "name as encoder"
            ]
        ],
        "users as t" => [
            "direction" => "left",
            "rel" => "referred_by",
            "col" => [
                "name as referrer"
            ]
        ],
        "users as z" => [
            "direction" => "left",
            "rel" => "user_id",
            "col" => [
                "name",
                "profile"
            ]
        ], 
        "groups" => [
            "direction" => "left",
            "rel" => "sub_group",
            "col" => [
                "name as sub_group_name"
            ]
        ]
    ];

    public $rules_update = [
        'position' => 'nullable|alpha_space|max:255',
        'address' => 'nullable|alpha_space|max:255',
        'birthday' => 'nullable|date',
        'birthplace' => 'nullable|alpha_space|max:255',
        'civil_status' => 'nullable|in:single,married,divorced,widowed',
        'nationality' => 'nullable|text_space|max:255',
        'contact_number' => 'nullable|alpha_space|max:255',
        'voters_id' => 'nullable|alpha_dash|max:255',
        'company_name' => 'nullable|alpha_space|max:255',
        'company_position' => 'nullable|alpha_space|max:255',
        'affiliations' => 'nullable|alpha_space|max:255',
        'educational_attainment' => 'nullable|alpha_dash|max:255',
        'special_skills' => 'nullable|alpha_space|max:255',
        'remarks' => 'nullable|alpha_space|max:255',
        'sub_group' => 'nullable|alpha_dash|max:255',
        "precinct" => "nullable|alpha_dash|max:20"
    ];

    public $updatable = [
        'position',
        'sub_group',
        'address',
        'birthday',
        'birthplace',
        'civil_status',
        'nationality',
        'contact_number',
        'voters_id',
        'company_name',
        'company_position',
        'affiliations',
        'educational_attainment',
        'special_skills',
        'remarks',
        'precinct'
    ];

    protected $fillable = [
        'user_id',
        'position',
        'sub_group',
        'address',
        'birthday',
        'birthplace',
        'civil_status',
        'nationality',
        'contact_number',
        'voters_id',
        'company_name',
        'company_position',
        'affiliations',
        'educational_attainment',
        'special_skills',
        'remarks',
        'referred_by',
        'encoded_by',
        'approved_by',
        'precinct',
        'endorsed_by'
    ];

    public function getRowByUserId($user_id)
    {
        return $this->makeJoin($this, $this->joinTable ?? [])->where("{$this->getTable()}.user_id", $user_id)->first();
    }
}
