<?php

/*
 * This file is part of Laravel Swap.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Options.
    |--------------------------------------------------------------------------
    |
    | The options to pass to Swap amongst:
    |
    | * cache_ttl: The cache ttl in seconds.
    */
    'options' => [
        'cache_ttl' => 3600,
    ],

    /*
    |--------------------------------------------------------------------------
    | Services
    |--------------------------------------------------------------------------
    |
    | This option specifies the services to use with their name as key and
    | their config as value.
    |
    | Here is the config spec for each service:
    |
    | * "central_bank_of_czech_republic", "central_bank_of_republic_turkey", "european_central_bank", "google",
    |   "national_bank_of_romania", "webservicex", "russian_central_bank", "cryptonator", "bulgarian_national_bank"
    |   can be enabled with "true" as value.
    |
    | * 'fixer' => [
    |       'access_key' => 'secret', // Your access key
    |       'enterprise' => true, // True if your access key is a paying one
    |   ]
    |
    | * 'currency_layer' => [
    |       'access_key' => 'secret', // Your access key
    |       'enterprise' => true, // True if your access key is a paying one
    |   ]

    | * 'coin_layer' => [
    |       'access_key' => 'secret', // Your access key
    |       'paid' => true, // True if your access key is a paying one
    |   ]

    | * 'forge' => [
    |       'api_key' => 'secret', // The API token
    |   ]
    |
    | * 'open_exchange_rates' => [
    |       'app_id' => 'secret', // Your app id
    |       'enterprise' => true, // True if your AppId is an enterprise one
    |   ]
    |
    | * 'xignite' => [
    |       'token' => 'secret', // The API token
    |   ]
    |
    | * 'currency_data_feed' => [
    |       'api_key' => 'secret', // The API token
    |   ]
    |
    | * 'currency_converter' => [
    |       'api_key' => 'access_key', // The API token
    |       'enterprise' => true, // True if your AppId is an enterprise one
    |   ]
    |
    | * 'xchangeapi' => [
    |       'api-key' => 'secret', // The API token
    |   ]

    |
    */
    'services' => [
        // 'fixer' => ['access_key' => env('FIXER_API_KEY'), 'enterprise' => false],
        'currency_layer' => ['access_key' => env('CURRENCY_LAYER_ACCESS_KEY'), 'enterprise' => false],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | This option specifies the Laravel cache store to use.
    |
    | 'cache' => 'file'
    */
    'cache' => 'file',

    /*
    |--------------------------------------------------------------------------
    | Http Client.
    |--------------------------------------------------------------------------
    |
    | The HTTP client service name to use.
    */
    'http_client' => null,

    /*
    |--------------------------------------------------------------------------
    | Request Factory.
    |--------------------------------------------------------------------------
    |
    | The Request Factory service name to use.
    */
    'request_factory' => null,
];
