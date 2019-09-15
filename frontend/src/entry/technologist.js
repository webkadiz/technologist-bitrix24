import 'materialize-css/dist/css/materialize'
import 'materialize-css/dist/js/materialize'

import 'regenerator-runtime'

import vuetify from '@/core/vuetify'
import '@/index.scss'

import Vue from 'vue'

import store from '@/core/store'
import router from '@/core/router'
import created from '@/core/created'
import MixinsProvider from '@/plugins/mixins-provider'
import LodashProvider from '@/plugins/lodash-provider'
import HeaderPanel from "@/components/header-panel";
import Library from "@/components/library-details/library";
import Report from "@/components/report";
import Errors from "@/components/errors"

Vue.use(MixinsProvider)
Vue.use(LodashProvider)

new Vue({
  el: "#app",
  store,
  vuetify,
  router,
  created,
  components: {
    Library,
    HeaderPanel,
    Report,
    Errors
  }
});
