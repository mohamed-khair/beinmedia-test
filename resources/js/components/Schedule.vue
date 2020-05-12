<template>
<div>
    <v-overlay :value="overlay" opacity=".8">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <div class="title font-weight-bold">Fill the forms to order {{expert.name}} service</div>
    <v-row>
        <v-col cols="12" sm="12" md="6">
            <v-autocomplete
                v-model="selectedTimezone"
                :loading="loadingTimezones"
                :items="timezones"
                label="Your Timezone"
            ></v-autocomplete>
            <v-text-field v-model="clientName" label="Your Name"></v-text-field>
            <v-select
                :items="durations"
                v-model="selectedDuration"
                label="Duration"
            ></v-select>
            <v-autocomplete
                :items="slots"
                v-model="selectedSlot"
                :loading="loadingSlots"
                label="Available Time Slots"
            ></v-autocomplete>
            <template v-if="hasSubmitted">
                <div class="gradient-bg white--text pa-2">
                    Your have successfully requested an appointment to the expert "{{expert.name}}" on {{selectedDate}}
                    between {{selectedSlotCloned.start}} and {{selectedSlotCloned.end}} according to {{selectedTimezone}} timezone.
                    Thank you.
                </div>
            </template>
        </v-col>
        <v-col cols="12" sm="12" md="6">
            <v-date-picker
                v-model="selectedDate"
                color="gradient-bg"
                :reactive="true"
                :min="nowDate"
                :full-width="true"
                :show-current="true"
                :multiple="false"
            ></v-date-picker>
        </v-col>
    </v-row>
    <v-divider/>
    <v-row>
        <v-col cols="12" sm="12" md="6">
            <div class="d-flex justify-space-around align-items-center text-center">
                <v-btn color="primary" small text class="rounded-pill" @click="$router.go(-1)">Return Back</v-btn>
                <v-btn
                    :loading="loadingSubmit"
                    :disabled="!isAllFieldsFilled"
                    @click="submit"
                    color="gradient-bg"
                    class="white--text rounded-pill">Submit</v-btn>
            </div>
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
                    {text: "30 minutes", value: 30},
                    {text: "45 minutes", value: 45},
                    {text: "1 hour", value: 60},
                ],
                slots: [],
                expert: {},
                overlay: true,
                loadingSlots: false,
                loadingTimezones: false,
                loadingSubmit: false,
                hasSubmitted: false,
                timezones: [],
                selectedTimezone: "",
                selectedDuration: "",
                selectedDate: new Date().toISOString().substr(0, 10),
                selectedSlot: "",
                selectedSlotCloned: "",
                clientName: "",
                expertId: this.$route.params.expertId,
                nowDate: new Date().toISOString().slice(0,10),
            }
        },
        mounted() {
            this.getTimezones();
            ExpertsApi.getExpert(this.expertId).then(expert => {
                this.expert = expert;
                this.overlay = false;
            }).catch(err => this.$router.push("/"));
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
              const {selectedDate, selectedTimezone, selectedDuration, selectedSlot, clientName} = this;
              return (selectedTimezone && selectedDate && selectedDuration && selectedSlot && clientName);
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
                        this.slots = slots.map(slot => ({text: `${slot.start} - ${slot.end}`, value: slot}));
                        this.loadingSlots = false;
                    })
                    .catch(err => {
                        this.$toast.error(err.message);
                        console.error(err);
                        this.loadingSlots = false;
                    });
            },
            submit(){
                const {selectedDate, expertId, clientName, selectedTimezone, selectedSlot} = this;
                this.loadingSubmit = true;
                SchedulingApi.submitRequest(expertId, clientName, selectedDate, selectedSlot.start, selectedSlot.end, selectedTimezone)
                    .then(appointment => {
                        this.hasSubmitted = true;
                        this.$toast.success("success");
                        this.loadingSubmit = false;
                        this.selectedSlotCloned = {...this.selectedSlot};
                        this.selectedSlot = "";
                        this.getSlots();
                    })
                    .catch(err => {
                       this.$toast.error(err.message);
                        this.loadingSubmit = false;
                    });
            },
            getTimezones(){
                this.loadingTimezones = true;
                Timezone.getTimezones().then(list => {
                    this.timezones = list;
                    this.loadingTimezones = false;
                }).catch(err => {
                    this.$toast.error(err.message);
                    this.loadingTimezones = false;
                });
                Timezone.getUserTimezone()
                    .then(timezone => {
                        this.selectedTimezone = timezone;
                        this.$toast.info(`Your timezone is ${timezone}, please change it if it was incorrect.`)
                    })
                    .catch(err => {
                        this.$toast.error(err);
                    });
            }
        }
    }
</script>

<style scoped>

</style>
