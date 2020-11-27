<template>
  <div>
    <v-card>
      <v-card-text>
        <span class="text-h5 black--text">Editar Comentário</span>
        <v-divider class="ma-0"></v-divider>
        <EditorRico
          @onEditorChange="onEditorChange"
          :contentProp="descricaoComentarioProp"
        />
      </v-card-text>
      <v-card-actions>
        <v-btn
          :disabled="!descricaoComentario"
          color="success"
          @click="editarComentario"
        >
          Editar
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
  name: "EditarComentario",
  props: {
    idPublicacao: {
      type: String,
      required: true,
    },
    descricaoComentarioProp: {
      type: String,
      required: true,
    },
    idComentario: {
      type: Number,
      required: true,
    },
  },
  components: {
    Loading,
    EditorRico,
  },
  data() {
    return {
      descricaoComentario: this.descricaoComentarioProp,
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
    editarComentario() {
      this.loading = true;
      const objReq = {
        descricaoComentario: this.descricaoComentario,
        idUsuario: this.dadosUsuario.idUsuario,
        idPublicacao: this.idPublicacao,
      };
      requisicoes
        .patch(
          `/publicacao/${this.idPublicacao}/comentario/${this.idComentario}`,
          objReq
        )
        .then((res) => {
          if (res.data) {
            this.$emit("onComentarioEditado");
          }
        })
        .finally(() => (this.loading = false));
    },
  },
};
</script>

<style>
</style>