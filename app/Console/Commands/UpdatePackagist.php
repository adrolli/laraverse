<?php

namespace App\Console\Commands;

use App\Jobs\PackagistUpdate;
use Illuminate\Console\Command;

class UpdatePackagist extends Command
{
    protected $signature = 'update:packagist';

    protected $description = 'Update Packagist packages';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Updating Packagist packages...');

        PackagistUpdate::dispatch();

        $this->info('Packagist packages update dispatched.');
    }
}
