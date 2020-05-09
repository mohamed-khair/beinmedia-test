<template>
<div>
    <v-overlay :value="overlay" opacity=".8">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <div class="title font-weight-bold">Let's select an expert for your next work ...</div>
    <div>
        <swiper :options="swiperOptions" v-show="!overlay">
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
                experts: [],
                overlay: true,
            }
        },
        mounted() {
            ExpertsApi.getExperts()
                .then(experts => {
                    this.overlay = false;
                    this.experts = experts;
                })
                .catch(err => {
                    this.overlay = false;
                    this.$toast.error(err.message);
                })
        }
    }
</script>

<style scoped>

</style>
