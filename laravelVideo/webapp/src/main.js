// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'

Vue.config.productionTip = false
import VueAwesomeSwiper from 'vue-awesome-swiper'
Vue.use(VueAwesomeSwiper)
/* eslint-disable no-new */

import axios from 'axios'
import VueAxios from 'vue-axios'

Vue.use(VueAxios, axios)
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
})
