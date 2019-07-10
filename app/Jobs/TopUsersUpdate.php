<?php

namespace App\Jobs;

use App\Models\FavouriteUserPicture;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TopUsersUpdate implements ShouldQueue
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
        \Elasticsearch::indices()->delete(['index' => 'users']);

        $users = FavouriteUserPicture::select(\DB::raw('COUNT(picture_id) as total, user_id as id, name'))
            ->join('users', 'users.id', '=', 'user_id')
            ->where('enabled', true)
            ->orderBy('total', 'desc')
            ->groupBy('user_id', 'name')
            ->limit(20)
            ->get();

        foreach ($users as $user) {
            $data = [
                'body' => $user->toArray(),
                'index' => 'users',
                'type' => '_doc',
                'id' => $user->id
            ];

            \Elasticsearch::index($data);
        }
    }
}
