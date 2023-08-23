<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessPackageChunk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $packageNames;

    protected $controller;

    public function __construct($packageNames, $controller)
    {
        $this->packageNames = $packageNames;
        $this->controller = $controller;
    }

    public function handle()
    {

        foreach ($this->packageNames as $packageName) {
            $packageDetails = $this->controller->getPackage($packageName);
            $this->controller->updatePackage($packageDetails);
        }
    }
}
