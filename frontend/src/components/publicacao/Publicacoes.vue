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
              <v-row class="mb-3">
                <v-col xl="12" class="py-2 black--text">
                  <b>Selecione uma categoria para filtrar:</b>
                </v-col>
                <v-col xl="6" class="py-0">
                  <v-select
                    v-model="select"
                    :items="filtroTrending"
                    item-text="categoria"
                    item-value="idCategoria"
                    label="Categoria"
                    persistent-hint
                    single-line
                    class="pt-0"
                    hide-details
                  ></v-select>
                </v-col>
                <v-col col="6">
                  <v-btn
                    small
                    color="success"
                    @click="filtrarTrend"
                  >
                    Filtrar
                  </v-btn>
                </v-col>
              </v-row>
              <a
                v-for="(trend, i) in trendingTopics"
                :key="i"
                class="black--text text-subtitle-1 contentWrap"
                @click="abrirPublicacao(trend.idPublicacao)"
              >
                {{ i + 1 }} - {{ trend.titulo }} <br/>
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
      select: 0,
      filtroTrending: [{categoria: 'Selecione', idCategoria: 0}]
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
      this.criarFiltrosTrending(this.categorias);
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
    criarFiltrosTrending(categorias) {
      if(categorias && categorias.length > 0) {
        categorias.forEach(element => {
          this.filtroTrending.push(element);
        });
      }
    },
    filtrarTrend() {
      this.loading = true;
      if(this.select === 0) {
        return this.buscarTrendingTopics().then((response) => {
          this.trendingTopics = response.data;
        })
        .finally(() => (this.loading = false));
      }
      return requisicoes
        .get(`/trendingTopics/getByCategoria/${this.select}`).then((response) => {
          this.trendingTopics = response.data;
        })
        .finally(() => (this.loading = false));
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