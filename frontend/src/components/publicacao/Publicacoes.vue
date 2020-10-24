<template>
  <div>
    <v-card v-for="(publicacao, i) in publicacoes" :key="i" class="mb-4">
      <v-card-text>
        <div class="text-h5 black--text">
          {{ publicacao.titulo }}
        </div>
        <v-divider class="my-2"></v-divider>
        <div>Publicado em {{ publicacao.created_at }}</div>
        <div>Criado por {{ publicacao.usuario }}</div>
        <div>Categoria: {{ publicacao.categoria }}</div>
        <div>Discussões na publicação {{ publicacao.comentarios }}</div>
      </v-card-text>
      <v-card-actions v-if="token">
        <v-spacer></v-spacer>
        <v-btn color="success"> Ver detalhes da Publicação </v-btn>
      </v-card-actions>
    </v-card>
    <Loading :loading="loading" />
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { requisicoes } from "../../service/requisicoes";
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
  computed: {
    ...mapGetters({
      token: "logginStore/token",
    }),
  },
  created() {
    this.buscarPublicacoes();
  },
  methods: {
    buscarPublicacoes() {
      this.loading = true;
      requisicoes
        .get(`/publicacao`)
        .then((res) => {
          console.log("RESPONSE", res.data.data);
          this.publicacoes = res.data.data;
        })
        .finally(() => (this.loading = false));
    },
  },
};
</script>

<style>
</style>