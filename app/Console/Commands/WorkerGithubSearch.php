<?php

namespace App\Console\Commands;

use App\Jobs\GithubSearchWorker;
use Illuminate\Console\Command;

class WorkerGithubSearch extends Command
{
    protected $signature = 'laraverse:githubsearch';

    protected $description = 'Start GitHub Search Worker';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Starting GitHub Search Worker');

        GithubSearchWorker::dispatch();

        $this->info('Packagist GitHub Search finished');
    }
}
