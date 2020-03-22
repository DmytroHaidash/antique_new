<template>
    <div>
        <div class="mb-2">
            <label for="upload" class="p-1 border">
                <figure :style="{backgroundImage: `url('${image.thumb_url}')`}"></figure>
            </label>

            <input type="file" accept="image/*" id="upload" @change="onImageLoaded">
        </div>

        <button
                class="btn btn-primary"
                :disabled="!image.full_url"
                @click.prevent="confirmUpload"
        >
            Вставить
        </button>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        image: {
          thumb_url: '/images/no-image.png',
          full_url: null
        },
        file: null
      }
    },

    methods: {
      onImageLoaded(event) {
        const reader = new FileReader();
        this.file = event.target.files[0];

        if (this.file) {
          reader.onload = () => {
            this.image.thumb_url = reader.result;
            this.image.full_url = reader.result;
          };

          reader.readAsDataURL(this.file);
        }
      },

      confirmUpload() {
        const formData = new FormData();
        formData.set('image', this.file);
        this.uploadFile(formData);
      },

      async uploadFile(formData) {
        await axios.post('/admin/media/browser', formData)
            .then(({data}) => {
              if (data) {
                this.$emit('insert', data.full_url);
              }
            });
      },
    }
  }
</script>

<style lang="scss" scoped>
    label {
        position: relative;
        width: 200px;
        height: 200px;

        figure {
            height: 100%;
            background-position: 50% 50%;
            background-size: cover;
            background-repeat: no-repeat;
        }
    }

    [type="file"] {
        position: absolute;
        left: -9999px;
    }
</style>