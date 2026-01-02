<?php

declare(strict_types=1);

namespace Plugin\Common;

use Plugin\Common\Parents\AbstractServiceProvider;
use Plugin\PostTypes\Repositories\PostTypesRepository;

final class Application
{
    private static self $instance;

    /**
     * @var array<array-key, \Closure>
     */
    private array $initCbs;

    /**
     * @var array<array-key, \Plugin\Common\Parents\AbstractServiceProvider>
     */
    private array $serviceProviders;

    /**
     * @var \Plugin\Common\ServiceContainer
     */
    private ServiceContainer $serviceContainer;

    /**
     * @var array<array-key, \Closure>
     */
    private array $addMetaBoxesActionCbs;

    /**
     * @var array<array-key, \Closure(\WP_Query): void>
     */
    private array $preGetPostsCbs;

    private function __construct()
    {
        $this->initCbs = [];
        $this->serviceProviders = [];
        $this->addMetaBoxesActionCbs = [];
        $this->preGetPostsCbs = [];

        $this->serviceContainer = new ServiceContainer();
    }

    public static function getInstance(): self
    {
        return self::$instance ??= new self();
    }

    /**
     * @param \Plugin\Common\Parents\AbstractServiceProvider $provider
     */
    public function withServiceProvider(AbstractServiceProvider $provider): void
    {
        $this->serviceProviders[] = $provider->withApp($this);
    }

    public function register(): void
    {
        foreach ($this->serviceProviders as $serviceProvider) {
            $serviceProvider->register();
        }

        $this->callInit();
        $this->callAddMetaBoxesAction();
        $this->callPreGetPostsAction();

        $this->serviceProviders = [];
    }

    public function initCb(\Closure $closure): void
    {
        $this->initCbs[] = $closure;
    }

    public function registerPostType(string $postTypeName, array $args)
    {
        register_post_type($postTypeName, $args);

        $this->getServiceContainer()->make(PostTypesRepository::class)->addPostType($postTypeName);
    }

    /**
     * @return \Plugin\Common\ServiceContainer
     */
    public function getServiceContainer(): ServiceContainer
    {
        return $this->serviceContainer;
    }

    /**
     * @param \Closure $cb
     */
    public function registerAddMetaBoxesAction(\Closure $cb): void
    {
        $this->addMetaBoxesActionCbs[] = $cb;
    }

    /**
     * @param string $id
     * @param string $screen
     * @param string $context
     */
    public function removeMetaBox(string $id, string $screen, string $context): void
    {
        remove_meta_box($id, $screen, $context);
    }

    /**
     * @param string $taxonomyName
     * @param array<array-key, string> $postTypes
     * @param array $args
     */
    public function registerTaxonomy(string $taxonomyName, array $postTypes, array $args)
    {
        register_taxonomy($taxonomyName, $postTypes, $args);
    }

    /**
     * @param string $postType
     * @param \Closure(array<string,string>): array<string,string> $cb
     */
    public function addManageEditCPTColumnsFilter(string $postType, \Closure $cb): void
    {
        add_filter( 'manage_edit-' . $postType . '_columns', $cb);
    }

    /**
     * @param string $postType
     * @param \Closure(string): void $cb
     */
    public function addManageCPTPostsCustomColumnAction(string $postType, \Closure $cb): void
    {
        add_action( 'manage_'. $postType .'_posts_custom_column', $cb, 10);
    }

    /**
     * @param string $postType
     * @param \Closure(array<string, string>): array<string, string> $cb
     */
    public function addManageEditCPTSortableColumnsFilter(string $postType, \Closure $cb): void
    {
        add_filter('manage_edit-' . $postType . '_sortable_columns', $cb);
    }

    /**
     * @param \Closure(\WP_Query): void $cb
     */
    public function registerPreGetPostsCb(\Closure $cb): void
    {
        $this->preGetPostsCbs[] = $cb;
    }

    private function callInit(): void
    {
        add_action('init', function (...$args): void {
            foreach ($this->initCbs as $cb) {
                $cb($this, ...$args);
            }

            $this->initCbs = [];
        });
    }

    private function callAddMetaBoxesAction(): void
    {
        add_action('add_meta_boxes', function (...$args) {
            foreach ($this->addMetaBoxesActionCbs as $cb) {
                $cb($this, ...$args);
            }

            $this->addMetaBoxesActionCbs = [];
        });
    }

    private function callPreGetPostsAction(): void
    {
        add_action('pre_get_posts', function (\WP_Query $query) {
            foreach ($this->preGetPostsCbs as $cb) {
                $cb($query);
            }

            $this->preGetPostsCbs = [];
        });
    }
}
