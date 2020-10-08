import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const routes = [
    { path: '/', component: () => import('../components/Home.vue') },
    { path: '/cadastro', component: () => import('../components/usuario/Cadastro.vue') },
    { path: '/publicacoes', component: () => import('../components/publicacao/Publicacoes.vue') },
];

export default new VueRouter({
    routes
});