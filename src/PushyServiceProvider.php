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

namespace Jlorente\Laravel\Pushy;

use Jlorente\Pushy\Pushy;
use Illuminate\Support\ServiceProvider;

/**
 * Class PushyServiceProvider.
 * 
 * @author Jose Lorente <jose.lorente.martin@gmail.com>
 */
class PushyServiceProvider extends ServiceProvider
{

    /**
     * @inheritdoc
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/pushy.php' => config_path('pushy.php'),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->registerPushy();
    }

    /**
     * {@inheritDoc}
     */
    public function provides()
    {
        return [
            'pushy'
            , 'pushy.config'
            , Pushy::class
        ];
    }

    /**
     * Register the Pushy API class.
     *
     * @return void
     */
    protected function registerPushy()
    {
        $this->app->singleton('pushy', function ($app) {
            $config = $app['config']->get('pushy');
            return new Pushy(
                    isset($config['api_key']) ? $config['api_key'] : null
                    , isset($config['request_retries']) ? $config['request_retries'] : null
            );
        });

        $this->app->alias('pushy', Pushy::class);
    }

}
