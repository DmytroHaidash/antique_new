export default {
  data() {
    return {
      visible: false
    }
  },

  methods: {
    toggle() {
      this.visible = !this.visible;
    }
  }
}
