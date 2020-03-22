<template>
    <div>
        <draggable v-model="images" class="row images-list mb-2">
            <div class="col-md-6 col-lg-3" v-for="(image, index) in images" :key="image.id">
                <div class="image-preview image-preview--loaded rounded" v-if="!!image.link"
                     :style="{backgroundImage: `url(${image.link})`}">
                    <button class="btn btn-danger btn-squire rounded-circle"
                            @click.prevent="removeImage(index)">
                        <i class="i-trash"></i>
                    </button>
                </div>

                <div class="image-preview image-preview--preloader rounded" v-if="!image.link">
                    <div class="preloader">
                        <div class="item-1"></div>
                        <div class="item-2"></div>
                        <div class="item-3"></div>
                    </div>
                </div>
            </div>
        </draggable>

        <label class="position-relative image-uploader d-block rounded bg-light p-4">
            <input type="file" accept="image/*" multiple @change="handleImages">
            <input type="hidden" :name="name ? name+'[]' : 'uploads[]'" :value="image.id" v-for="(image, index) in images" :key="index">
            <input type="hidden" name="deletion[]" :value="image" v-for="(image, index) in deletion" :key="index">

            <div class="text-center">
                Загрузить изображения
                <div v-if="tooltip">({{ tooltip }})</div>
            </div>
        </label>
    </div>
</template>

<script>
  import Draggable from 'vuedraggable'

  export default {
    components: {
      Draggable
    },
    props: {
      src: Array,
      model: String,
      modelId: Number | String,
      tooltip: String,
      name: {
        type: String,
        default() {
          return 'uploads';
        }
      },
    },
    data() {
      return {
        images: this.src || [],
        deletion: []
      }
    },
    methods: {
      async uploadFile(formData, tempImage) {
        await axios.post('/admin/media/upload', formData)
            .then(({data}) => {
              const index = this.images.indexOf(tempImage);

              if (index >= 0) {
                this.$set(this.images, index, data);
              }
            });
      },

      handleImages(event) {
        const fileList = event.target.files;

        if (!fileList.length) return;

        for (let i = 0; i < event.target.files.length; i++) {
          const formData = new FormData();

          let file = fileList[i];
          formData.set('image', file);

          if (this.model && this.modelId) {
            formData.set('model', this.model);
            formData.set('model_id', this.modelId);
          }

          const tempImage = {
            id: i + '-temp',
            link: null,
            name: null,
            delete: null
          };

          this.images.push(tempImage);
          this.uploadFile(formData, tempImage);
        }
      },

      removeImage(index) {
        this.deletion.push(this.images[index].id);
        this.images.splice(index, 1);
      }
    }
  }
</script>

<style lang="scss" scoped>
    .previews {
        margin: -0.5rem;
    }

    .images-list {
        margin: -0.5rem;

        [class^="col"] {
            padding: 0.5rem;
        }
    }

    .image-preview {
        position: relative;
        background-size: cover;
        background-position: 50% 50%;
        background-repeat: no-repeat;
        padding-top: 100%;
        overflow: hidden;

        &--preloader {
            .preloader {
                position: absolute;
                left: 0;
                right: 0;
                top: 0;
                bottom: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                overflow: hidden;
                animation-delay: 1s;
            }
        }

        .btn-danger {
            opacity: 0;
            padding: 0;
            position: absolute;
            top: 5px;
            right: 5px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            transition: 0.35s;
            transform: scale(0);

            svg {
                margin: auto;
                fill: #fff;
            }
        }

        &:hover {
            .btn-danger {
                opacity: 1;
                visibility: visible;
                transform: scale(1);
            }
        }
    }

    .image-uploader {
        overflow: hidden;

        [type="file"] {
            position: absolute;
            left: -9999px;
        }
    }

    $color-1: #eed968;
    $color-2: #eead68;
    $color-3: #ee8c68;

    $color: $color-1, $color-2, $color-3;

    @mixin anim() {
        @keyframes scale {
            0% {
                transform: scale(1);
            }
            50%,
            75% {
                transform: scale(2.5);
            }
            78%, 100% {
                opacity: 0;
            }
        }
    }

    @for $i from 1 through 3 {
        .item-#{$i} {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: nth($color, $i);
            margin: 7px;
            display: flex;
            justify-content: center;
            align-items: center;
            @include anim();

            &:before {
                content: '';
                width: 12px;
                height: 12px;
                border-radius: 50%;
                background-color: nth($color, $i);
                opacity: 0.7;
                animation: scale 2s infinite cubic-bezier(0, 0, 0.49, 1.02);
                animation-delay: 200ms * $i;
                transition: 0.5s all ease;
                transform: scale(1);
            }
        }
    }

</style>
