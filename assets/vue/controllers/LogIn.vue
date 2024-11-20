<template>
    <div class="columns fullscreen has-2-cols hero-body no-border-padding-margin is-centered has-text-centered">

        <section class="column is-6-desktop-only is-0-mobile hero is-fullheight is-has-background-white no-border-padding-margin">
            <figure class="image is-128x128">
                <img :src="require('../../images/Logo-noJoin.png')"/>
            </figure>
        </section>

        <section class="section column is-6-desktop is-12-tablet is-12-mobile hero is-fullheight sn-blue-fade no-border-padding-margin">
            <div class="hero-body is-centered">
                <div class="sn-card card">
                    <div class="card-content">
                      <p class="title has-text-weight-semibold has-text-left">
                        LOG IN
                      </p>
                    </div>
                    <footer class="card-footer">

                    </footer>
                </div>
            </div>
        </section>

    </div>

</template>

<script setup>
    defineProps({
        name: String
    });
</script>
