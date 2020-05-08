<template>
    <v-app id="inspire">
        <v-content>
            <v-container
                class="fill-height gradient-bg"
                fluid
            >
                <v-row
                    align="center"
                    justify="center"
                >
                    <v-col
                        cols="12"
                    >
                        <v-card class="elevation-12 main-card">
                            <v-card-text>
                                <div class="headline font-weight-black mb-3">Expert Scheduler</div>
                                <router-view></router-view>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    export default {
        name: "App"
    }
</script>

<style lang="scss">
.main-card{
    min-height: 500px;
    max-width: 760px!important;
    margin: auto;
}
</style>
