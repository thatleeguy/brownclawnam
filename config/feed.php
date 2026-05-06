<?php

return [
    'feeds' => [
        'briefings' => [
            'items'       => [App\Models\Insight::class, 'getFeedItems'],
            'url'         => '/briefings.atom',
            'title'       => 'Brownclaw Asset Management — Briefings',
            'description' => 'Field briefings, technical memoranda, and methods notes on reliability engineering for heavy industry.',
            'language'    => 'en-CA',
            'image'       => '',
            'format'      => 'atom',
            'view'        => 'feed::atom',
            'type'        => '',
            'contentType' => '',
        ],
    ],
];
