import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const routes = [
    { path: '/', component: () => import('../components/Home.vue') },
    { path: '/cadastro', component: () => import('../components/usuario/Cadastro.vue') },
    { path: '/login', component: () => import('../components/usuario/Login.vue') },
    { path: '/publicacoes', component: () => import('../components/publicacao/Publicacoes.vue') },
    { path: '/publicacao/:id', component: () => import('../components/publicacao/Publicacao.vue') },
    { path: '/criarPublicacao', component: () => import('../components/publicacao/CriarPublicacao.vue') },
    { path: '/categoria', component: () => import('../components/categoria/Categoria.vue') },
    { path: '/relatorio', component: () => import('../components/relatorio/Relatorio.vue') },
];

export default new VueRouter({
    routes
});