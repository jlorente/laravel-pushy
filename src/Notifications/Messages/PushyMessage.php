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

namespace Jlorente\Laravel\Pushy\Notifications\Messages;

/**
 * Description of PushyMessage
 *
 * @author Jose Lorente <jose.lorente.martin@gmail.com>
 * @see https://pushy.me/docs/api/send-notifications
 */
class PushyMessage
{

    /**
     * When set to true, your app's notification handler will be invoked even if 
     * the app is running in the background, making it possible to fetch updated 
     * content from the server or execute other custom logic without necessarily 
     * alerting the user. (iOS only)
     * 
     * @var bool 
     */
    protected $contentAvailable;

    /**
     * The payload data you want to push to devices, limited to 4kb.
     *
     * @var array
     */
    protected $data;

    /**
     * When set to true, your app's Notification Service Extension will be 
     * invoked even if the app is running in the background, making it possible 
     * to download and display rich media attachments within your notification.
     * (iOS only)
     * 
     * @var bool 
     */
    protected $mutableContent;

    /**
     * iOS notification options, such as the alert message, sound, or badge 
     * number. (iOS only)
     *
     * @var array
     */
    protected $notification;

    /**
     * Specifies how long (in seconds) the push notification should be kept if 
     * the device is offline.
     * 
     * @var int 
     */
    protected $ttl;

    /**
     * Pushy class constructor.
     * 
     * @param array $data
     * @param int $ttl
     */
    public function __construct(array $data = [], int $ttl = null)
    {
        if ($data) {
            $this->setData($data);
        }

        $this->setTimeToLive($ttl ?? config('pushy.time_to_live'));
    }

    /**
     * Gets the contentAvailable value.
     * 
     * @return bool|null
     */
    public function getContentAvailable()
    {
        return $this->mutableContent;
    }

    /**
     * Sets the contentAvailable value.
     *
     * @param bool $value
     * @return $this
     */
    public function setContentAvailable(bool $value)
    {
        $this->contentAvailable = $value;
        return $this;
    }

    /**
     * Gets the data value.
     * 
     * @return array|null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Sets the data value.
     *
     * @param array $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Gets the mutableContent value.
     * 
     * @return bool|null
     */
    public function getMutableContent()
    {
        return $this->mutableContent;
    }

    /**
     * Sets the mutableContent value.
     *
     * @param bool $value
     * @return $this
     */
    public function setMutableContent(bool $value)
    {
        $this->mutableContent = $value;
        return $this;
    }

    /**
     * Gets the notification value.
     * 
     * @return array|null
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * Sets the data value.
     *
     * @param array $notification
     * @return $this
     */
    public function setNotification(array $notification)
    {
        $this->notification = $notification;
        return $this;
    }

    /**
     * Gets the ttl value.
     * 
     * @return int|null
     */
    public function getTimeToLive()
    {
        return $this->ttl;
    }

    /**
     * Sets the ttl value.
     *
     * @param int $ttl
     * @return $this
     */
    public function setTimeToLive(int $ttl)
    {
        $this->ttl = $ttl;
        return $this;
    }

    /**
     * Gets the message payload.
     * 
     * @param array|string $tokens
     * @return array
     */
    public function getPayload($tokens = null): array
    {
        $payload = [];

        if ($tokens) {
            $payload['to'] = $tokens;
        }

        if (is_null($this->contentAvailable) === false) {
            $payload['content_available'] = $this->contentAvailable;
        }

        if ($this->data) {
            $payload['data'] = $this->data;
        }

        if (is_null($this->mutableContent) === false) {
            $payload['mutable_content'] = $this->mutableContent;
        }

        if ($this->notification) {
            $payload['notification'] = $this->notification;
        }

        if (is_null($this->ttl) === false) {
            $payload['time_to_live'] = $this->ttl;
        }

        return $payload;
    }

}
