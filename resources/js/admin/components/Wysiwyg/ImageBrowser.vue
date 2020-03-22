<template>
    <div class="d-flex flex-wrap browser">
        <div class="browser__item">
            <button
                    class="border p-1"
                    v-for="image in images"
                    :key="image.id"
                    @click.prevent="$emit('insert', image.full_url)"
            >
                <img :src="image.thumb_url" :alt="image.id">
            </button>
        </div>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        images: []
      }
    },

    methods: {
      getImages() {
        axios.get('/admin/media/browser').then(({data}) => this.images = data)
      }
    },

    mounted() {
      if (!this.images.length) {
        this.getImages();
      }
    }
  }
</script>

<style lang="scss" scoped>
    .browser {
        margin: -10px;
        &__item {
            padding: 10px;
        }
    }
</style>