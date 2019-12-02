Pushy SDK for Laravel
=========================
Laravel integration for the Pushy SDK including a notification channel.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

With Composer installed, you can then install the extension using the following commands:

```bash
$ php composer.phar require jlorente/laravel-pushy
```

or add 

```json
...
    "require": {
        "jlorente/laravel-pushy": "*"
    }
```

to the ```require``` section of your `composer.json` file.

## Configuration

1. Register the ServiceProvider in your config/app.php service provider list.

config/app.php
```php
return [
    //other stuff
    'providers' => [
        //other stuff
        \Jlorente\Laravel\Pushy\PushyServiceProvider::class,
    ];
];
```

2. Add the following facade to the $aliases section.

config/app.php
```php
return [
    //other stuff
    'aliases' => [
        //other stuff
        'Pushy' => \Jlorente\Laravel\Pushy\Facades\Pushy::class,
    ];
];
```

3. Publish the package in order to copy the configuration file to the config folder.

```bash
$ php artisan vendor:publish
```

4. Set the api_key in the config/pushy.php file or use the predefined env 
variables.

config/pushy.php
```php
return [
    'api_key' => 'YOUR_SECRET_API_KEY',
    //other configuration
];
```
or 
.env
```
//other configurations
PUSHY_API_KEY=<YOUR_SECRET_API_KEY>
PUSHY_NOTIFICATION_TTL=<YOUR_CUSTOM_VALUE>
```

## Usage

You can use the facade alias Pushy to execute api calls. The authentication 
params will be automaticaly injected.

```php
Pushy::api()->deviceInfo($token);
```

## Notification Channel

A notification channel is included in this package and allows you to integrate 
the Pushy send notifications service with the Laravel notifications.

### Formatting Notifications

If you want to send a notification to Pushy, you should define a toPushy method 
on the notification class. This method will receive a $notifiable entity and 
should return a Jlorente\Laravel\Pushy\Notifications\Messages\PushyMessage instance 
or an array with the payload to be sent on the notification:

```php
/**
 * Get the PushyMessage that represents the notification.
 *
 * @param  mixed  $notifiable
 * @return \Jlorente\Laravel\Pushy\Notifications\Messages\PushyMessage|array
 */
public function toPushy($notifiable)
{
    return (new PushyMessage)
                ->setData([
                    'eventName' => 'my_event_name'
                ])
                ->setTimeToLive(3600);
}
```

Once done, you must add the notification channel in the array of the via() method 
of the notification:

```php
/**
 * Get the notification channels.
 *
 * @param  mixed  $notifiable
 * @return array|string
 */
public function via($notifiable)
{
    return [PushyChannel::class];
}
```

You can find more info about Laravel notifications in [this page](https://laravel.com/docs/5.6/notifications).

### Routing the Notifications

When sending notifications via Pushy channel, the notification system will 
automatically look for a pushy_token attribute on the notifiable entity. If 
you would like to customize the token of the device the notification is delivered to, 
define a routeNotificationForPushy method on the entity:

```php
<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Route notifications for the Pushy channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForPushy($notification)
    {
        return $this->device_token;
    }
}
```

You can find more info about Laravel notifications in [this page](https://laravel.com/docs/5.6/notifications).

## License 
Copyright &copy; 2019 José Lorente Martín <jose.lorente.martin@gmail.com>.

Licensed under the BSD 3-Clause License. See LICENSE.txt for details.
