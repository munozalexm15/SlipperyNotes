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
    type: Date,
    required: false
  },
  color: {
    type: String,
    required: false,
    default: "#1F9BFD"
  }
});

var textColor = "#ffffff";

var colorFinal = tinycolor(props["color"]);

//Using getBrightness instead of isLight() to make default note color have text color white
if (colorFinal.getBrightness() <= 115) {
  textColor = "#000000";
}

var starterColor = props["color"].toString();
var colorFinalDark = tinycolor(props["color"]).darken(15).toString();

console.log(starterColor, " ", colorFinalDark);


//get the date from the prop, create a new date and get the values
var date = new Date(props.reminderDate.date);

var day = date.getDate()
var month = date.getMonth() + 1;
var year = date.getFullYear();
</script>

<template>
  <div class="card sn-card-fade" data-tilt>
    <div class="card-content ">
      <p class="title sn-card-color-text has-text-weight-semibold has-text-left">
       {{ title }}
      </p>
    </div>
    <footer class="card-footer is-fullheight ">
      <div class="has-text-left is-size-4 m-5 has-text-weight-medium is-fullheight">
        <p class="sn-card-color-text" style="height: 90%">
          {{ content }}
        </p>

        <p class="is-fixed-bottom sn-card-color-text">
          <span class="mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"><path stroke-linejoin="round" d="M18.934 14.98a3 3 0 0 1-.457-1.59V9.226a6.477 6.477 0 0 0-12.954 0v4.162a3 3 0 0 1-.457 1.592l-1.088 1.74a1 1 0 0 0 .848 1.53h14.348a1 1 0 0 0 .848-1.53z"/><path d="M10 21.25h4"/></g></svg>
          </span>{{day}}-{{ month }}-{{year}}</p>
      </div>

    </footer>
  </div>

</template>

<style scoped>

.sn-card-fade {
  background-image: linear-gradient(to right, v-bind(starterColor), v-bind(colorFinalDark));
}

.sn-card-color-text {
  color: v-bind(textColor);
}

.card-footer {
  min-height: 30vh;
}

p {
  color: white;
}

</style>