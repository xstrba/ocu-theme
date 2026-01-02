<?php

declare(strict_types=1);

namespace Plugin\PostTypes\Repositories;

final class PostTypesRepository
{
    /**
     * @var array<string, string>
     */
    private array $postTypes;

    public function __construct()
    {
        $this->postTypes = [];
    }

    /**
     * @param string $postTypeName
     */
    public function addPostType(string $postTypeName): void
    {
        $this->postTypes[$postTypeName] = $postTypeName;
    }

    /**
     * @param string $postTypeName
     *
     * @return bool
     */
    public function hasPostType(string $postTypeName): bool
    {
        return isset($this->postTypes[$postTypeName]);
    }

    /**
     * @return array<string, string>
     */
    public function getAll(): array
    {
        return $this->postTypes;
    }
}
