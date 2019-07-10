<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FavouriteUserPictureService;

class FavouriteUserPictureController extends Controller
{

    /**
     * @var FavouriteUserPictureService
     */
    protected $service;

    public function __construct(FavouriteUserPictureService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $response = $this->service->getAll();
            return response()->json($response);
        }
        catch (\Exception $exception) {
            //TO DO: To map error responses
            return response($exception, 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $response = $this->service
                ->save($request->all());
            return response()->json($response);
        }
        catch (\Exception $exception) {
            //TO DO: To map error responses
            return response($exception, 400);
        }
    }

}
