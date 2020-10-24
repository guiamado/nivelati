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
          width="160"
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
    <v-btn text @click="mudarRota('/publicacoes')">
      <span :class="{ 'blue--text': isTelaPublicacoes }">Fórum</span>
    </v-btn>
    <v-btn text @click="mudarRota('/')">
      <span :class="{ 'blue--text': isTelaLogin }">Login</span>
    </v-btn>
  </v-app-bar>
</template>

<script>
export default {
  name: "Header",
  data() {
    return {
      isTelaLogin: false,
      isTelaPublicacoes: false,
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
  methods: {
    verificarRotas() {
      this.isTelaLogin = false;
      this.isTelaPublicacoes = false;
      if (this.$route.path === "/" || this.$route.path === "/cadastro") {
        this.isTelaLogin = true;
      }
      if (this.$route.path === "/publicacoes") {
        this.isTelaPublicacoes = true;
      }
    },
    mudarRota(rota) {
      if (this.$route.path == rota) return;
      this.$router.push({ path: rota });
    },
  },
};
</script>

<style>
</style>