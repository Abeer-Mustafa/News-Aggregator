<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use romanzipp\QueueMonitor\Traits\IsMonitored;
use Exception;
use Log;

use App\Services\NewsOrg;
use App\Services\NYTimes;
use App\Services\TheGuardian;

class FetchNewsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;

    /**
     * Create a new job instance.
     */
    protected $service;
    protected $baseUrl;
    protected $page;
    protected $maxResults;

    public function __construct($service, $baseUrl, $page, $maxResults = null)
    {
        $this->service = $service;
        $this->baseUrl = $baseUrl;
        $this->page = $page;
        $this->maxResults = $maxResults;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $apiService = new $this->service;
            $apiService->getPaginatedData($this->baseUrl, $this->page, $this->maxResults);
        } catch (Exception $e) {
            Log::error("Failed to fetch data from {$this->baseUrl} on page {$this->page}: " . $e->getMessage());
        }
    }
}
