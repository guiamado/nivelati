<template>
  <div>
    <v-row>
      <v-col xl="9">
        <v-skeleton-loader
          v-if="loading"
          height="94"
          type="card-heading, list-item-three-line"
        >
        </v-skeleton-loader>
        <template v-else>
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
        </template>
      </v-col>
      <v-col col="3">
        <v-skeleton-loader
          v-if="loading"
          height="94"
          type="card-heading, list-item-three-line"
        >
        </v-skeleton-loader>
        <v-card v-else>
          <v-card-title>
            <v-card width="100%" color="cyan lighten-1" class="pa-2" dark>
              Categorias
            </v-card>
          </v-card-title>
          <v-card-text>
            <div
              v-for="(categoria, i) in categorias"
              :key="i"
              class="black--text text-subtitle-1"
            >
              {{ categoria.categoria }}
            </div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
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
      categorias: null,
    };
  },
  computed: {
    ...mapGetters({
      token: "logginStore/token",
    }),
  },
  created() {
    this.buscarPublicacoes().then(() => this.buscarCategorias());
  },
  methods: {
    buscarPublicacoes() {
      this.loading = true;
      return requisicoes
        .get(`/publicacao`)
        .then((res) => {
          this.publicacoes = res.data.data;
        })
        .finally(() => (this.loading = false));
    },
    buscarCategorias() {
      this.loading = true;
      requisicoes
        .get(`/categoria`)
        .then((res) => {
          this.categorias = res.data.data;
        })
        .finally(() => (this.loading = false));
    },
  },
};
</script>

<style>
</style>