module.exports = ($) => {
  $('[data-toggle]').on('click', function () {
    const name = $(this).data('toggle');
    const target = $(`[data-toggle-target="${name}"]`);

    if (target.length) target.slideToggle();
  })
};