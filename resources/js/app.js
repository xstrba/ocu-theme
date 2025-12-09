import.meta.glob([
  '../images/**',
  '../fonts/**',
]);

import './autoload/_bootstrap.js';

import "@fancyapps/ui/dist/fancybox/fancybox.css";
import { init as initFancyBox } from "./lib/fancybox/utils.js";

window.addEventListener('load', async function () {
  initFancyBox().then(() => {});

  // FOCUS ON SEARCH INPUT
  $('#search-modal').on('shown.bs.modal', function () {
    $('#search-modal #menu-search-field').focus();
  });

  // MENU SHADOW
  let openedMenu = 0;

  const selector = '#mobile-dropdown-nav, #desktop-accordion > .collapse';

  // set shadow on opened menu
  $(selector).on('show.bs.collapse', function () {
    openedMenu++;
    $('.nr-banner__base-menu').addClass('nr-banner__base-menu--shadow');
  });

  // hide shadow on closed menu
  $(selector).on('hide.bs.collapse', function () {
    openedMenu--;
    if(openedMenu === 0)
      $('.nr-banner__base-menu').removeClass('nr-banner__base-menu--shadow');
  });
}, false);
