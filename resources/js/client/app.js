import jQuery from 'jquery';
import Vue from 'vue';
import FileUploader from './components/FileUploader'
new Vue({
    el: '#app',
    components: {
        FileUploader
    }
});
window.$ = window.jQuery = jQuery;

const observer = require('lozad')();
observer.observe();
require('./modules/modal');
require('./modules/slider');
require('./modules/masonry');
require('./modules/youtube');

(function ($) {
  require('./modules/nav')($);
  require('./modules/teaser')($);
  require('./modules/toggle')($);
  require('./modules/search')($);

  if (!localStorage.getItem('intro')) {
    $('#intro').show();
  }

  $('#intro .close').on('click', function () {
    $('#intro').fadeOut();
    localStorage.setItem('intro', 'false');
  });

})(jQuery);
