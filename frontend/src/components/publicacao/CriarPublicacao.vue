<template>
  <div>
    <v-card>
      <v-card-text>
        <span class="text-h5 black--text">Criar Publicação</span>
        <v-divider class="ma-0"></v-divider>
        <v-text-field
          v-model="form.titulo"
          label="Título"
          required
        ></v-text-field>
        <v-select
          v-model="form.idCategoria"
          :items="categorias"
          label="Categoria"
          item-text="categoria"
          item-value="idCategoria"
        ></v-select>
        <EditorRico @onEditorChange="onEditorChange" />
      </v-card-text>
      <v-card-actions>
        <v-btn
          :disabled="
            !form.titulo || !form.idCategoria || !form.descricaoPublicacao
          "
          color="success"
          @click="validate"
        >
          Criar
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
  name: "CriarPublicacao",
  components: {
    Loading,
    EditorRico,
  },
  data() {
    return {
      form: {
        titulo: null,
        idCategoria: null,
        descricaoPublicacao: null,
        slug: null,
        idUsuario: null,
      },
      categorias: null,
      loading: false,
    };
  },
  created() {
    this.buscarCategorias();
  },
  computed: {
    ...mapGetters({
      dadosUsuario: "logginStore/dadosUsuario",
    }),
  },
  methods: {
    buscarCategorias() {
      this.loading = true;
      requisicoes
        .get(`/categoria`)
        .then((res) => {
          this.categorias = res.data.data;
        })
        .finally(() => (this.loading = false));
    },
    validate() {
      const isFormValido =
        this.form.titulo &&
        this.form.idCategoria &&
        this.form.descricaoPublicacao;
      if (isFormValido) {
        this.form.idUsuario = this.dadosUsuario.idUsuario;
        this.form.slug = this.form.titulo;
        this.cadastrarPublicacao(this.form);
      }
    },
    onEditorChange(value) {
      this.form.descricaoPublicacao = value;
    },
    cadastrarPublicacao(publicacao) {
      this.loading = true;
      requisicoes
        .post(`/publicacao`, publicacao)
        .then((res) => {
          if (res.data) {
            this.$router.push({ path: `/` });
          }
        })
        .finally(() => (this.loading = false));
    },
  },
};
</script>

<style>
</style>