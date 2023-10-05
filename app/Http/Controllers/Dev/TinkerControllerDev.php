<?php

/*
|--------------------------------------------------------------------------
| Laraverse Tinker Controller
|--------------------------------------------------------------------------
|
| Test things here ...
|
*/

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;

class TinkerController extends Controller
{
    public $repos;

    public function __invoke()
    {
        $secretToken = config('app.laraverse_token');

        if (request('token') !== $secretToken) {
            activity()->log('Unauthorized tinker request');

            abort(403, 'Unauthorized');
        }

        $this->repos = request('repos');

        $this->tinkerNow();
    }

    public function tinkerNow()
    {

        $page = 1;
        $perPage = 100;
        $keyPhrase = 'laravel';
        $resultCount = $this->repos;
        echo number_format($resultCount, 0, '', '.').' repos<br>';
        $oldestDate = '2011-06-09';
        $currentDate = date('Y-m-d');

        $queries = [];

        $queryTypes = [
            '+updated:',
            '+created:',
            '+pushed:',
        ];

        $sizes = [
            '+size:<100',
            '+size:1000..9999',
            '+size:10000..99999',
            '+size:100000..499999',
            '+size:500000..999999',
            '+size:1000000..4999999',
            '+size:5000000..9999999',
            '+size:>=10000000',
        ];

        $forks = [
            '+fork:only',
            '+fork:false',
        ];

        $stars = [
            '+stars:<1',
            '+stars:>=1',
        ];

        $topics = [
            '+topics:<1',
            '+topics:>=1',
        ];

        $states = [
            '+archived:true',
            '+archived:false',
        ];

        if ($resultCount < 1000) {
            foreach ($forks as $fork) {
                foreach ($states as $state) {
                    $query = "{$keyPhrase}{$fork}{$state}";
                    $queries[] = $query;
                }
            }
        } elseif ($resultCount < 5000) {
            foreach ($sizes as $size) {
                foreach ($forks as $fork) {
                    foreach ($states as $state) {
                        $queries[] = "{$keyPhrase}{$size}{$fork}{$state}";
                    }
                }
            }
        } elseif ($resultCount < 10000) {
            foreach ($sizes as $size) {
                foreach ($forks as $fork) {
                    foreach ($states as $state) {
                        foreach ($stars as $star) {
                            foreach ($topics as $topic) {
                                $queries[] = "{$keyPhrase}{$size}{$fork}{$state}{$star}{$topic}";
                            }
                        }
                    }
                }
            }
        } elseif ($resultCount < 50000) {
            while ($currentDate >= $oldestDate) {
                $dateQuery = "+updated:{$currentDate}..{$currentDate}";
                foreach ($forks as $fork) {
                    foreach ($states as $state) {
                        $query = "{$keyPhrase}{$dateQuery}{$fork}{$state}";
                        $queries[] = $query;
                    }
                }
                $currentDate = date('Y-m-d', strtotime($currentDate.' -1 month'));
            }
        } elseif ($resultCount < 100000) {
            while ($currentDate >= $oldestDate) {
                $dateQuery = "+updated:{$currentDate}..{$currentDate}";
                foreach ($forks as $fork) {
                    foreach ($states as $state) {
                        $query = "{$keyPhrase}{$dateQuery}{$fork}{$state}";
                        $queries[] = $query;
                    }
                }
                $currentDate = date('Y-m-d', strtotime($currentDate.' -1 week'));
            }
        } elseif ($resultCount < 500000) {
            while ($currentDate >= $oldestDate) {
                $dateQuery = "+updated:{$currentDate}..{$currentDate}";
                foreach ($sizes as $size) {
                    foreach ($forks as $fork) {
                        foreach ($states as $state) {
                            $query = "{$keyPhrase}{$dateQuery}{$size}{$fork}{$state}";
                            $queries[] = $query;
                        }
                    }
                }
                $currentDate = date('Y-m-d', strtotime($currentDate.' -1 month'));
            }
        } elseif ($resultCount < 1000000) {
            while ($currentDate >= $oldestDate) {
                $dateQuery = "+updated:{$currentDate}..{$currentDate}";
                foreach ($sizes as $size) {
                    foreach ($forks as $fork) {
                        foreach ($states as $state) {
                            $query = "{$keyPhrase}{$dateQuery}{$size}{$fork}{$state}";
                            $queries[] = $query;
                        }
                    }
                }
                $currentDate = date('Y-m-d', strtotime($currentDate.' -1 week'));
            }
        } elseif ($resultCount < 5000000) {
            while ($currentDate >= $oldestDate) {
                $dateQuery = "+updated:{$currentDate}..{$currentDate}";
                foreach ($sizes as $size) {
                    foreach ($forks as $fork) {
                        foreach ($stars as $star) {
                            foreach ($topics as $topic) {
                                foreach ($states as $state) {
                                    $query = "{$keyPhrase}{$dateQuery}{$size}{$fork}{$star}{$topic}{$state}";
                                    $queries[] = $query;
                                }
                            }
                        }
                    }
                }
                $currentDate = date('Y-m-d', strtotime($currentDate.' -1 week'));
            }
        } else {
            while ($currentDate >= $oldestDate) {
                $dateQuery = "+updated:{$currentDate}..{$currentDate}";
                foreach ($sizes as $size) {
                    foreach ($forks as $fork) {
                        foreach ($stars as $star) {
                            foreach ($topics as $topic) {
                                foreach ($states as $state) {
                                    $query = "{$keyPhrase}{$dateQuery}{$size}{$fork}{$star}{$topic}{$state}";
                                    $queries[] = $query;
                                }
                            }
                        }
                    }
                }
                $currentDate = date('Y-m-d', strtotime($currentDate.' -1 day'));
            }
        }

        $i = 0;
        foreach ($queries as $query) {
            $apiUrl = "https://api.github.com/search/repositories?q={$query}+in:name,description,readme,topics&per_page={$perPage}&page={$page}";

            $i++;
            echo $i.' <a href="'.$apiUrl.'">'.$query.'</a><br>';
        }

        echo $i.' queries';

    }
}
