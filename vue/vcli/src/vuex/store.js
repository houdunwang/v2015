import Vue from 'vue'
import Vuex from 'vuex'
import news from '@/vuex/news'
import users from '@/vuex/users'
Vue.use(Vuex)

export default new Vuex.Store({
    modules:{
        news,users
    }
});