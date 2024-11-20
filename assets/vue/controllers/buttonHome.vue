<script setup>

defineProps({
  text: String
});

</script>

<template>
  <button class="button is-rounded button-rounded-no-outline is-size-5 bg">
    <span class="txt-sp is-size-4">{{ text }}</span>
  </button>
</template>

<style scoped>

.bg {
  box-shadow: 0px 0px 0px;
}

.button-rounded-no-outline {
  border-color: white;
  background: none;
}

.txt-sp {
  background-image: linear-gradient(to left, #1F9BFD, #1F73FE);
  color: transparent;
  background-clip: text;
}


button:hover {
  border-color: #0281e8;
  border-radius: var(--bulma-radius-rounded);
  padding-left: calc(var(--bulma-button-padding-horizontal) + 0.25em - var(--bulma-button-border-width));
  padding-right: calc(var(--bulma-button-padding-horizontal) + 0.25em - var(--bulma-button-border-width));
}

</style>