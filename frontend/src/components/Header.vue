<template>
  <v-app-bar app color="grey lighten-4">
    <router-link :to="'/'" style="text-decoration: none">
      <div class="d-flex align-center">
        <v-img
          alt="Cooper Logo"
          class="shrink mr-2"
          contain
          :src="require('@/assets/images/logoCooper_small_v2.png')"
          transition="scale-transition"
          width="160"
        />
        <v-img
          alt="Nivela Logo"
          class="shrink mr-2"
          contain
          :src="require('@/assets/images/logoNivelaTI.png')"
          transition="scale-transition"
          width="130"
        />
        <!-- <span class="black--text">NIVELA T.I.</span> -->
      </div>
    </router-link>

    <v-spacer></v-spacer>

    <!-- <v-btn
      href="https://github.com/vuetifyjs/vuetify/releases/latest"
      target="_blank"
      text
    >
      <span class="mr-2">Latest Release</span>
      <v-icon>mdi-open-in-new</v-icon>
    </v-btn> -->
    <v-btn text @click="mudarRota('/')">
      <span :class="{ 'blue--text': isTelaPublicacoes }">Fórum</span>
    </v-btn>
    <v-btn text @click="mudarRota('/criarPublicacao')" v-if="token">
      <span :class="{ 'blue--text': isTelaCriarPublicacao }"
        >Faça uma publicação</span
      >
    </v-btn>
    <v-btn text @click="mudarRota('/categoria')" v-if="token">
      <span :class="{ 'blue--text': isTelaCategoria }">Categoria</span>
    </v-btn>
    <v-btn text @click="mudarRota('/login')" v-if="!token">
      <span :class="{ 'blue--text': isTelaLogin }">Login</span>
    </v-btn>
    <v-btn text @click="realizarLogout" v-if="token">
      <span>Logout</span>
    </v-btn>
  </v-app-bar>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  name: "Header",
  data() {
    return {
      isTelaLogin: false,
      isTelaPublicacoes: false,
      isTelaCategoria: false,
      isTelaCriarPublicacao: false,
    };
  },
  created() {
    this.verificarRotas();
  },
  watch: {
    $route() {
      this.verificarRotas();
    },
  },
  computed: {
    ...mapGetters({
      token: "logginStore/token",
    }),
  },
  methods: {
    ...mapActions({
      logoutAction: "logginStore/logoutAction",
    }),
    verificarRotas() {
      this.isTelaLogin = false;
      this.isTelaPublicacoes = false;
      this.isTelaCategoria = false;
      this.isTelaCriarPublicacao = false;

      if (this.$route.path === "/login" || this.$route.path === "/cadastro") {
        this.isTelaLogin = true;
      }
      if (this.$route.path === "/") {
        this.isTelaPublicacoes = true;
      }
      if (this.$route.path === "/categoria") {
        this.isTelaCategoria = true;
      }
      if (this.$route.path === "/criarPublicacao") {
        this.isTelaCriarPublicacao = true;
      }
    },
    mudarRota(rota) {
      if (this.$route.path == rota) return;
      this.$router.push({ path: rota });
    },
    realizarLogout() {
      this.logoutAction()
        .then((res) => {
          if (res.data) {
            this.mudarRota("/login");
          }
        })
        .catch(() => {
          this.mudarRota("/login");
        });
    },
  },
};
</script>

<style>
</style>