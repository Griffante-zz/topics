<?php


namespace App\Services;

use App\Jobs\LastestPicturesUpdate;
use App\Jobs\TopUsersUpdate;
use App\Repositories\FavouriteUserPictureRepository;
use App\Models\FavouriteUserPicture;
use Illuminate\Support\Facades\Auth;

class FavouriteUserPictureService
{

    protected $favouriteUserPictureRepository;

    public function __construct(FavouriteUserPictureRepository $favouriteUserPictureRepository)
    {
        $this->favouriteUserPictureRepository = $favouriteUserPictureRepository;
    }

    public function save($data)
    {
        $model = FavouriteUserPicture::firstOrCreate([
            "user_id" =>  Auth::id(),
            "picture_id" => $data["picture_id"]
        ]);

        $model->enabled = $data["enabled"];

        $response = $this->favouriteUserPictureRepository
            ->save($model)->attributesToArray();

        /**
         * TO DO: Update ES indexes with supervisor
         */
        LastestPicturesUpdate::dispatch();
        TopUsersUpdate::dispatch();

        return $response;
    }

    /**
     * @return FavouriteUserPictureRepository
     */
    public function getAll()
    {
        return $this->favouriteUserPictureRepository
            ->getCollection(Auth::id(), true);
    }

}