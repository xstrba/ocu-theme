---
name: compiling-assets
description: Use this skill when the user asks to compile assets, run a dev server, handle frontend build issues, or manipulate vite setup within this Sage theme.
---

# Compiling Theme Assets

The `ocu-theme` utilizes **Vite** for the asset pipeline instead of Webpack (Laravel Mix).

## How to Compile

1. **Development Server (HMR)**:
   ```bash
   npm run dev
   ```
   Runs a Vite development server with Hot Module Replacement (HMR) for instant updates.

2. **Production Build**:
   ```bash
   npm run build
   ```
   Minifies, hashes, and outputs assets to the `public/build/` directory for production.

## Configuration & Structure
- The build targets and configurations are managed in `vite.config.js`.
- Key frontend entry points:
  - JS: `resources/js/app.js`
  - SCSS: `resources/css/app.scss`
- Key editor/backend entry points (for Gutenberg blocks):
  - JS: `resources/js/editor.js`
  - SCSS: `resources/css/editor.scss`

**Notice:** The `theme.json` file is automatically generated from the Vite configuration (`@roots/vite-plugin`), disabling Tailwind features.
