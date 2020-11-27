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
                      <v-btn
                        icon
                        v-bind="attrs"
                        v-on="on"
                        @click="
                          realizarAvaliacao(
                            comentario.avaliado,
                            comentario.idComentario
                          )
                        "
                      >
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
            <span
              v-html="comentario.descricaoComentario"
              v-if="edicao !== comentario.idComentario"
            ></span>
            <EditarComentario
              v-else
              :idPublicacao="$route.params.id"
              @onComentarioEditado="onComentarioEditado"
              :idComentario="comentario.idComentario"
              :descricaoComentarioProp="comentario.descricaoComentario"
            />
          </v-card-text>
          <v-card-actions v-if="isAutor(comentario.idUsuario)">
            <v-tooltip bottom>
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  icon
                  v-bind="attrs"
                  v-on="on"
                  @click="edicao = comentario.idComentario"
                >
                  <v-icon color="orange lighten-1">mdi-pencil</v-icon>
                </v-btn>
              </template>
              <span>Editar</span>
            </v-tooltip>
            <span class="pl-5">
              <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    icon
                    v-bind="attrs"
                    v-on="on"
                    @click="excluirComentario(comentario.idComentario)"
                  >
                    <v-icon color="red">mdi-delete</v-icon>
                  </v-btn>
                </template>
                <span>Deletar</span>
              </v-tooltip>
            </span>
          </v-card-actions>
        </v-card>
        <CriarComentario
          :idPublicacao="$route.params.id"
          @onComentarioCadastrado="onComentarioCadastrado"
        />
      </template>
    </v-col>
  </v-row>
</template>

<script>
import { mapGetters } from "vuex";
import { requisicoes } from "../../service/requisicoes";
import CriarComentario from "./CriarComentario";
import EditarComentario from "./EditarComentario";
export default {
  name: "Comentarios",
  components: {
    CriarComentario,
    EditarComentario,
  },
  data() {
    return {
      loading: false,
      comentarios: null,
      edicao: false,
    };
  },
  created() {
    this.buscarComentarios();
  },
  computed: {
    ...mapGetters({
      dadosUsuario: "logginStore/dadosUsuario",
    }),
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
    onComentarioCadastrado() {
      this.buscarComentarios();
    },
    isAutor(idUsuario) {
      return this.dadosUsuario.idUsuario === idUsuario;
    },
    onComentarioEditado() {
      this.edicao = null;
      this.buscarComentarios();
    },
    excluirComentario(idComentario) {
      this.loading = true;
      requisicoes
        .remove(
          `/publicacao/${this.$route.params.id}/comentario/${idComentario}`
        )
        .then(() => {
          this.buscarComentarios();
        })
        .finally(() => (this.loading = false));
    },
    realizarAvaliacao(isAvaliado, idComentario) {
      this.loading = true;
      const objReq = {
        idUsuario: this.dadosUsuario.idUsuario,
      };
      if (!isAvaliado) {
        requisicoes
          .post(`/avaliacaoComentario/${idComentario}`, objReq)
          .then(() => {
            this.buscarComentarios();
          })
          .finally(() => (this.loading = false));
      } else {
        requisicoes
          .post(`/deletarAvaliacaoComentario/${idComentario}`, objReq)
          .then(() => {
            this.buscarComentarios();
          })
          .finally(() => (this.loading = false));
      }
    },
  },
};
</script>

<style>
</style>