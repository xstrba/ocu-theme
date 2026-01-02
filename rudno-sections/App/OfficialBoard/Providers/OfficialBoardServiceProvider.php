<?php

declare(strict_types=1);

namespace Plugin\OfficialBoard\Providers;

use Plugin\Common\Application;
use Plugin\Common\Parents\AbstractServiceProvider;
use Plugin\OfficialBoard\MetaBoxes\ContentMetaBox;
use Plugin\OfficialBoard\MetaBoxes\DocumentTypeMetaBox;
use Plugin\OfficialBoard\Registrars\OfficialBoardRegistrar;
use Plugin\OfficialBoard\Registrars\OfficialBoardTableRegistrar;
use Plugin\OfficialBoard\Registrars\OfficialBoardTaxonomyRegistrar;

final class OfficialBoardServiceProvider extends AbstractServiceProvider
{
    public function register(): void
    {
        $this->app->initCb(static function (Application $app): void {
            $app->getServiceContainer()->make(OfficialBoardRegistrar::class)->register($app);
            $app->getServiceContainer()->make(OfficialBoardTaxonomyRegistrar::class)->register($app);
            $app->getServiceContainer()->make(OfficialBoardTableRegistrar::class)->register($app);

            $app->getServiceContainer()->make(ContentMetaBox::class)->register($app);
            $app->getServiceContainer()->make(DocumentTypeMetaBox::class)->register($app);
        });
    }
}
