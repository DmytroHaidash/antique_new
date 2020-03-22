<template>
    <modal name="insert-image-modal" :adaptive="true" :scrollable="true" height="auto">
        <div class="p-4">
            <div class="mb-3 pb-3 border-bottom">
                <div class="btn-group">
                    <button
                            class="btn"
                            :class="mode === 'browser' ? 'btn-primary' : 'btn-outline-primary'"
                            @click.prevent="mode = 'browser'"
                    >
                        Выбрать
                    </button>

                    <button
                            class="btn"
                            :class="mode === 'upload' ? 'btn-primary' : 'btn-outline-primary'"
                            @click.prevent="mode = 'upload'"
                    >
                        Загрузить
                    </button>
                </div>
            </div>

            <component :is="`image-${mode}`" @insert="insertImage"></component>
        </div>
    </modal>
</template>

<script>
  import ImageBrowser from './ImageBrowser';
  import ImageUpload from './ImageUpload';

  export default {
    components: {
      ImageBrowser,
      ImageUpload
    },

    data() {
      return {
        mode: 'upload',
        command: null,
      }
    },

    methods: {
      showModal({command}) {
        this.command = command;
        this.$modal.show('insert-image-modal');
      },

      insertImage(imageSrc) {
        this.$modal.hide('insert-image-modal');
        this.$emit('insert', {
          command: this.command,
          data: {
            src: imageSrc
          }
        })
      }
    }
  }
</script>