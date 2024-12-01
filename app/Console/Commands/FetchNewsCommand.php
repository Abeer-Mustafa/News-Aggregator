<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Jobs\FetchNewsJob;

class FetchNewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the latest news articles and update the database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sources = config('news_api');
        foreach ($sources as $source) {
            $apiService = new $source['name']();
            $apiService->getTodayArticlesCount();
        }

        $this->info('News fetching job dispatched successfully.');
    }
}
