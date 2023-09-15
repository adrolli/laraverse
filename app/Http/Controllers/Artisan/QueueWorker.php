<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class QueueWorker extends Controller
{
    public function __invoke()
    {
        if (request('token') !== 'faer2rv') {
            activity()->log('Unauthorized queue worker request');

            abort(403, 'Unauthorized');
        }

        activity()->log('Queue worker invoked by route');

        $output = Artisan::call('queue:work --once --timeout=300');

        if ($output == 0) {
            activity()->log('Queue worker ran successfully');

            return 'Queue worker run was successful';
        } else {
            activity()->log('Ran queue worker with output: '.$output);

            return 'Queue worker ran with output: '.$output;
        }

    }
}
