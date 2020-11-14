<template>
  <div>
    <v-card>
      <v-skeleton-loader
        v-if="loading"
        type="card-heading, list-item-three-line"
      >
      </v-skeleton-loader>
      <v-card-text v-if="publicacao">
        <div class="text-h5 black--text">
          <v-row align="center">
            <v-col xl="9" class="py-0">{{ publicacao.titulo }}</v-col>
            <v-col xl="3" class="text-right py-0">
              <v-btn color="success">
                {{ publicacao.comentarios }} Comentários
              </v-btn>
            </v-col>
          </v-row>
        </div>
        <div>
          {{ publicacao.usuario }} publicou em {{ publicacao.created_at }}
        </div>
        <div>Categoria: {{ publicacao.categoria }}</div>
        <v-divider class="my-2"></v-divider>
        <div class="text-body-2 black--text pt-5">
          {{ publicacao.descricaoPublicacao }}
        </div>
      </v-card-text>
    </v-card>
    <Comentarios />
    <Loading :loading="loading" />
  </div>
</template>

<script>
import { requisicoes } from "../../service/requisicoes";
import Loading from "../utils/Loading";
import Comentarios from "../comentario/Comentarios";

export default {
  name: "Publicacao",
  components: {
    Loading,
    Comentarios,
  },
  data() {
    return {
      loading: false,
      publicacao: null,
    };
  },
  created() {
    this.buscarPublicacao();
  },
  methods: {
    buscarPublicacao() {
      this.loading = true;
      return requisicoes
        .get(`/publicacao/${this.$route.params.id}`)
        .then((res) => {
          this.publicacao = res.data.data;
        })
        .finally(() => (this.loading = false));
    },
  },
};
</script>

<style>
</style>