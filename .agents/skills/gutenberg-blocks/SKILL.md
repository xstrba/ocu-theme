---
name: gutenberg-blocks
description: Trigger this skill when the user asks to create or modify a custom Gutenberg block, adjust block styling in the editor, or troubleshoot block rendering.
---

# Custom Gutenberg Blocks

This theme avoids reliance on third-party block providers (like ACF blocks) and implements native React Gutenberg blocks dynamically. 

## Where to Find Blocks
Blocks are located in the `gut-blocks/` directory at the root of the theme.

## Architecture
- Each block typically gets its own folder (e.g., `gut-blocks/image-card/`).
- Inside the folder are its configuration/React file (`image-card.js`) and its styles (`_image-card.scss`).
- New components must be registered/imported into the main entry:
  - Add to `gut-blocks/blocks.js`.
  - Import styles into `gut-blocks/blocks.scss` (or `resources/css/editor.scss` depending on mapping).

## Compilation
Editor assets are bundled using Vite.
Any changes to inside `gut-blocks/` will be natively handled by the Vite builder commands defined in `package.json` (`npm run dev` and `npm run build`), which compile the final editor javascript footprint.
