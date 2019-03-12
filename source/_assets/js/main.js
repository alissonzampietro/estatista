window.toggleMenu = () => document
  .querySelector('.side-menu')
  .classList
  .toggle('side-menu--visible');

if (typeof IntersectionObserver != 'undefined') {
  window.imagesObserver = new IntersectionObserver((entries, observer) => {
    entries.filter((entry) => entry.isIntersecting).forEach((entry) => {
      const target = entry.target;
      target.setAttribute('src', target.getAttribute('data-src'));

      observer.unobserve(target);
    });
  }, {
    rootMargin: '-20px',
  });

  document.querySelectorAll('img[data-src]').forEach((img) => window.imagesObserver.observe(img));

  window.commentsObserver = new IntersectionObserver((entries, observer) => {
    entries.filter((entry) => entry.isIntersecting).forEach((entry) => {
      if (window.initDisqus) {
        window.initDisqus();
      }

      observer.unobserve(entry.target);
    });
  });

  window.commentsObserver.observe(document.querySelector('.episode__comments'));
} else {
  setTimeout(() => {
    document.querySelectorAll('img[data-src]').forEach((img) => img.setAttribute('src', img.getAttribute('data-src')));
  }, 400);
}
