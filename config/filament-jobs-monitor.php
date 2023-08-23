<?php

// config for Croustibat/FilamentJobsMonitor
return [
    'navigation' => [
        'enabled' => true,
        'group_label' => 'Operations',
        'group_sort' => '1',
        'icon' => 'heroicon-o-chip',
    ],
    'pruning' => [
        'activate' => true,
        'retention_days' => 7,
    ],
];
