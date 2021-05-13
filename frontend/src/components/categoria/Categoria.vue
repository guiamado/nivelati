<template>
  <div>
    <v-row>
      <v-col xl="6" offset-xl="3" md="6" offset-md="3" sm="6" offset-sm="3">
        <v-text-field
          label="Nome da Categoria"
          v-model="categoriaTxt"
          hide-details
        ></v-text-field>
      </v-col>
      <v-col xl="6" md="6" offset-xl="3" offset-md="3" sm="6" offset-sm="3">
        <v-btn
          color="success"
          :disabled="!categoriaTxt"
          @click="criarCategoria"
        >
          {{ isEdicaoCategoria ? "Alterar" : "Criar" }}
        </v-btn>
      </v-col>
      <v-col xl="6" md="6" offset-xl="3" offset-md="3" sm="6" offset-sm="3">
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
              <v-row>
                <v-col xl="8" md="8">
                  {{ categoria.categoria }}
                </v-col>
                <v-col xl="4" md="4" class="text-right pr-5">
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn
                        icon
                        v-bind="attrs"
                        v-on="on"
                        @click="editarCategoria(categoria)"
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
                          @click="excluirCategoria(categoria.idCategoria)"
                        >
                          <v-icon color="red">mdi-delete</v-icon>
                        </v-btn>
                      </template>
                      <span>Deletar</span>
                    </v-tooltip>
                  </span>
                </v-col>
                <v-col xl="12" md="12" sm="12" class="pa-0 px-3">
                  <v-divider v-if="i < categorias.length - 1"></v-divider>
                </v-col>
              </v-row>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <Loading :loading="loading" />
  </div>
</template>

<script>
import { requisicoes } from "../../service/requisicoes";
import Loading from "../utils/Loading";

export default {
  name: "Categoria",
  components: {
    Loading,
  },
  data() {
    return {
      loading: false,
      categoriaTxt: null,
      categorias: null,
      idCategoria: null,
      isEdicaoCategoria: false,
    };
  },
  created() {
    this.buscarCategorias();
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
    criarCategoria() {
      this.loading = true;
      if (!this.isEdicaoCategoria) {
        requisicoes
          .post(`/categoria`, { categoria: this.categoriaTxt })
          .then(() => {
            this.categoriaTxt = null;
            this.buscarCategorias();
          })
          .finally(() => (this.loading = false));
      } else {
        requisicoes
          .patch(`/categoria/${this.idCategoria}`, {
            categoria: this.categoriaTxt,
          })
          .then(() => {
            this.categoriaTxt = null;
            this.idCategoria = null;
            this.isEdicaoCategoria = false;
            this.buscarCategorias();
          })
          .finally(() => (this.loading = false));
      }
    },
    editarCategoria(categoria) {
      this.idCategoria = categoria.idCategoria;
      this.categoriaTxt = categoria.categoria;
      this.isEdicaoCategoria = true;
    },
    excluirCategoria(idCategoria) {
      this.loading = true;
      requisicoes
        .remove(`/categoria/${idCategoria}`)
        .then(() => {
          this.buscarCategorias();
        })
        .finally(() => (this.loading = false));
    },
  },
};
</script>

<style>
</style>