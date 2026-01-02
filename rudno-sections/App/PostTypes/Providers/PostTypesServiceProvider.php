<?php

declare(strict_types=1);

namespace Plugin\PostTypes\Providers;

use Plugin\Common\Parents\AbstractServiceProvider;
use Plugin\PostTypes\Repositories\PostTypesRepository;

final class PostTypesServiceProvider extends AbstractServiceProvider
{
    public function register(): void
    {
        $this->app->getServiceContainer()->withSingleton(PostTypesRepository::class, static function (): PostTypesRepository {
            return new PostTypesRepository();
        });
    }
}
