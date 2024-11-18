<script setup>
defineProps({
  text: String
});
</script>

<template>
  <button class="button is-rounded is-size-5 bg">{{ text }}</button>
</template>

<style scoped>

.bg {

  box-shadow: 0px 0px 0px;
}

</style>