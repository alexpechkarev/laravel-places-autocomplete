# Places Autocomplete for Laravel

[![GitHub Stars](https://img.shields.io/github/stars/alexpechkarev/laravel-places-autocomplete.svg?style=flat-square)](https://github.com/alexpechkarev/laravel-places-autocomplete/stargazers)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/alexpechkarev/laravel-places-autocomplete.svg?style=flat-square)](https://packagist.org/packages/alexpechkarev/laravel-places-autocomplete)
[![Total Downloads](https://img.shields.io/packagist/dt/alexpechkarev/laravel-places-autocomplete.svg?style=flat-square)](https://packagist.org/packages/alexpechkarev/laravel-places-autocomplete)
[![GitHub License](https://img.shields.io/github/license/alexpechkarev/laravel-places-autocomplete.svg?style=flat-square)](https://github.com/alexpechkarev/laravel-places-autocomplete/blob/master/LICENSE)

A Laravel package that provides a simple Blade component to integrate the Google Places Autocomplete functionality into your application with minimal setup.

It handles API loading, session tokens for cost-effective usage, and fetching place details, allowing you to focus on building your application.

## Features

- **Simple Integration:** Add address autocomplete to any form with a single Blade component.
- **Cost-Effective:** Automatically handles session tokens to reduce Google API costs.
- **Customizable:** Configure the component's behavior through an options array.
- **Event-Driven:** Dispatches a custom event with the selected place data for easy handling in your frontend JavaScript.

## Live Demo

See a comprehensive live demo of the underlying JavaScript library in action: [pacservice.pages.dev](https://pacservice.pages.dev/)

<img src="places-autocomplete-js.gif" alt="A video demonstrating the Places Autocomplete JavaScript component in action, showing address suggestions and selection.">

## Requirements

- Laravel 9.x or higher
- A Google Maps API Key with the **Places API** enabled. You can get one from the [Google Cloud Console](https://console.cloud.google.com/google/maps-apis).

## Installation

You can install the package via Composer:

```bash
composer require alexpechkarev/laravel-places-autocomplete
```

## Configuration

1.  Publish the configuration file. This will create a `config/places-autocomplete.php` file where you can set default options. The view file will be published to `resources/views/vendor/places-autocomplete` and the JavaScript files to `public/vendor/places-autocomplete/`.

```bash
php artisan vendor:publish --provider="PlacesAutocomplete\PlacesAutocompleteServiceProvider"
```

2.  Add your Google Maps API key to your `.env` file. This is a required step.

```dotenv
// filepath: .env
GOOGLE_MAPS_API_KEY="YOUR_API_KEY_HERE"
```

## Usage

### 1. Add the Component

Use the `<x-places-autocomplete>` component in your Blade views. Because the component's root element has a dynamically generated ID, the recommended approach is to wrap it in your own `div` with a stable ID. This makes it easy to target with JavaScript.

```php
// filepath: resources/views/your-form.blade.php
<form>
    <label for="address">Address</label>

    {{-- Wrap the component in a div with a known ID --}}
    <div id="address-wrapper">
        <x-places-autocomplete
            root-div-id="address-wrapper"
            :options="[
                'placeholder' => 'Start typing your address...',
            ]"
        />
    </div>

    {{-- Other fields to be populated by JavaScript --}}
    <div class="mt-4">
        <label for="city">City</label>
        <input type="text" id="city" name="city" class="form-control">
    </div>
    <div>
        <label for="postcode">Postcode</label>
        <input type="text" id="postcode" name="postcode" class="form-control">
    </div>
</form>
```

### 2. Handle the Response

When a user selects an address, the component dispatches a `pac-response` custom event on its root `div`. You can listen for this event to receive the place data.

Add the following JavaScript to your application.

```javascript
// filepath: resources/js/app.js
document.addEventListener("DOMContentLoaded", function () {
  // Listen for the custom event emitted by the PlacesAutocomplete component
  document
    .getElementById("address-wrapper")
    .addEventListener("pac-response", function (event) {
      const placeDetails = event.detail;
      //console.log('Place Selected:', placeDetails);

      // Populate other fields based on the selected place details
      if (placeDetails.addressComponents) {
        placeDetails.addressComponents.forEach((component) => {
          if (component.types.includes("postal_town")) {
            document.getElementById("city").value = component.longText;
          }
          if (component.types.includes("postal_code")) {
            document.getElementById("postcode").value = component.longText;
          }
        });
      }
    });

  // Handle errors from the PlacesAutocomplete component
  document
    .getElementById("address-wrapper")
    .addEventListener("pac-error", function (event) {
      console.error("Autocomplete Error:", event.detail);
    });
});
```

## Component Options

You can customize the component by passing an `:options` array. These options are passed to the underlying [places-autocomplete-js](https://github.com/alexpechkarev/places-autocomplete-js) library.

| Option        | Type    | Description                                                    |
| ------------- | ------- | -------------------------------------------------------------- |
| `placeholder` | string  | Placeholder text for the input field.                          |
| `debounce`    | integer | Delay in milliseconds before sending a request (default: 100). |
| `clear_input` | boolean | Whether to clear the input after selection.                    |
| `language`    | string  | The language code for results (e.g., 'en-GB').                 |

For a full list of options, please refer to the [JavaScript library's documentation](https://github.com/alexpechkarev/places-autocomplete-js?tab=readme-ov-file#configuration).

**Note:** The `name` attribute of the generated `<input>` is not currently configurable. The input's data will not be submitted with a standard form post; you must use JavaScript to handle the `pac-response` event and populate your form fields as shown in the example above.

## Support

If you encounter any issues or have questions, please [open an issue on GitHub](https://github.com/alexpechkarev/laravel-places-autocomplete/issues).

## License

This package is open-source software licensed under the [MIT license](https://github.com/alexpechkarev/laravel-places-autocomplete/blob/master/LICENSE).