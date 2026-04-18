# Sage Theme Project: ocu-theme

This documentation is designed to provide AI agents and developers with a comprehensive overview of the `ocu-theme` WordPress theme architecture, features, and structure.

## Overview
- **Based on**: Roots Sage (roots/sage via Acorn)
- **Primary Use**: Municipalities ("Slovenské obce a mestá"), initially tailored for Nitrianske Rudno and extended.
- **Tech Stack**:
  - PHP >= 8.2 (Leveraging modern PHP features, PSR-4 autoloading)
  - Laravel Blade templates (via Roots Acorn)
  - Vite (for asset bundling, SCSS, JS)
  - Bootstrap (v4.3.1)
  - Gutenberg Blocks (React/JS/SCSS)

## Architecture & Logic Flow

### 1. The Core Theme (`app/`, `resources/`)
The main framework is a typical Sage 10 structure:
- **`app/`**: Contains the PHP application logic (Providers, Services, Enums, View Composers).
  - `setup.php`: Registers theme supports, nav menus, customizes the block editor (injecting styles and scripts), and controls global WP behaviors.
  - `filters.php`: WP filters logic.
- **`resources/`**:
  - `views/`: Contains Blade templates (`.blade.php`).
    - There are specific page templates (e.g., `page-starosta.blade.php`, `page-faktury.blade.php`) and standard WordPress hierarchy templates (e.g., `archive-*`, `single-*`).
  - `css/`, `js/`, `fonts/`, `images/`: Frontend assets managed by Vite.

### 2. The Modular Plugin Application (`rudno-sections/`)
This is essentially an integrated WordPress plugin embedded within the theme. It manages the custom backend features, keeping the theme's core codebase clean.
- **Namespace**: `Plugin\\` mapped to `rudno-sections/App/`.
- **Purpose**: Registers Custom Post Types (CPTs), settings, and manages the WordPress Admin architecture.
- **Key Features**:
  - **Custom Post Types**: Found in `rudno-sections/src/post_types/`. Includes: News (`news`), Events (`events`), Documents (`documents`), People (`people`), Seating (`seating`), Official Board (`ocu-official-board`), Homepage Menu, Tutorials, and Useful Links. Main configuration is defined across `functions.php` and the loaded source files.
  - **Admin Tweaks**: Hides default WP Posts and Comments. Removes Yoast/WPCode admin modules from these custom post types.
  - **Service Providers**: Leverages a Laravel-style container (`\Plugin\Common\Application`) passing Service Providers (e.g. `PostTypesServiceProvider`).

### 3. Custom Gutenberg Blocks (`gut-blocks/`)
The theme maintains its own suite of native Gutenberg blocks rather than relying on ACF blocks or third parties.
- Housed in the `/gut-blocks/` directory.
- Features modular architecture (`blocks.js` points to individual modules).
- Blocks natively extend WP Block editor styles and are compiled into `editor.js` via Vite.
- Includes distinct components like `document` and `image-card`.

## Build Process (Vite)
- Configured via `vite.config.js`.
- **Key Entry Points**: 
  - frontend: `resources/css/app.scss` & `resources/js/app.js`
  - backend/editor: `resources/css/editor.scss` & `resources/js/editor.js`
- Outputs to `public/build/`.
- Automatically emits `theme.json` based on Vite configuration through `@roots/vite-plugin`.
- Commands: 
  - `npm run dev` (development mapping)
  - `npm run build` (production packaging)

## Localization
- Translating capabilities rely on core WP i18n CLI wrapper mappings.
- The `package.json` specifies commands:
  - `npm run translate:pot`
  - `npm run translate:update` 
  - `npm run translate:compile`
- Assets map to `resources/lang/`.
