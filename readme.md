## Linkedin API integration for Laravel Framework

This package is a wrapper for [Happyr/LinkedIn-API-client](https://github.com/Happyr/LinkedIn-API-client).
You can view the basic intructions [here](https://github.com/Happyr/LinkedIn-API-client/blob/master/Readme.md). Don't forget to consult the oficial [LinkedIn API](https://developer.linkedin.com/) site.

#### Install with composer
```bash
composer require mauri870/laravel-linkedin:dev-master
```

#### Add service Provider
```
Mauri870\LinkedIn\LinkedinServiceProvider::class,
```

#### Facade
```
'LinkedIn'  => \Mauri870\LinkedIn\Facades\LinkedIn::class,
```

#### Publish config file
```
php artisan vendor:publish --provider="Mauri870\LinkedIn\LinkedinServiceProvider" --tag="config"
```

### Usage

In order to use this API client (or any other LinkedIn clients) you have to [register your app](https://www.linkedin.com/developer/apps) 
with LinkedIn to receive an API key. Once you've registered your LinkedIn app, you will be provided with
an *API Key* and *Secret Key*, please fill this values on `linkedin.php` config file.

####Basic Usage
The unique difference in this package is the `LinkedIn` facade. Instead of this:
```php
$linkedIn=new Happyr\LinkedIn\LinkedIn('app_id', 'app_secret');
$linkedin->foo();
```
you can simple call the facade for anyone method, like this:
```php
LinkedIn::foo();
```
The service container automatically return an instance of `LinkedIn` class ready to use

#### LinkedIn login

This example below is showing how to login with LinkedIn using `LinkedIn` facade.

```php 
if (LinkedIn::isAuthenticated()) {
     //we know that the user is authenticated now. Start query the API
     $user=LinkedIn::get('v1/people/~:(firstName,lastName)');
     return "Welcome ".$user['firstName'];
}elseif (LinkedIn::hasError()) {
     return  "User canceled the login.";
}

//if not authenticated
$url = LinkedIn::getLoginUrl();
return "<a href='$url'>Login with LinkedIn</a>";
```

#### How to post on LinkedIn wall

The example below shows how you can post on a users wall. The access token is fetched from the database. 

```php
LinkedIn::setAccessToken('access_token_from_db');

$options = ['json'=>
     [
        'comment' => 'Im testing Happyr LinkedIn client with Laravel Framework! https://github.com/mauri870/laravel-linkedin',
        'visibility' => [
               'code' => 'anyone'
        ]
     ]
];

$result = LinkedIn::post('v1/people/~/shares', $options);

dd($result);
```
