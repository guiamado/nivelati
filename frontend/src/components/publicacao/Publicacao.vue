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
        <div
          class="text-body-2 black--text pt-5"
          v-html="publicacao.descricaoPublicacao"
        ></div>
      </v-card-text>
      <v-card-actions v-if="publicacao && isAutor">
        <v-tooltip bottom>
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              icon
              v-bind="attrs"
              v-on="on"
              @click="dialogEditarPublicacao = true"
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
                @click="excluirPublicacao(publicacao.idPublicacao)"
              >
                <v-icon color="red">mdi-delete</v-icon>
              </v-btn>
            </template>
            <span>Deletar</span>
          </v-tooltip>
        </span>
      </v-card-actions>
    </v-card>
    <Comentarios />
    <Loading :loading="loading" />
    <EditarPublicacao
      v-if="publicacao"
      :publicacao="publicacao"
      :dialogEditarPublicacao.sync="dialogEditarPublicacao"
      @onEditarPublicacao="onEditarPublicacao"
    />
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { requisicoes } from "../../service/requisicoes";
import Loading from "../utils/Loading";
import Comentarios from "../comentario/Comentarios";
import EditarPublicacao from "./EditarPublicacao";

export default {
  name: "Publicacao",
  components: {
    Loading,
    Comentarios,
    EditarPublicacao,
  },
  data() {
    return {
      loading: false,
      publicacao: null,
      dialogEditarPublicacao: false,
    };
  },
  created() {
    this.buscarPublicacao();
  },
  computed: {
    ...mapGetters({
      dadosUsuario: "logginStore/dadosUsuario",
    }),
    isAutor() {
      if (!this.publicacao) return null;
      return this.dadosUsuario.idUsuario === this.publicacao.idUsuario;
    },
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
    excluirPublicacao(idPublicacao) {
      this.loading = true;
      requisicoes
        .remove(`/publicacao/${idPublicacao}`)
        .then(() => {
          this.$router.push({ path: `/` });
        })
        .finally(() => (this.loading = false));
    },
    onEditarPublicacao() {
      this.buscarPublicacao();
    },
  },
};
</script>

<style>
</style>