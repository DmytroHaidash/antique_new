module.exports = ($) => {
  const $panel = $('.search-panel');

  $('[data-show-search]').on('click', function () {
    $panel.fadeIn();
  });

  $(document).on('click', e => {
    if (!$panel.is(e.target) && !$panel.parent().has(e.target).length) {
      $panel.fadeOut();
    }
  });
};
