require('./bootstrap');
import Vue from 'vue';
import VModal from 'vue-js-modal'

import Wysiwyg from './components/Wysiwyg'
import MultiUploader from './components/MultiUploader'
import SingleUploader from './components/SingleUploader'
import BlockEditor from './components/BlockEditor'
import Datepicker from './components/Datepicker'
import Accountings from './components/Accountings';
import PasswordChange from "./components/PasswordChange";

Vue.use(VModal);

new Vue({
  el: '#app',
  components: {
    Wysiwyg,
    SingleUploader,
    MultiUploader,
    BlockEditor,
    Datepicker,
    Accountings,
    PasswordChange
  },
  mounted() {
    require('./modules/notifications');
    require('./modules/phone-mask');
  }
});
