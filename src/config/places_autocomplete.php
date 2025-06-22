<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Google Maps API Key
    |--------------------------------------------------------------------------
    |
    | Here you may specify your Google Maps API key for the Places Autocomplete
    | feature. This key will be used to authenticate requests to the Google Maps
    | API and should be kept secret.
    |
    */

    'google_maps_api_key' => env('GOOGLE_MAPS_API_KEY', ''),

    /*|--------------------------------------------------------------------------
    | Default Options
    |----------------------------------------------------------------------------
    | These options will be used as default settings for the Places Autocomplete
    | component. You can override these options when using the component in your
    | Blade templates.
    |*/

    'options' => [
        'debounce' => 100, // Debounce time in milliseconds
        'distance' => true, // Display distance in results
        'distance_units' => 'km', // Units for distance (km or miles)
        'placeholder' => 'Search for a place', // Placeholder text for the input field
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Request Parameters
    |--------------------------------------------------------------------------
    | These parameters will be included in every request made to the Google Maps
    | API for Places Autocomplete. You can override these parameters when using
    | the component in your Blade templates.
    |*/
    'request_params' => [
        'language' => 'en',
        'region' => 'GB',
    ],


    /*|--------------------------------------------------------------------------
    | Default Fetch Fields
    |--------------------------------------------------------------------------
    | These fields will be fetched by default when using the Places Autocomplete
    | component. You can override these fields when using the component in your
    | Blade templates.
    |*/ 
    'fetch_fields' => [
        'formattedAddress',
        'addressComponents',
    ],
];