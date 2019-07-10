<?php

namespace App\Jobs;

use App\Models\FavouriteUserPicture;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class LastestPicturesUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Elasticsearch::indices()->delete(['index' => 'lastest']);

        $lastest = FavouriteUserPicture::select(\DB::raw('MAX(updated_at) as updated_at, picture_id'))
            ->where('enabled', true)
            ->orderBy('updated_at', 'desc')
            ->groupBy('picture_id')
            ->limit(20)
            ->get();

        foreach ($lastest as $item) {

            $url = 'http://jsonplaceholder.typicode.com/photos/' . $item->picture_id;

            $client = new \GuzzleHttp\Client();
            $response = $client->get($url);

            $data = [
                'body' => json_decode($response->getBody()),
                'index' => 'lastest',
                'type' => '_doc',
                'id' => $item->picture_id
            ];

            \Elasticsearch::index($data);
        }
    }
}
