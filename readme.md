### Linkedin API integration for Laravel Framework
[![Build Status](https://travis-ci.org/mauri870/laravel-linkedin.svg?branch=master)](https://travis-ci.org/mauri870/laravel-linkedin) [![Coverage Status](https://coveralls.io/repos/mauri870/laravel-linkedin/badge.svg?branch=master&service=github)](https://coveralls.io/github/mauri870/laravel-linkedin?branch=master) [![Latest Stable Version](https://poser.pugx.org/mauri870/laravel-linkedin/v/stable)](https://packagist.org/packages/mauri870/laravel-linkedin) [![Total Downloads](https://poser.pugx.org/mauri870/laravel-linkedin/downloads)](https://packagist.org/packages/mauri870/laravel-linkedin) [![Latest Unstable Version](https://poser.pugx.org/mauri870/laravel-linkedin/v/unstable)](https://packagist.org/packages/mauri870/laravel-linkedin) [![License](https://poser.pugx.org/mauri870/laravel-linkedin/license)](https://packagist.org/packages/mauri870/laravel-linkedin)

This package is a wrapper for [Happyr/LinkedIn-API-client](https://github.com/Happyr/LinkedIn-API-client).
You can view the basic intructions [here](https://github.com/Happyr/LinkedIn-API-client/blob/master/Readme.md). Don't forget to consult the oficial [LinkedIn API](https://developer.linkedin.com/) site.

> I encourage users to test the branch [psr-7](https://github.com/mauri870/laravel-linkedin/tree/psr-7) , which is being adopted the psr-7 structure and the independence of an specific http-client. Once the dependencies are stable I will be merge. Please report any bugs or problems.

#### Install with composer
```bash
composer require mauri870/laravel-linkedin
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
php artisan vendor:publish --provider="Mauri870\LinkedIn\LinkedinServiceProvider"
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
     echo  "Welcome ".$user['firstName'];
     exit();
}elseif (LinkedIn::hasError()) {
     echo  "User canceled the login.";
     exit();
}

//if not authenticated
$url = LinkedIn::getLoginUrl();
echo "<a href='$url'>Login with LinkedIn</a>";
exit();
```


#### Get basic profile info
You can retrive information using the `get()` method, like this:
```php
LinkedIn::get('v1/people/~:(firstName,num-connections,picture-url)');
```
This query return an array of information. You can view all the `REST` api's methods in [REST API Console](https://apigee.com/console/linkedin)

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
```


You may of course do the same in xml. Use the following options array.
```php
$options = array(
'format' => 'xml',
'body' => '<share>
 <comment>Im testing Happyr LinkedIn client! https://github.com/Happyr/LinkedIn-API-client</comment>
 <visibility>
   <code>anyone</code>
 </visibility>
</share>');
```

## Configuration

### The api options

The third parameter of `LinkedIn::api` is an array with options. Below is a table of array keys that you may use. 

| Option name | Description
| ----------- | -----------
| body | The body of a HTTP request. Put your xml string here. 
| format | Set this to 'json', 'xml' or 'simple_xml' to override the default value.
| headers | This is HTTP headers to the request
| json | This is an array with json data that will be encoded to a json string. Using this option you do need to specify a format. 
| response_data_type | To override the response format for one request 
| query | This is an array with query parameters



### Changing request format

The default format when communicating with LinkedIn API is json. You can let the API do `json_encode` for you. 
The following code shows you how. 

```php
$body = array(
    'comment' => 'Im testing Happyr LinkedIn client! https://github.com/Happyr/LinkedIn-API-client',
    'visibility' => array('code' => 'anyone')
);

LinkedIn::post('v1/people/~/shares', array('json'=>$body));
LinkedIn::post('v1/people/~/shares', array('body'=>json_encode($body)));
```

When using `array('json'=>$body)` as option the format will always be `json`. You can change the request format in three ways.

```php
// By setter
LinkedIn::setFormat('xml');

// Set format for just one request
LinkedIn::post('v1/people/~/shares', array('format'=>'xml', 'body'=>$body));
```


### Understanding response data type

The data type returned from `LinkedIn::api` can be configured. You may use the
`LinkedIn::setResponseDataType` or as an option for `LinkedIn::api`

```php
// By setter
LinkedIn::setResponseDataType('simple_xml');

// Set format for just one request
LinkedIn::get('v1/people/~:(firstName,lastName)', array('response_data_type'=>'psr7'));

```

Below is a table that specifies what the possible return data types are when you call `LinkedIn::api`.

| Type | Description
| ------ | ------------
| array | An assosiative array. This can only be used with the `json` format.
| simple_xml | A SimpleXMLElement. See [PHP manual](http://php.net/manual/en/class.simplexmlelement.php). This can only be used with the `xml` format.
| psr7 | A PSR7 response.
| stream | A file stream.
| string | A plain old string.

### Using different scopes

If you want to define special scopes when you authenticate the user you should specify them when you are generating the 
login url. If you don't specify scopes LinkedIn will use the default scopes that you have configured for the app.  

```php
$scope = 'r_fullprofile,r_emailaddress,w_share';
//or 
$scope = array('rw_groups', 'r_contactinfo', 'r_fullprofile', 'w_messages');

$url = LinkedIn::getLoginUrl(array('scope'=>$scope));
return "<a href='$url'>Login with LinkedIn</a>";
```
