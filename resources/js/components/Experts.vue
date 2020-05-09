<template>
<div>
    <div class="title font-weight-bold">Let's select an expert for your next work ...</div>
    <div>
        <swiper :options="swiperOptions">
            <swiper-slide v-for="expert in experts" :key="expert.id">
                <expert-card :expert="expert"></expert-card>
            </swiper-slide>
            <div class="swiper-pagination" slot="pagination"></div>
        </swiper>
    </div>
</div>
</template>

<script>
    import ExpertCard from "./ExpertCard";
    import { Swiper, SwiperSlide, directive } from 'vue-awesome-swiper'
    import swiperOptions from "../plugins/swiperOptions";
    import ExpertsApi from "../api/ExpertsApi";

    export default {
        name: "Experts",
        components: {ExpertCard, Swiper, SwiperSlide},
        directives: {
            swiper: directive
        },
        data(){
            return {
                swiperOptions,
                experts: []
            }
        },
        mounted() {
            ExpertsApi.getExperts()
            .then(experts => this.experts = experts);
        }
    }
</script>

<style scoped>

</style>
