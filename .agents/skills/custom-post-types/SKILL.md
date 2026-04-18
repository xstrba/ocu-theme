---
name: custom-post-types
description: Trigger this skill when creating a new custom post type, taxonomy, updating existing post types, or dealing with backend custom logic inside the rudno-sections folder.
---

# Managing Custom Post Types

The custom post types (CPTs) in this theme are handled cleanly inside the `rudno-sections/` module.

## Location & Registration
- **CPT Definitions**: Define specific post structures in `rudno-sections/src/post_types/`.
- **Loading**: To add a new CPT, create your file in the `post_types` directory, and include it inside `rudno-sections/functions.php` like so:
  ```php
  include('src/post_types/your-new-type.php');
  ```

## App/ Namespace
- Service providers or more complex business logic linked to CPTs (or the admin dashboard) sit in `rudno-sections/App/`.
- The autoloader automatically maps `Plugin\\` to `rudno-sections/App/` via `composer.json` PSR-4 declarations. Do not forget to dump autoloader if adding new classes:
  ```bash
  composer dump-autoload
  ```

## Blade Templates
When a CPT is created (e.g., `rudno-news`), be sure to create its matching single and archive blade templates in `resources/views/`:
- `single-rudno-news.blade.php`
- `archive-rudno-news.blade.php`
