<?php

namespace App\Console\Commands;

use App\Http\Controllers\Consumer\PackagistController;
use App\Jobs\ProcessPackageChunk;
use Illuminate\Console\Command;

class DispatchPackageJobs extends Command
{
    protected $signature = 'packages:dispatch';

    protected $description = 'Dispatch package jobs in chunks';

    public function handle()
    {
        $controller = new PackagistController();
        $packageNames = $controller->getAllPackages();

        $chunkSize = 100; // Adjust the chunk size as needed
        $packageChunks = array_chunk($packageNames, $chunkSize);

        foreach ($packageChunks as $chunk) {
            ProcessPackageChunk::dispatch($chunk, $controller);
        }
    }
}
