<template>
    <v-card
        class="mx-auto h-100 hvr-float"
    >
        <v-img
            src="/images/avatar.png"
            class="img-fluid"
        ></v-img>

        <v-card-title class="text-center justify-center" v-html="expert.name">
        </v-card-title>

        <v-card-subtitle class="text-center" v-html="expert.expert"></v-card-subtitle>

        <v-card-actions>
            <v-btn text color="primary" @click="bookExpert">Book</v-btn>

            <v-spacer></v-spacer>

            <v-btn
                icon
                @click="show = !show"
            >
                <v-icon>{{ show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
            </v-btn>
        </v-card-actions>

        <v-expand-transition>
            <div v-show="show">
                <v-divider class="mx-1"></v-divider>
                <v-card-text class="pt-0">
                    <div>Country: <span class="font-weight-bold" v-html="expert.country"></span></div>
                    <div>Working Hours: <span class="font-weight-bold">{{expert.start_work}} - {{expert.end_work}}</span> </div>
                </v-card-text>
            </div>
        </v-expand-transition>
    </v-card>
</template>

<script>
    export default {
        name: "ExpertCard",
        props: ["expert"],
        data(){
            return{
                show: false
            }
        },
        methods:{
            bookExpert(){
                this.$router.push({name: 'schedule', params: {expertId: this.expert.id}});
            }
        }
    }
</script>

<style scoped>

</style>
