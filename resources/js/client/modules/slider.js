import Flickity from 'flickity';
import 'flickity-as-nav-for';
import 'flickity/dist/flickity.css';

const bannerSlider = document.querySelector('.slides');

if(bannerSlider){
  let prevBannerArrowReviews = document.querySelector('.slidenav__item--prev');
  let nextBannerArrowReviews = document.querySelector('.slidenav__item--next');

  const flktyB = new Flickity(bannerSlider, {
    wrapAround: true,
    prevNextButtons: false,
    cellAlign: 'center',
    contain: true,
    pageDots: false,
    draggable: false,
    autoPlay: 3000
  });

  if(prevBannerArrowReviews){
    nextBannerArrowReviews.addEventListener('click', function () {
      flktyB.next(true, false);
    });
  }

  if(nextBannerArrowReviews){
    prevBannerArrowReviews.addEventListener('click', function () {
      flktyB.previous(true, false);
    });
  }
}