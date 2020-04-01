import Vuex from 'vuex'
import Vue from 'vue'
import Restaurants from './modules/Restaurants'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'


// Create store
export default new Vuex.Store({
  modules: {
    Restaurants
  },
  strict: debug
})