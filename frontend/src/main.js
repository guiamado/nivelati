import Vue from 'vue';
import App from './App.vue';
import vuetify from './plugins/vuetify';
import router from './routes/index';
import VueTheMask from 'vue-the-mask';
import store from './store';

Vue.use(VueTheMask)

Vue.config.productionTip = false;

new Vue({
  vuetify,
  router,
  store,
  render: h => h(App)
}).$mount('#app');
