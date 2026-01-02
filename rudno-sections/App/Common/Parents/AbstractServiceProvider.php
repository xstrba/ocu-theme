<?php

declare(strict_types=1);

namespace Plugin\Common\Parents;

use Plugin\Common\Application;

abstract class AbstractServiceProvider
{
    protected Application $app;

    abstract public function register(): void;

    /**
     * @param \Plugin\Common\Application $app
     *
     * @return $this
     */
    public function withApp(Application $app): self
    {
        $this->app = $app;

        return $this;
    }
}
