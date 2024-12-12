<script setup>

import tinycolor from "tinycolor2";

const props = defineProps({
  title: {
    type: String,
    required: true
  },
  content: {
    type: String,
    required: false
  },
  reminderDate: {
    type: Object,
    required: false,
  },
  color: {
    type: String,
    required: false,
    default: "#1F9BFD"
  }
});

let textColor = "#ffffff";

let colorFinal = tinycolor(props["color"]);

//Using getBrightness instead of isLight() to make default note color have text color white
if (colorFinal.getBrightness() >= 140) {
  textColor = "#000000";
}

let starterColor = props["color"].toString();
let colorFinalDark = tinycolor(props["color"]).darken(15).toString();

//get the date from the prop, create a new date and get the values
let day = null
let month = null
let year = null

let hours = null
let minutes = null

if (props.reminderDate !== undefined) {
  let date = new Date(props.reminderDate.date);

  day = date.getDate()
  month = date.getMonth() + 1;
  year = date.getFullYear();
  hours = date.getHours();
  minutes = date.getMinutes();
  if (minutes < 10) {
    minutes = "0" + minutes;
  }
  if (hours < 10) {
    hours = "0" + hours;
  }
}
</script>

<template>
  <div id="notePreview" class="card sn-card-fade">
    <div class="card-content ">
      <div class="title sn-card-color-text has-text-weight-semibold has-text-left">
        <p>{{ title }}</p>

      </div>
    </div>
    <footer class="card-footer mx-5 mb-5 pb-2 is-fullheight ">
      <div class="is-size-5 has-text-weight-medium is-fullheight">
        <div class="sn-card-color-text card-footer-container">
          <div v-html="content"></div>
        </div>

        <p v-if="reminderDate !== undefined" class="is-fixed-bottom sn-card-color-text mt-2">
          <span class="mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"><path stroke-linejoin="round" d="M18.934 14.98a3 3 0 0 1-.457-1.59V9.226a6.477 6.477 0 0 0-12.954 0v4.162a3 3 0 0 1-.457 1.592l-1.088 1.74a1 1 0 0 0 .848 1.53h14.348a1 1 0 0 0 .848-1.53z"/><path d="M10 21.25h4"/></g></svg>
          </span> <span v-if="minutes !== '00' || hours !== '00'">{{hours}}:{{minutes}} | </span>{{day}}-{{ month }}-{{year}}</p>
      </div>

    </footer>
  </div>

</template>

<style scoped>

p {
  /* Both of the following are required for text-overflow */
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.sn-card-fade {
  background-image: linear-gradient(to right, v-bind(starterColor), v-bind(colorFinalDark));
  user-select: none;
}

.sn-card-color-text {
  color: v-bind(textColor);
}

.sn-card-title {
  text-overflow: ellipsis;
}

.card-footer-container {
  height: 85%;
  text-overflow: ellipsis;
  overflow: hidden;
}

.card-footer {
  max-height: 28vh;
  min-height: 28vh;
}


img {
  align-self: center;
  padding-top: 1em;
  max-width: 200px;
  max-height: 200px;
}



</style>