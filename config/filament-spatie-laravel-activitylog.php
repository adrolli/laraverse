<?php

return [

    'resource' => [
        'filament-resource' => AlexJustesen\FilamentSpatieLaravelActivitylog\Resources\ActivityResource::class,
        'group' => 'Settings',
        'sort' => 1,
    ],

    'paginate' => [5, 10, 25, 50],

];
