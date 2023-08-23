<?php

namespace App\Console\Commands;

use App\Http\Controllers\Consumer\PackagistController;
use Illuminate\Console\Command;

class PackagistInitialize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'packagist:initialize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initializes the Packagist database by fetching all packages.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $controller = new PackagistController();
        $controller->initializeAllPackages();

        $this->info('Packagist init job started ...');
    }
}
