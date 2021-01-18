<?php

namespace App\Providers;

use App\Services\SocialUserResolver;
use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        JsonResource::withoutWrapping();
    }

    public $bindings = [
        SocialUserResolverInterface::class => SocialUserResolver::class,
    ];
}
