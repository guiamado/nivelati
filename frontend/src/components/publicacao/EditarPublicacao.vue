<template>
  <v-dialog v-model="dialog" persistent max-width="900">
    <v-card>
      <v-card-title class="headline grey lighten-2">
        <span class="text-h5 black--text">Editar Publicação</span>
      </v-card-title>
      <v-card-text class="pa-4">
        <v-text-field
          v-model="form.titulo"
          label="Título"
          required
        ></v-text-field>
        <EditorRico
          @onEditorChange="onEditorChange"
          :contentProp="publicacao.descricaoPublicacao"
        />
      </v-card-text>
      <v-card-actions class="pa-4">
        <v-btn
          :disabled="!form.titulo || !form.descricaoPublicacao"
          color="success"
          @click="validate"
        >
          Editar
        </v-btn>
        <v-btn
          :disabled="!form.titulo || !form.descricaoPublicacao"
          color="error"
          @click="closeModal"
        >
          Cancelar
        </v-btn>
      </v-card-actions>
    </v-card>
    <Loading :loading="loading" />
  </v-dialog>
</template>

<script>
import { requisicoes } from "../../service/requisicoes";
import Loading from "../utils/Loading";
import EditorRico from "../utils/EditorRico";

export default {
  name: "EditarPublicacao",
  props: {
    publicacao: {
      type: Object,
      required: true,
    },
    dialogEditarPublicacao: {
      type: Boolean,
      required: true,
    },
  },
  components: {
    Loading,
    EditorRico,
  },
  data() {
    return {
      form: {
        titulo: this.publicacao.titulo,
        descricaoPublicacao: this.publicacao.descricaoPublicacao,
      },
      loading: false,
      dialog: this.dialogEditarPublicacao,
    };
  },
  watch: {
    dialogEditarPublicacao(value) {
      this.dialog = value;
    },
  },
  methods: {
    validate() {
      const isFormValido = this.form.titulo && this.form.descricaoPublicacao;
      if (isFormValido) {
        this.editarPublicacao(this.form);
      }
    },
    onEditorChange(value) {
      this.form.descricaoPublicacao = value;
    },
    editarPublicacao(publicacao) {
      this.loading = true;
      requisicoes
        .patch(`/publicacao/${this.publicacao.idPublicacao}`, publicacao)
        .then((res) => {
          if (res.data) {
            this.$emit("onEditarPublicacao");
            this.closeModal();
          }
        })
        .finally(() => (this.loading = false));
    },
    closeModal() {
      this.dialog = !this.dialog;
      this.$emit("update:dialogEditarPublicacao", this.dialog);
    },
  },
};
</script>

<style>
</style>