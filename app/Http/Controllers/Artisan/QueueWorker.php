<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class QueueWorker extends Controller
{
    public function __invoke()
    {
        $secretToken = config('app.laraverse_token');

        if (request('token') !== $secretToken) {
            activity()->log('Unauthorized queue worker request');

            abort(403, 'Unauthorized');
        }

        activity()->log('Queue worker invoked by route');

        $timeout = 60;

        if (request('timeout')) {
            $timeout = request('timeout');
        }

        $output = Artisan::call('queue:work --once --timeout='.$timeout);

        if ($output == 0) {
            activity()->log('Queue worker ran successfully');

            return 'Queue worker run was successful';
        } else {
            activity()->log('Ran queue worker with output: '.$output);

            return 'Queue worker ran with output: '.$output;
        }

    }
}
