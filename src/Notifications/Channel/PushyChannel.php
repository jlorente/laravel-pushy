<?php

/**
 * Part of the Pushy Laravel package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Pushy Laravel
 * @version    1.0.0
 * @author     Jose Lorente
 * @license    BSD License (3-clause)
 * @copyright  (c) 2019, Jose Lorente
 */

namespace Jlorente\Laravel\Pushy\Notifications\Channel;

use Illuminate\Notifications\Notification;
use Jlorente\Laravel\Pushy\Notifications\Messages\PushyMessage;
use Jlorente\Pushy\Pushy;

/**
 * Class PushyChannel.
 * 
 * A notification channel to send in notifications through Pushy API.
 *
 * @author Jose Lorente <jose.lorente.martin@gmail.com>
 */
class PushyChannel
{

    /**
     * The Pushy client instance.
     *
     * @var Pushy
     */
    protected $client;

    /**
     * Create a new Pushy channel instance.
     *
     * @param Pushy $client
     * @return void
     */
    public function __construct(Pushy $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return array|bool
     */
    public function send($notifiable, Notification $notification)
    {
        if (!$to = $notifiable->routeNotificationFor('pushy', $notification)) {
            $to = $notifiable->pushy_token;
            if (!$to) {
                return;
            }
        }

        $message = $notification->toPushy($notifiable);

        $payload = $message instanceof PushyMessage ? $message->getPayload() : $message;
        $payload['to'] = $to;

        if (config('pushy.is_channel_active') === true) {
            return $this->client->api()->sendNotifications($payload);
        } else {
            return true;
        }
    }

}
