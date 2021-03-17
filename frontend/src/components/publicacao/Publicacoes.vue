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
              <v-btn
                color="success"
                @click="abrirPublicacao(publicacao.idPublicacao)"
              >
                Ver detalhes da Publicação
              </v-btn>
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
        <template v-else>
          <v-card class="mb-4">
            <v-card-title>
              <v-card width="100%" color="green lighten-1" class="pa-2" dark>
                Trending Topics
              </v-card>
            </v-card-title>
            <v-card-text>
              <div class="grey--text text-subtitle-1 text-center">Aqui você encontra as publicações mais populares entre os usuários.</div>
              <a
                v-for="(trend, i) in trendingTopics"
                :key="i"
                class="black--text text-subtitle-1 contentWrap"
                @click="abrirPublicacao(trend.idPublicacao)"
              >
                {{ i + 1 }} - {{ trend.descricaoComentario }} <br/>
              </a>
            </v-card-text>
          </v-card>
          <v-card>
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
        </template>
      </v-col>
    </v-row>
    <Loading :loading="loading" />
  </div>
</template>

<script>
import axios from 'axios';
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
      trendingTopics: null,
    };
  },
  computed: {
    ...mapGetters({
      token: "logginStore/token",
    }),
  },
  created() {
    // this.buscarPublicacoes().then(() => this.buscarCategorias());
    const requests = [
      this.buscarPublicacoes(),
      this.buscarCategorias(),
      this.buscarTrendingTopics(),
    ];
    this.loading = true;
    axios.all(requests).then(axios.spread((...responses) => {
      this.publicacoes = responses[0].data.data;
      this.categorias = responses[1].data.data;
      this.trendingTopics = responses[2].data;
    })).finally(() => (this.loading = false));
  },
  methods: {
    buscarPublicacoes() {
      this.loading = true;
      return requisicoes
        .get(`/publicacao`);
    },
    buscarCategorias() {
      this.loading = true;
      return requisicoes
        .get(`/categoria`);
    },
    buscarTrendingTopics() {
      this.loading = true;
      return requisicoes
        .get(`/trendingTopics`);
    },
    abrirPublicacao(idPublicacao) {
      if(!this.token) return;
      this.$router.push({ path: `/publicacao/${idPublicacao}` });
    },
  },
};
</script>

<style>
.contentWrap {
  overflow: hidden;
  width: 100%;
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
}
</style>