<template>
    <div class="mt-6">
        <accounting
                v-for="(price, index) in accountings.price"
                :accountings="accountings"
                :index="index"
                :key="price.hash"
                @removeAccounting="removeAccounting(index)"/>
        <p>Итого: {{total}}</p>
        <input type="hidden" name="accountings[amount]" :value="total">
        <button class="btn btn-outline-primary" @click.prevent="addAccounting">
            Добавить статью расходов
        </button>

    </div>
</template>

<script>
  import Accounting from './Accounting'

  export default {
    data() {
      return {
        accountings: {
          price: [...this.price],
          message: [...this.message],
          amount: this.total
        },
      }
    },

    components: {
      Accounting
    },

    props: {
      price: Array,
      message: Array
    },
    mounted() {
      if (!this.price) {
        this.addAccounting();
      }
    },
    computed: {
      total: function () {
        return this.accountings.price.reduce(function (total, item) {
          return total + Number(item);
        }, 0);
      }
    },
    methods: {
      addAccounting() {
        this.accountings.message.push('');
        this.accountings.price.push('');
      },
      removeAccounting(index) {
        this.accountings.price.splice(index, 1);
        this.accountings.message.splice(index, 1);
      }
    }
    ,
  }
</script>
