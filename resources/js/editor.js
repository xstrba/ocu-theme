import domReady from '@wordpress/dom-ready';
import registerGutBlocks from "../../gut-blocks/blocks.js";


domReady(() => {
  registerGutBlocks();
});
