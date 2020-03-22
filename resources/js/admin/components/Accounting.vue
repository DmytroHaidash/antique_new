<template>
    <div  class="row">
        <div class="form-group col-5">
            <label :for="`price[${index}]`">Себестоимость</label>
            <input type="number" class="form-control" min="0" :id="`price[${index}]`"
                   :name="`accountings[price][${index}]`"
                   v-model="accountings.price[index]" required>
        </div>
        <div class="form-group col-6">
            <label :for="`message[${index}]`">Комментарий</label>
            <input type="text" class="form-control" :id="`message[${index}]`"
                   :name="`accountings[message][${index}]`"
                   v-model="accountings.message[index]">
        </div>
        <div class="col-1" style="margin-top: 2.5rem">
            <button class="btn btn-outline-primary" @click.prevent="removeAccounting">X</button>
        </div>
    </div>
</template>

<script>
  export default {
    props: {
      accountings: Object,
      index: Number,
    },

    methods: {
      removeAccounting() {
        this.$emit('removeAccounting');
      },
    }
  }
</script>
