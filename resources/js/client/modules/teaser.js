module.exports = ($) => {
  $('.teaser').hover(function (event) {
    let offset = 0;
    const title = $(this).find('.teaser__title');
    const description = $(this).find('.teaser__description');

    if (description) {
      offset = description.innerHeight();

      if (event.type === 'mouseenter') {
        title.css({
          transform: `translateY(-${offset}px)`
        });
      } else {
        title.css('transform', 'translateY(0)');
      }
    }
  });
}