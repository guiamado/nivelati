<template>
  <v-row align="center" justify="center">
    <v-col sm="12" xl="6">
      <v-card v-if="loading">
        <v-skeleton-loader type="card-heading, list-item-three-line">
        </v-skeleton-loader>
      </v-card>
      <template v-else>
        <v-card v-for="(comentario, i) in comentarios" :key="i" class="mb-4">
          <v-card-text>
            <div class="text-h5 black--text">
              <v-row align="center">
                <v-col xl="9" class="py-0">{{ comentario.usuario }}</v-col>
                <v-col xl="3" class="text-right py-0">
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn icon v-bind="attrs" v-on="on">
                        <v-icon
                          :color="comentario.avaliado ? 'red' : 'red lighten-4'"
                          >mdi-heart</v-icon
                        >
                      </v-btn>
                    </template>
                    <span>{{
                      comentario.avaliado ? "Retirar avaliação" : "Avaliar"
                    }}</span>
                  </v-tooltip>
                  <span class="text-body-2"
                    >{{ comentario.avaliacoes }} avaliações</span
                  >
                </v-col>
              </v-row>
            </div>
            <v-divider class="my-2"></v-divider>
            {{ comentario.descricaoComentario }}
          </v-card-text>
        </v-card>
      </template>
    </v-col>
  </v-row>
</template>

<script>
import { requisicoes } from "../../service/requisicoes";

export default {
  name: "Comentarios",
  data() {
    return {
      loading: false,
      comentarios: null,
    };
  },
  created() {
    this.buscarComentarios();
  },
  methods: {
    buscarComentarios() {
      this.loading = true;
      return requisicoes
        .get(`/publicacao/${this.$route.params.id}/comentario`, true)
        .then((res) => {
          this.comentarios = res.data.data;
        })
        .finally(() => (this.loading = false));
    },
  },
};
</script>

<style>
</style>