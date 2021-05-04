<template>
  <v-dialog v-model="dialog" persistent max-width="600">
    <v-card>
      <v-card-title class="headline grey lighten-2">
        <span class="text-h5 black--text">Complete seu cadastro</span>
      </v-card-title>
      <v-card-text class="pa-4">
          <div class="text-body-1 black--text text-center">
              Precisamos de mais alguns dados para você ter acesso em nossa plataforma.
          </div>
          <Cadastro :dadosIntegracao="dadosIntegracao" @onCloseIntegracao="onCloseIntegracao"/>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script>
import Cadastro from './Cadastro';

export default {
  name: "IntegracaoCadastro",
  props: {
    dialogIntegracaoCadastro: {
      type: Boolean,
      required: true,
    },
    dadosIntegracao: {
      type: Object,
      required: false,
      default: null,
    }
  },
  components: {
    Cadastro,
  },
  data() {
    return {
      dialog: this.dialogIntegracaoCadastro,
    };
  },
  watch: {
    dialogIntegracaoCadastro(value) {
      this.dialog = value;
    },
  },
  methods: {
    closeModal() {
      this.dialog = !this.dialog;
      this.$emit("update:dialogIntegracaoCadastro", this.dialog);
    },
    onCloseIntegracao(value) {
      if(value) {
        // excluir usuario
      }
      this.closeModal();
    }
  },
};
</script>

<style>
</style>