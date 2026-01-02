<?php

declare(strict_types=1);

namespace Plugin\Common;

final class ServiceContainer
{
    /**
     * @var array<class-string<mixed>, \Closure(self): mixed>
     */
    private array $binds;

    /**
     * @var array<class-string<mixed>, \Closure(self): mixed>
     */
    private array $singletons;

    /**
     * @var array<class-string<mixed>, mixed>
     */
    private array $resolved;

    public function __construct()
    {
        $this->binds = [];
    }

    /**
     * @template T of class-string<mixed>
     *
     * @param T $classString
     * @param \Closure(self): T $resolver
     *
     * @return $this
     */
    public function withBinding(string $classString, \Closure $resolver): self
    {
        $this->binds[$classString] = $resolver;

        return $this;
    }

    /**
     * @template T of class-string<mixed>
     *
     * @param T $classString
     * @param \Closure(self): T $resolver
     *
     * @return $this
     */
    public function withSingleton(string $classString, \Closure $resolver): self
    {
        $this->singletons[$classString] = $resolver;

        return $this;
    }

    /**
     * @template T of class-string<mixed>
     *
     * @param T $classString
     *
     * @return T
     */
    public function make(string $classString)
    {
        if (isset($this->resolved[$classString])) {
            return $this->resolved[$classString];
        }

        if (isset($this->binds[$classString])) {
            $resolver = $this->binds[$classString];

            return $resolver($this);
        }

        if (isset($this->singletons[$classString])) {
            $resolver = $this->singletons[$classString];

            $instance = $this->resolved[$classString] = $resolver($this);

            unset($this->singletons[$classString]);

            return $instance;
        }

        return new $classString();
    }
}
