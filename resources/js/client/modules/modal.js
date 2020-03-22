$('.modal-btn').on('click', function (e) {
  e.preventDefault();

  let modalId = $(this).data('modal-open');

  $(`#${modalId}`).toggle();
  $('.custom-modal-mask').toggle();
});

$('.custom-modal--close').on('click', function () {

  $('.custom-modal').toggle();
  $('.custom-modal-mask').toggle();
})


$('.custom-modal-mask').on('click', function () {
  $('.custom-modal').toggle();
  $(this).toggle();
})
$('.modal-button').on('click', function (e) {
  e.preventDefault();

  let modalId = $(this).data('modal-opened');

  $(`#${modalId}`).toggle();
  $('.custom-modal-2-mask').toggle();
});

$('.custom-modal-2--close').on('click', function () {

  $('.custom-modal-2').toggle();
  $('.custom-modal-2-mask').toggle();
})


$('.custom-modal-2-mask').on('click', function () {
  $('.custom-modal-2').toggle();
  $(this).toggle();
})