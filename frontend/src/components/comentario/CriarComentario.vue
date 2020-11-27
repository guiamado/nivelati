<template>
  <div>
    <v-card>
      <v-card-text>
        <span class="text-h5 black--text">Adicionar Comentário</span>
        <v-divider class="ma-0"></v-divider>
        <EditorRico @onEditorChange="onEditorChange" />
      </v-card-text>
      <v-card-actions>
        <v-btn
          :disabled="!descricaoComentario"
          color="success"
          @click="cadastrarComentario"
        >
          Comentar
        </v-btn>
      </v-card-actions>
    </v-card>
    <Loading :loading="loading" />
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { requisicoes } from "../../service/requisicoes";
import Loading from "../utils/Loading";
import EditorRico from "../utils/EditorRico";

export default {
  name: "CriarComentario",
  props: {
    idPublicacao: {
      type: String,
      required: true,
    },
  },
  components: {
    Loading,
    EditorRico,
  },
  data() {
    return {
      descricaoComentario: null,
      loading: false,
    };
  },
  computed: {
    ...mapGetters({
      dadosUsuario: "logginStore/dadosUsuario",
    }),
  },
  methods: {
    onEditorChange(value) {
      this.descricaoComentario = value;
    },
    cadastrarComentario() {
      this.loading = true;
      const objReq = {
        descricaoComentario: this.descricaoComentario,
        idUsuario: this.dadosUsuario.idUsuario,
        idPublicacao: this.idPublicacao,
      };
      requisicoes
        .post(`/publicacao/${this.idPublicacao}/comentario`, objReq)
        .then((res) => {
          if (res.data) {
            this.$emit("onComentarioCadastrado");
          }
        })
        .finally(() => (this.loading = false));
    },
  },
};
</script>

<style>
</style>