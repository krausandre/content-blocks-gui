<template>
  <h1>{{ fetchFromState }}</h1>
</template>

<script>

export default {
  data() {
    return {
    }
  },
  computed: {
    fetchFromState(){
      return this.$store.getters.currentContentBlock;
    }
  }
}


</script>



<style scoped>
</style>
