<template>
  <div>
    <v-card v-for="(publicacao, i) in publicacoes" :key="i">
      <v-card-text class="mb-4">
        <div class="text-h5 black--text">
          {{ publicacao.titulo }}
        </div>
        <v-divider class="my-2"></v-divider>
        <div>Publicado em {{ publicacao.created_at }}</div>
        <div>Criado por {{ publicacao.usuario }}</div>
        <div>Discussões na publicação {{ publicacao.comentarios }}</div>
      </v-card-text>
    </v-card>
    <Loading :loading="loading" />
  </div>
</template>

<script>
import axios from "axios";
import Loading from "../utils/Loading";

export default {
  name: "Publicacoes",
  components: {
    Loading,
  },
  data() {
    return {
      loading: false,
      publicacoes: null,
    };
  },
  created() {
    this.buscarPublicacoes();
  },
  methods: {
    buscarPublicacoes() {
      this.loading = true;
      setTimeout(() => {
        axios
          .get("http://127.0.0.1:8000/api/publicacao")
          .then((res) => {
            console.log("RESPONSE", res.data.data);
            this.publicacoes = res.data.data;
          })
          .finally(() => (this.loading = false));
      }, 3000);
    },
  },
};
</script>

<style>
</style>