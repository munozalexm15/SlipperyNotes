

<template>

  <div class="card">
    <div class="card-content sn-blue-fade">
      <p class="title text-white has-text-weight-semibold has-text-left">
        DID YOU KNOW?
      </p>
    </div>
    <footer class="card-footer sn-blue-fade">
      <p class="has-text-left is-size-4 m-5 text-white has-text-weight-medium">
        Slippery Notes allows users to create notes in your browser and helps you remember easily with the use of
        notifications and photos.<br>
        <br>
        More than <b> {{ userCount }} </b> users have already created <b> {{ notesCreated }} </b> notes!
        <br><br>
        What are you waiting for?
        <br>
        <br>
      </p>

    </footer>
  </div>

</template>

<script setup>
  defineProps({
    notesCreated: Number,
    userCount : Number
  });
</script>

<style scoped>

.text-white {
  color: white;
}
</style>