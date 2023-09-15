<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class Scheduler extends Controller
{
    public function __invoke()
    {
        if (request('token') !== 'faer2rv') {
            activity()->log('Unauthorized scheduler request');

            abort(403, 'Unauthorized');
        }

        activity()->log('Scheduler invoked by route');

        $output = Artisan::call('queue:work --once --timeout='.request('timeout'));

        if ($output == 0) {
            activity()->log('Scheduler ran successfully');

            return 'Scheduler run was successful';
        } else {
            activity()->log('Ran Scheduler with output: '.$output);

            return 'Scheduler ran with output: '.$output;
        }

    }
}
