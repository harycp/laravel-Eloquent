<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "comments";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $timestamps = true;


    protected $attributes = [
        "title" => "Comment Author"
    ];
}
