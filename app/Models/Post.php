<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\DataTable;

class Post extends Model
{
    use HasFactory, DataTable;

    public $searchable = [
        'log',
        'user_id'
    ]; 

    protected $fillable = [
        'scope_id',
        'scope_type',
        'user_id',
        'description',
        'tags',
        'visibility'
    ]
}
