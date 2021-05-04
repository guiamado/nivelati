<template>
  <v-row align="center" justify="center">
    <v-col sm="12" :lg="dadosIntegracao ? 12 : 6" :xl="dadosIntegracao ? 12 : 6">
      <div class="text-h3 text-center" v-if="!dadosIntegracao">
        Bem vindo ao Nivela TI!
      </div>
      <v-form ref="form" v-model="valid">
        <v-text-field
          v-model="nome"
          :rules="campoObrigatorio"
          label="Nome"
          required
        ></v-text-field>
        <v-text-field
          v-model="email"
          :rules="emailRules"
          label="E-mail"
          required
        ></v-text-field>
        <v-text-field
          v-model="cpf"
          :rules="cpfObrigatorio"
          label="CPF"
          required
          v-mask="'###.###.###-##'"
        ></v-text-field>
        <v-text-field
          v-model="senha"
          :rules="senhaRules"
          label="Senha"
          required
          type="password"
          v-if="!isIntegracao"
        ></v-text-field>
        <v-text-field
          v-model="senhaConfirmacao"
          :rules="senhaConfirmacaoRules"
          label="Confirmação da senha"
          required
          type="password"
          v-if="!isIntegracao"
        ></v-text-field>

        <v-btn
          :disabled="!valid"
          color="success"
          class="mr-4"
          @click="validate"
        >
          Cadastrar
        </v-btn>
        <v-btn color="info" :to="'/login'" v-if="!isIntegracao"> Entrar </v-btn>
        <v-btn
          color="error"
          @click="cancelIntegracao"
          v-if="isIntegracao"
        >
          Cancelar
        </v-btn>
      </v-form>
    </v-col>
    <Loading :loading="loading" />
  </v-row>
</template>

<script>
import { mapActions } from "vuex";
import Loading from "../utils/Loading";
export default {
  name: "Login",
  props: {
    dadosIntegracao: {
      type: Object,
      required: false,
      default: null,
    }
  },
  components: {
    Loading,
  },
  data() {
    return {
      valid: true,
      senha: this.dadosIntegracao ? this.dadosIntegracao.senha : "",
      senhaRules: [(v) => !!v || "A senha é obrigatória"],
      senhaConfirmacao: "",
      senhaConfirmacaoRules: [
        (v) => !!v || "A confirmação da senha é obrigatória",
        (v) => v === this.senha || "Digite a senha igual",
      ],
      email: this.dadosIntegracao ? this.dadosIntegracao.email : "",
      emailRules: [
        (v) => !!v || "E-mail é obrigatório",
        (v) => /.+@.+\..+/.test(v) || "Digite um e-mail válido",
      ],
      campoObrigatorio: [(v) => !!v || "Campo obrigatório"],
      cpfObrigatorio: [
        (v) => !!v || "CPF é obrigatório",
        (v) => v.length === 14 || "Digite os 11 números do CPF.",
      ],
      cpf: "",
      nome: this.dadosIntegracao ? this.dadosIntegracao.nome : "",
      loading: false,
    };
  },
  computed: {
    isIntegracao() {
      if(this.dadosIntegracao && Object.keys(this.dadosIntegracao).length > 0) {
        return true;
      }
      return false;
    }
  },
  methods: {
    ...mapActions({
      signUpAction: "logginStore/signUpAction",
      dadosUsuarioAction: "logginStore/dadosUsuarioAction",
    }),
    validate() {
      const isFormValido = this.$refs.form.validate();
      if (isFormValido) {
        this.cadastrarUsuario();
      }
    },
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },
    cadastrarUsuario() {
      this.loading = true;
      const objReq = {
        name: this.nome,
        email: this.email,
        password: this.senha,
        cpf: this.cpf,
      };
      this.signUpAction(objReq)
        .then((res) => {
          if (res.data && res.data.access_token) {
            this.buscarDadosUsuario();
          }
        })
        .finally(() => (this.loading = false));
    },
    buscarDadosUsuario() {
      this.loading = true;
      this.dadosUsuarioAction()
        .then((res) => {
          if (res.data) {
            if(this.isIntegracao) {
              this.$emit('onCloseIntegracao', false);
            }
            this.$router.push({ path: "/" });
          }
        })
        .finally(() => (this.loading = false));
    },
    cancelIntegracao() {
      this.$emit('onCloseIntegracao', true);
    }
  },
};
</script>

<style>
</style>