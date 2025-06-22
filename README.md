# laravel-places-autocomplete

Easily integrate the Places (New) Autocomplete - JavaScript library into Laravel Blade views. Provides a user-friendly way to search for and retrieve detailed address information in any web application.

## Installation
Install the package via Composer:

```bash
composer require alexpechkarev/laravel-places-autocomplete
```

## Usage
In your Blade view, you can use the `<x-places-autocomplete>` component to render the autocomplete input field. You can pass options as an array to customize the behavior of the component.
```php
<x-places-autocomplete
        :options="['placeholder' => 'Start typing your address...', 'clear_input' => false, 'debounce' => 100]"  />
        
```
