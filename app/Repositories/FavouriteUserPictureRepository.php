<?php

namespace App\Repositories;

use App\Models\FavouriteUserPicture;

class FavouriteUserPictureRepository
{

    /**
     * @var FavouriteUserPicture
     */
    protected $model;

    /**
     * FavouriteUserPictureRepository constructor.
     * @param FavouriteUserPicture $model
     */
    public function __construct(FavouriteUserPicture $model)
    {
        $this->model = $model;
    }

    public function getCollection($user_id, $enabled = true)
    {
        return $this->model
            ->where('enabled', $enabled)
            ->where('user_id', $user_id)
            ->get();
    }

    public function save(FavouriteUserPicture $model)
    {
        $model->save();
        return $model;
    }

}