<template>
    <div class="columns fullscreen">
        <section class="column is-half has-background-white is-fullheight">
            <figure class="image is-1024x1024">
                <img :src="require('../../images/Logo-noJoin.png')"/>
            </figure>
        </section>
        <section class="column is-half has-background-info is-fullheight">
            COMEDME LOS HUEVOS
        </section>
    </div>
    
</template>

<script setup>
    defineProps({
        name: String
    });
</script>
