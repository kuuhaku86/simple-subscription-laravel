<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWebsite extends Model
{
    use HasFactory;

    protected $table = "user_website";

    protected $fillable = [
        'user_id',
        'website_id',
        'last_post_id'
    ];
}
