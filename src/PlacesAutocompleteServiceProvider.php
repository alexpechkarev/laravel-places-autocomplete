<?php

namespace PlacesAutocomplete\View\Components;

use Illuminate\View\Component;
use \Illuminate\Support\Str;


/**
 * Class PlacesAutocompleteComponent
 *
 * A Blade component for integrating Google Places Autocomplete.
 *
 * @package PlacesAutocomplete\View\Components
 */

class PlacesAutocompleteComponent extends Component
{
    public string $containerId; // Unique ID for the container element
    public string $rootDivId; // ID for the root div element
    public string $googleMapsApiKey; // Google Maps API key for Places Autocomplete
    public array $options; // Options for the Places Autocomplete component
    public array $requestParams; // Request parameters for the Places Autocomplete component
    public array $fetchFields; // Fetch fields for the Places Autocomplete component
    public bool $loadScriptTag; // New option to control script loading


    /**
     * Class constructor.
     *
     * @param string $containerId
     * @param string $rootDivId
     * @param string $googleMapsApiKey
     * @param array $options
     * @param array $requestParams
     * @param array $fetchFields
     * @param bool $loadScriptTag
     */
    public function __construct(
        string $containerId = 'pac_container',
        string $rootDivId = 'places-autocomplete-root',
        string $googleMapsApiKey = '',
        array $options = [],
        array $requestParams = [],
        array $fetchFields = [],
        bool $loadScriptTag = true // Default to true
    ) {
    
        // Ensure unique ID
        $this->containerId = $containerId . '-' . Str::random(5);

        $this->rootDivId = $rootDivId;
        // Set Google Maps API key, options, request parameters, fetch fields, and script loading option
        $this->googleMapsApiKey = !empty($googleMapsApiKey) ? $googleMapsApiKey : config('places_autocomplete.google_maps_api_key');
        // Merge with default options, request parameters, and fetch fields from config
        $this->options = array_merge(config('places_autocomplete.options', []), $options);
    
        // Request parameters and fetch fields are merged with defaults from config
        // This allows users to override them when using the component in their Blade templates
        $this->requestParams = array_merge(config('places_autocomplete.request_params', []), $requestParams);

        // Fetch fields are merged with defaults from config
        // This allows users to override them when using the component in their Blade templates
        // Default fetch fields include 'formattedAddress' and 'addressComponents'
        $this->fetchFields = array_merge(config('places_autocomplete.fetch_fields', ['formattedAddress', 'addressComponents']), $fetchFields);

        // Set the loadScriptTag property to control whether the script tag is loaded
        // This allows users to choose whether to load the Google Maps script tag automatically
        $this->loadScriptTag = $loadScriptTag;

        // Validate that the Google Maps API key is set
        // If not set, throw an exception to inform the user
        if (empty($this->googleMapsApiKey)) {
            throw new \InvalidArgumentException('Google Maps API key is not configured. Please set it in your .env file or config/places_autocomplete.php');
        }
    }

    /**
     * Render the component view.
     *
     * @return void
     */
    public function render()
    {
        return view('vendor.places-autocomplete.places-autocomplete', [
            'containerId' => $this->containerId,
            'rootDivId' => $this->rootDivId,
            'googleMapsApiKey' => $this->googleMapsApiKey,
            'options' => $this->options,
            'requestParams' => $this->requestParams,
            'fetchFields' => $this->fetchFields,
            'loadScriptTag' => $this->loadScriptTag,
        ]);
    }
}
// End of PlacesAutocompleteComponent class