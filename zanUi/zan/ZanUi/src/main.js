// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import Vant from 'vant';
Vue.config.productionTip = false
import 'vant/lib/vant-css/index.css';
Vue.use(Vant);

//引入懒加载
import { Lazyload } from 'vant';
Vue.use(Lazyload);
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})
