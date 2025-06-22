{{-- Define a Blade component for Places Autocomplete --}}
<div id="{{ $containerId }}"></div>

{{-- Blade component for Places Autocomplete --}}
{{-- This component initializes the PlacesAutocomplete library with the provided options and parameters. --}}
@props([
    'containerId' => 'places-autocomplete',
    'googleMapsApiKey' => config('places_autocomplete.google_maps_api_key'),
    'options' => [],
    'requestParams' => [],
    'fetchFields' => [],
    'loadScriptTag' => true,
])

{{-- Ensure the container ID is valid --}}
@if ($loadScriptTag)
    <script type="module">
        import {
            PlacesAutocomplete
        } from "{{ asset('vendor/places-autocomplete/places-autocomplete.js') }}";
        window.PlacesAutocomplete = PlacesAutocomplete;
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        try {
            // Check if the PlacesAutocomplete library is loaded
            if (typeof PlacesAutocomplete === 'undefined' && {{ $loadScriptTag ? 'true' : 'false' }}) {
                console.warn(
                    'PlacesAutocompleteJs library not found. Ensure it is loaded before this script or enable loadScriptTag.'
                    );
            }

            // Initialize the PlacesAutocomplete instance
            const {{ \Illuminate\Support\Str::camel($containerId) }}Instance = new PlacesAutocomplete({
                containerId: '{{ $containerId }}',
                googleMapsApiKey: '{{ $googleMapsApiKey }}',
                options: @json($options),
                requestParams: @json($requestParams),
                fetchFields: @json($fetchFields),
                onResponse: function(placeDetails) {
                    // Emit a custom event on the container for other JS to listen to
                    const event = new CustomEvent('pac-response', {
                        detail: placeDetails
                    });
                    document.getElementById('{{ $containerId }}').dispatchEvent(event);
                    console.log('Place Selected (from Blade component):', placeDetails);
                    // Or define global callback names that users can implement
                    // if (typeof window.handlePacResponse_{{ str_replace('-', '_', $containerId) }} === 'function') {
                    //    window.handlePacResponse_{{ str_replace('-', '_', $containerId) }}(placeDetails);
                    // }
                },
                onError: function(error) {
                    const event = new CustomEvent('pac-error', {
                        detail: error
                    });
                    document.getElementById('{{ $containerId }}').dispatchEvent(event);
                    console.error('Autocomplete Error (from Blade component):', error.message ||
                        error);
                }
            });

            // Store instance if needed, e.g., for external control
            // window.pacInstances = window.pacInstances || {};
            // window.pacInstances['{{ $containerId }}'] = {{ \Illuminate\Support\Str::camel($containerId) }}Instance;

        } catch (error) {
            console.error("Failed to initialize PlacesAutocomplete (Blade):", error.message || error);
        }
    });
</script>
