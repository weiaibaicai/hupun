<?php

namespace Weiaibaicai\Hupun;

use Illuminate\Support\ServiceProvider;

class HupunServiceProvider extends ServiceProvider
{

    /**
     * 启动程序服务.
     */
    public function boot()
    {
        $this->publishes([
        __DIR__ . '/../config/hupun.php' => config_path('hupun.php'),
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../config/hupun.php', config_path('hupun'));
    }

    /**
     * 注册服务提供者.
     */
    public function register()
    {
        $this->app->singleton('hupun', function ($app) {
            return new Client(config('hupun'));
        });
    }

    /**
     * 获取由提供者提供的服务.
     *
     * @return array
     */
    public function provides()
    {
        return ['hupun'];
    }
}
