import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)

const opts = {
    theme: {
        themes: {
            light: {
                primary: "#363dc2",
                secondary: "#03b9f1",
                accent: ""
            },
        },
    },
}

export default new Vuetify(opts)
