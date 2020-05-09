<template>
<div>
    <div class="title font-weight-bold">Fill the forms to order {{expert.name}} service</div>
    <v-row>
        <v-col cols="12" sm="12" md="6">
            <v-autocomplete
                v-model="selectedTimezone"
                :items="timezones"
                label="Your Timezone"
            ></v-autocomplete>
            <v-select
                :items="durations"
                v-model="selectedDuration"
                label="Duration"
            ></v-select>
            <v-select
                :items="slots"
                v-model="selectedSlot"
                :loading="loadingSlots"
                label="Slots"
            ></v-select>
            <v-divider></v-divider>
            <div class="align-bottom text-center">
                <v-btn :disabled="!isAllFieldsFilled" color="gradient-bg" class="white--text rounded-pill">Submit</v-btn>
            </div>
        </v-col>
        <v-col cols="12" sm="12" md="6">
            <v-date-picker
                v-model="selectedDate"
                color="gradient-bg"
                :reactive="true"
                :full-width="true"
                :show-current="true"
                :multiple="false"
            ></v-date-picker>
        </v-col>
    </v-row>
</div>
</template>

<script>
    import Timezone from "../api/TimezoneApi";
    import SchedulingApi from "../api/SchedulingApi";
    import ExpertsApi from "../api/ExpertsApi";

    export default {
        name: "Schedule",
        data(){
            return{
                durations: [
                    {text: "15 minutes", value: 15},
                    {text: "30 minutes", value: 35},
                    {text: "45 minutes", value: 45},
                    {text: "1 hour", value: 60},
                ],
                slots: [],
                expert: {},
                loadingSlots: false,
                timezones: [],
                selectedTimezone: "",
                selectedDuration: "",
                selectedDate: new Date().toISOString().substr(0, 10),
                selectedSlot: "",
                expertId: this.$route.params.expertId
            }
        },
        mounted() {
            Timezone.getTimezones().then(list => this.timezones = list).catch(err => console.log(err));
            Timezone.getUserTimezone().then(timezone => this.selectedTimezone = timezone).catch(err => console.log(err));
            ExpertsApi.getExpert(this.expertId).then(expert => this.expert = expert).catch(err => this.$router.push("/"));
        },
        watch:{
            selectedDate(){
                this.getSlots();
            },
            selectedDuration(){
                this.getSlots();
            },
            selectedTimezone(){
                this.getSlots();
            },
        },
        computed:{
          isAllFieldsFilled(){
              const {selectedDate, selectedTimezone, selectedDuration, selectedSlot} = this;
              return (selectedTimezone && selectedDate && selectedDuration && selectedSlot);
          }
        },
        methods:{
            getSlots(){
                const {selectedDate, selectedTimezone, selectedDuration, expertId} = this;
                if(!selectedTimezone || !selectedDate || !selectedDuration)
                    return;

                this.loadingSlots = true;
                SchedulingApi.getTimeSlots(expertId, selectedTimezone, selectedDate, selectedDuration)
                    .then(slots => {
                        this.slots = slots.map(slot => ({text: `${slot.start} - ${slot.end}`, value: slot.start}));
                        this.loadingSlots = false;
                    })
                    .catch(err => {
                        console.error(err);
                        this.loadingSlots = false;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
