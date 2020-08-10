<?php
/*
 * Schema file for validating JSON with various schema details avaialble in StarWars
 * has films_schema, people_schema, planets_schema,species_schema,vehicles_schema
 * each node is defined based on the type classes in JSONSchema class
 */
$films_schema = [
    [
        'node' => [
            'name' => 'title',
            'type' => 'text',
            'required' => true
        ]
    ],
    [
        'node' => [
            'name' => 'episode_id',
            'type' => 'numeric',
            'required' => true
        ]
    ],
    [
        'node' => [
            'name' => 'opening_crawl',
            'type' => 'text',
            'required' => true
        ]
    ],
    [
        'node' => [
            'name' => 'director',
            'type' => 'text',
            'required' => true
        ]
    ],
    [
        'node' => [
            'name' => 'producer',
            'type' => 'text',
            'required' => true
        ]
    ],
    [
        'node' => [
            'name' => 'release_date',
            'type' => 'date',
            'required' => true
        ]
    ],
    [
        'node' => [
            'name' => 'characters',
            'type' => 'array',
            'required' => true,
            'min_item_count' => 1
        ]
    ],
    [
        'node' => [
            'name' => 'planets',
            'type' => 'array',
            'required' => true,
            'min_item_count' => 1
        ]
    ],
    [
        'node' => [
            'name' => 'starships',
            'type' => 'array',
            'required' => true,
            'min_item_count' => 1
        ]
    ],
    [
        'node' => [
            'name' => 'vehicles',
            'type' => 'array',
            'required' => true,
            'min_item_count' => 1
        ]
    ],
    [
        'node' => [
            'name' => 'species',
            'type' => 'array',
            'required' => true,
            'min_item_count' => 1
        ]
    ]
];


$people_schema = [
    [
        'node' => [
            'name' => 'name',
            'type' => 'text',
            'required' => true
        ]
    ],
    [
        'node' => [
            'name' => 'height',
            'type' => 'numeric',
            'required' => true
        ]
    ],
    [
        'node' => [
            'name' => 'mass',
            'type' => 'numeric'
        ]
    ],
    [
        'node' => [
            'name' => 'hair_color',
            'type' => 'text'
        ]
    ],
    [
        'node' => [
            'name' => 'skin_color',
            'type' => 'text'
        ]
    ],
    [
        'node' => [
            'name' => 'eye_color',
            'type' => 'text'
        ]
    ],
    [
        'node' => [
            'name' => 'birth_year',
            'type' => 'text'
        ]
    ],
    [
        'node' => [
            'name' => 'gender',
            'type' => 'text'
        ]
    ],
    [
        'node' => [
            'name' => 'homeworld',
            'type' => 'text'
        ]
    ],
    [
        'node' => [
            'name' => 'films',
            'type' => 'array',
            'required' => false
        ]
    ],
    [
        'node' => [
            'name' => 'species',
            'type' => 'array',
            'required' => false
        ]
    ],
    [
        'node' => [
            'name' => 'vehicles',
            'type' => 'array',
            'required' => false
        ]
    ],
    [
        'node' => [
            'name' => 'starships',
            'type' => 'array',
            'required' => false
        ]
    ]
];

$peopleadd_schema = [
    [
        'node' => [
            'name' => 'name',
            'type' => 'text',
            'required' => true
        ]
    ],
    [
        'node' => [
            'name' => 'height',
            'type' => 'numeric',
            'required' => true
        ]
    ],
    [
        'node' => [
            'name' => 'mass',
            'type' => 'numeric'
        ]
    ],
    [
        'node' => [
            'name' => 'hair_color',
            'type' => 'text'
        ]
    ],
    [
        'node' => [
            'name' => 'skin_color',
            'type' => 'text'
        ]
    ],
    [
        'node' => [
            'name' => 'eye_color',
            'type' => 'text'
        ]
    ],
    [
        'node' => [
            'name' => 'birth_year',
            'type' => 'text'
        ]
    ],
    [
        'node' => [
            'name' => 'gender',
            'type' => 'text'
        ]
    ],
    [
        'node' => [
            'name' => 'homeworld',
            'type' => 'text'
        ]
    ],
    [
        'node' => [
            'name' => 'species',
            'type' => 'text'        ]
    ]
];

$planets_schema = [
    [
        'node' => [
            'name' => 'name',
            'type' => 'text',
            'required' => true
        ]
    ],
    [
        'node' => [
            'name' => 'rotation_period',
            'type' => 'numeric',
            'required' => true
        ]
    ],
    [
        'node' => [
            'name' => 'orbital_period',
            'type' => 'numeric'
        ]
    ],
    [
        'node' => [
            'name' => 'diameter',
            'type' => 'numeric'
        ]
    ],
    [
        'node' => [
            'name' => 'climate',
            'type' => 'text'
        ]
    ],
    [
        'node' => [
            'name' => 'gravity',
            'type' => 'text'
        ]
    ],
    [
        'node' => [
            'name' => 'terrain',
            'type' => 'text'
        ]
    ],
    [
        'node' => [
            'name' => 'surface_water',
            'type' => 'numeric'
        ]
    ],
    [
        'node' => [
            'name' => 'population',
            'type' => 'numeric'
        ]
    ],
    [
        'node' => [
            'name' => 'residents',
            'type' => 'array',
            'required' => false
        ]
    ],
    [
        'node' => [
            'name' => 'films',
            'type' => 'array',
            'required' => false
        ]
    ]
];


$species_schema = [
    [
        'node' => [
            'name' => 'name',
            'type' => 'text',
            'required' => true
        ]
    ],
    [
        'node' => [
            'name' => 'classification',
            'type' => 'text',
            'required' => true
        ]
    ],
    [
        'node' => [
            'name' => 'designation',
            'type' => 'text',
            'required' => true
        ]
    ],
    [
        'node' => [
            'name' => 'average_height',
            'type' => 'numeric'
        ]
    ],
    [
        'node' => [
            'name' => 'skin_colors',
            'type' => 'text'
        ]
    ],
    [
        'node' => [
            'name' => 'hair_colors',
            'type' => 'text'
        ]
    ],
    [
        'node' => [
            'name' => 'eye_colors',
            'type' => 'text'
        ]
    ],
    [
        'node' => [
            'name' => 'average_lifespan',
            'type' => 'numeric'
        ]
    ],
    [
        'node' => [
            'name' => 'homeworld',
            'type' => 'text'
        ]
    ],
    [
        'node' => [
            'name' => 'language',
            'type' => 'text'
        ]
    ],
    [
        'node' => [
            'name' => 'people',
            'type' => 'array',
            'required' => false
        ]
    ],
    [
        'node' => [
            'name' => 'films',
            'type' => 'array',
            'required' => false
        ]
    ]
];


$vehicles_schema = [
    [
        'node' => [
            'name' => 'name',
            'type' => 'text',
            'required' => true
        ]
    ],
    [
        'node' => [
            'name' => 'model',
            'type' => 'text',
            'required' => true
        ]
    ],
    [
        'node' => [
            'name' => 'manufacturer',
            'type' => 'text',
            'required' => true
        ]
    ],
    [
        'node' => [
            'name' => 'cost_in_credits',
            'type' => 'numeric'
        ]
    ],
    [
        'node' => [
            'name' => 'length',
            'type' => 'numeric'
        ]
    ],
    [
        'node' => [
            'name' => 'max_atmosphering_speed',
            'type' => 'numeric'
        ]
    ],
    [
        'node' => [
            'name' => 'crew',
            'type' => 'numeric'
        ]
    ],
    [
        'node' => [
            'name' => 'passengers',
            'type' => 'numeric'
        ]
    ],
    [
        'node' => [
            'name' => 'cargo_capacity',
            'type' => 'numeric'
        ]
    ],
    [
        'node' => [
            'name' => 'consumables',
            'type' => 'text'
        ]
    ],
    [
        'node' => [
            'name' => 'vehicle_class',
            'type' => 'text',
            'required' => false
        ]
    ],
    [
        'node' => [
            'name' => 'pilots',
            'type' => 'array',
            'required' => false
        ]
    ],
    [
        'node' => [
            'name' => 'films',
            'type' => 'array',
            'required' => false
        ]
    ]
];
?>