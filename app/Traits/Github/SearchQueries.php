<?php

namespace App\Traits\Github;

use App\Traits\ErrorHandler;

trait SearchQueries
{
    use ErrorHandler;

    public function generateSearchQueries($keyPhrase, $resultCount)
    {
        try {

            $oldestDate = '2011-06-09';
            $currentDate = date('Y-m-d');

            $queries = [];

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
                        $query = "{$keyPhrase}{$fork}{$state}+in:name,description,readme,topics";
                        $queries[] = $query;
                    }
                }
            } elseif ($resultCount < 5000) {
                foreach ($sizes as $size) {
                    foreach ($forks as $fork) {
                        foreach ($states as $state) {
                            $query = "{$keyPhrase}{$size}{$fork}{$state}+in:name,description,readme,topics";
                            $queries[] = $query;
                        }
                    }
                }
            } elseif ($resultCount < 10000) {
                foreach ($sizes as $size) {
                    foreach ($forks as $fork) {
                        foreach ($states as $state) {
                            foreach ($stars as $star) {
                                foreach ($topics as $topic) {
                                    $query = "{$keyPhrase}{$size}{$fork}{$state}{$star}{$topic}+in:name,description,readme,topics";
                                    $queries[] = $query;
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
                            $query = "{$keyPhrase}{$dateQuery}{$fork}{$state}+in:name,description,readme,topics";
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
                            $query = "{$keyPhrase}{$dateQuery}{$fork}{$state}+in:name,description,readme,topics";
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
                                $query = "{$keyPhrase}{$dateQuery}{$size}{$fork}{$state}+in:name,description,readme,topics";
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
                                $query = "{$keyPhrase}{$dateQuery}{$size}{$fork}{$state}+in:name,description,readme,topics";
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
                                        $query = "{$keyPhrase}{$dateQuery}{$size}{$fork}{$star}{$topic}{$state}+in:name,description,readme,topics";
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
                                        $query = "{$keyPhrase}{$dateQuery}{$size}{$fork}{$star}{$topic}{$state}+in:name,description,readme,topics";
                                        $queries[] = $query;
                                    }
                                }
                            }
                        }
                    }
                    $currentDate = date('Y-m-d', strtotime($currentDate.' -1 day'));
                }
            }

            return $queries;

        } catch (\Exception $e) {

            $this->handleApiError('Search Queries', $e);

            return null;
        }
    }
}
