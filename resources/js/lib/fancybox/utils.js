import {Fancybox} from "@fancyapps/ui";
import FancyboxSk from "./lang/sk.js";

const initializeFigure = (figure, isGallery = false) => {
  const img = figure.querySelector('img');
  if (img && !figure.querySelector('a')) {  // Only if not already wrapped
    const link = document.createElement('a');

    link.href = img.getAttribute('data-src-webp')
      || img.getAttribute('data-src')
      || img.src;

    if (isGallery) {
      link.setAttribute('data-fancybox', 'gallery'); // group for Fancybox
    }

    link.setAttribute('target', '_blank');
    link.setAttribute('title', img.getAttribute('alt'));
    link.appendChild(img.cloneNode(true));
    figure.innerHTML = ''; // clear figure contents
    figure.appendChild(link);
  }
};

export async function initImageCards() {
  document.querySelectorAll('div.b-image-card__image-wrapper').forEach(figure => {
    initializeFigure(figure);

    Fancybox.bind(figure, 'a', {
      hideScrollbar: false,
      l10n: FancyboxSk,
    });
  })
}

export async function initWpImages() {
  document.querySelectorAll('figure.wp-block-image:not(.wp-block-gallery figure.wp-block-image)').forEach(figure => {
    initializeFigure(figure);

    Fancybox.bind(figure, 'a', {
      hideScrollbar: false,
      l10n: FancyboxSk,
    });
  })
}

export async function initWpGalleries() {
  document.querySelectorAll('.wp-block-gallery').forEach(gallery => {
    gallery.querySelectorAll('figure').forEach(figure => {
      initializeFigure(figure, true);
    })

    Fancybox.bind(gallery, 'figure a', {
      hideScrollbar: false,
      l10n: FancyboxSk,
    });
  });
}

export async function init() {
  Fancybox.bind("[data-zoomable]", {
    hideScrollbar: false,
    l10n: FancyboxSk,
  });

  await initImageCards();
  await initWpGalleries();
  await initWpImages();
}
