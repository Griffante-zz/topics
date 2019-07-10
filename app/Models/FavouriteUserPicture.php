<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavouriteUserPicture extends Model
{
    protected $table = "favourites_users_pictures";

    protected $fillable = [
        "user_id",
        "picture_id"
    ];
}
