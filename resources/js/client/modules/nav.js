module.exports = ($) => {
  const $submenu = $('.submenu');

  $('a[href^="#"]').on('click', function (e) {
    e.preventDefault();
  });

  $('.nav-item a').on('click', function () {
    const parent = $(this).parent();

    if (parent.find($submenu).length) {
      parent.toggleClass('is-opened');
      parent.find($submenu).fadeToggle().focus();
    }
  });

  $(document).on('click', e => {
    if (!$submenu.parent().is(e.target) && !$submenu.parent().has(e.target).length) {
      $submenu.parent().removeClass('is-opened');
      $submenu.fadeOut();
    }
  });

  $('[data-toggle-nav]').on('click', function() {
    $('.app-nav').fadeIn().css({display: 'flex'});
  });

  $('[data-close-nav]').on('click', function() {
    $('.app-nav').fadeOut();
  })
};