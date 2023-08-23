<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdatePackagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $jobName;

    protected $controller;

    protected $packageNames;

    public function __construct($jobName, $controller, $packageNames)
    {
        $this->jobName = $jobName;
        $this->controller = $controller;
        $this->packageNames = $packageNames;
    }

    public function handle()
    {
        activity()->log("{$this->jobName} started");

        $batchSize = 10;

        $packageNamesChunks = array_chunk($this->packageNames, $batchSize);

        foreach ($packageNamesChunks as $packageNamesChunk) {
            foreach ($packageNamesChunk as $packageName) {
                $packageDetails = $this->controller->getPackage($packageName);
                $this->controller->updatePackage($packageDetails);
            }
            sleep(1);
        }

        activity()->log("{$this->jobName} finished");
    }
}
