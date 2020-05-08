<template>
<div>
    <div class="title font-weight-bold">Let's select an expert for your next work ...</div>
    <div>
        <swiper :options="swiperOptions">
            <swiper-slide><expert-card></expert-card></swiper-slide>
            <swiper-slide><expert-card></expert-card></swiper-slide>
            <swiper-slide><expert-card></expert-card></swiper-slide>
            <div class="swiper-pagination" slot="pagination"></div>
        </swiper>
    </div>
</div>
</template>

<script>
    import ExpertCard from "./ExpertCard";
    import { Swiper, SwiperSlide, directive } from 'vue-awesome-swiper'
    import swiperOptions from "../plugins/swiperOptions";

    export default {
        name: "Experts",
        components: {ExpertCard, Swiper, SwiperSlide},
        directives: {
            swiper: directive
        },
        data(){
            return {
                swiperOptions
            }
        }
    }
</script>

<style scoped>

</style>
