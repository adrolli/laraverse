<?php

namespace App\Console\Commands;

use App\Jobs\PackagistWorker;
use Illuminate\Console\Command;

class WorkerPackagist extends Command
{
    protected $signature = 'laraverse:packagist';

    protected $description = 'Start Packagist worker';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Starting Packagist Worker');

        PackagistWorker::dispatch();

        $this->info('Packagist Worker finished');
    }
}
