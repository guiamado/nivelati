import Vue from 'vue';
import App from './App.vue';
import vuetify from './plugins/vuetify';
import router from './routes/index';
import VueTheMask from 'vue-the-mask';
import store from './store';
import VueQuillEditor from 'vue-quill-editor';

import 'quill/dist/quill.core.css'; // import styles
import 'quill/dist/quill.snow.css'; // for snow theme
import 'quill/dist/quill.bubble.css'; // for bubble theme
Vue.use(VueQuillEditor);
Vue.use(VueTheMask);

Vue.config.productionTip = false;

new Vue({
  vuetify,
  router,
  store,
  render: h => h(App)
}).$mount('#app');
