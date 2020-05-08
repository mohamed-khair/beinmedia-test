import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)

const opts = {
    theme: {
        themes: {
            light: {
                primary: "#03b9f1",
                secondary: "#363dc2",
                accent: ""
            },
        },
    },
}

export default new Vuetify(opts)
