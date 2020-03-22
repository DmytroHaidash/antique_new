<template>
    <div>
        <datepicker
                :value="date"
                :language="ru"
                :name="name"
                :monday-first="true"
                :full-month-name="false"
                format="dd.MM.yyyy"
                input-class="form-control"/>
    </div>
</template>

<script>
  import Datepicker from 'vuejs-datepicker';
  import translation from 'vuejs-datepicker/dist/locale/translations/ru';

  export default {
    components: {
      Datepicker
    },
    props: {
      name: String,
      date: {
        type: String,
        default() {
          return Date();
        }
      }
    },
    data() {
      return {
        ru: translation
      }
    }
  }
</script>