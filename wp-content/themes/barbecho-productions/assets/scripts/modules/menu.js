const $ = window.jQuery

/**
 * Mobile navigation toggle
 * @param {Event} event
 */

const toggleMenu = (event) => {
  event.preventDefault();
  $('.js-menu-toggle').toggleClass('open');
  $('body').toggleClass('menu-open');
  $('.header__navigation').fadeToggle(250);
};

export const initMenu = () => {
  $('.js-menu-toggle').on('click', toggleMenu);
}
