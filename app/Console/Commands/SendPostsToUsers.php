<?php

namespace App\Console\Commands;

use App\Jobs\SendPostEmail;
use App\Models\Post;
use App\Models\User;
use App\Models\UserWebsite;
use Illuminate\Console\Command;

class SendPostsToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send_posts_to_users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send new posts from websites to users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::join('user_website', 'users.id', '=', 'user_website.user_id')
            ->select('users.*')
            ->get();

        foreach ($users as $user) {
            $user_websites = UserWebsite::where('user_id', $user->id)
                ->whereRaw('last_post_id < (SELECT MAX(posts.id) FROM posts WHERE posts.website_id = user_website.website_id)')
                ->select('user_website.*')
                ->get();

            foreach ($user_websites as $user_website) {
                $posts = Post::where('id', '>', $user_website->last_post_id)
                    ->where('website_id', $user_website->website_id)
                    ->orderBy('id')
                    ->get();

                foreach ($posts as $post) {
                    SendPostEmail::dispatch($post, $user->email);
                }

                if (count((array)$posts) > 0) {
                    UserWebsite::where('user_id', $user->id)
                        ->where('website_id', $user_website->website_id)
                        ->update(['last_post_id' => $posts->toArray()[count($posts->toArray()) - 1]['id']]);
                }
            }
        }

        return 0;
    }
}
