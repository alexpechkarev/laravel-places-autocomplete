<?php

namespace PlacesAutocomplete;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use PlacesAutocomplete\View\Components\PlacesAutocompleteComponent;

/**
 * Service provider for the Places Autocomplete package.
 */
class PlacesAutocompleteServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Publishing the configuration file
        $this->publishes([
            __DIR__ . '/config/places_autocomplete.php' => config_path('places_autocomplete.php'),
        ], 'places-autocomplete');

        // Publishing the JavaScript assets
        $this->publishes([
            __DIR__ . '/js' => public_path('vendor/places-autocomplete'),
        ], 'places-autocomplete');

        // Publishing the view files
        $this->publishes([
            __DIR__ . '/views' => resource_path('views/vendor/places-autocomplete'),
        ]);

        // Registering the Blade component
        // This allows the component to be used in Blade templates
        // The component can be used with the syntax: <x-places-autocomplete />
        // The component will be rendered using the PlacesAutocompleteComponent class
        Blade::component('places-autocomplete', PlacesAutocompleteComponent::class);
    }
}
