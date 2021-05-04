<template>
  <v-row align="center" justify="center">
    <v-col sm="12" lg="6" xl="6">
      <div class="text-h3 text-center">
        Bem vindo ao Nivela TI!
      </div>
      <v-form ref="form" v-model="valid">
        <v-text-field
          v-model="email"
          :rules="emailRules"
          label="E-mail"
          required
        ></v-text-field>

        <v-text-field
          v-model="senha"
          :rules="senhaRules"
          label="Senha"
          required
          type="password"
        ></v-text-field>

        <v-btn
          :disabled="!valid"
          color="success"
          class="mr-4"
          @click="validate"
        >
          Entrar
        </v-btn>
        <v-btn color="info" :to="'/cadastro'"> Cadastrar </v-btn>
        <div>
          <v-btn color="grey" @click="signWithMicrosoft" class="mt-4">
            <object
              type="image/svg+xml"
              data="https://s3-eu-west-1.amazonaws.com/cdn-testing.web.bas.ac.uk/scratch/bas-style-kit/ms-pictogram/ms-pictogram.svg"
              class="x-icon mr-3 mb-1"
            ></object> 
            Sign in with Microsoft
          </v-btn>
        </div>
      </v-form>
    </v-col>
    <Loading :loading="loading" />
    <IntegracaoCadastro :dialogIntegracaoCadastro.sync="dialogIntegracaoCadastro" :dadosIntegracao="dadosIntegracao"/>
  </v-row>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Loading from "../utils/Loading";
import { authFirebase, providerMicrosoft } from '../../firebaseConfig';
import IntegracaoCadastro from './IntegracaoCadastro';

export default {
  name: "Login",
  components: {
    Loading,
    IntegracaoCadastro,
  },
  data() {
    return {
      valid: true,
      senha: "",
      senhaRules: [(v) => !!v || "A senha é obrigatória"],
      email: "",
      emailRules: [
        (v) => !!v || "E-mail é obrigatório",
        (v) => /.+@.+\..+/.test(v) || "Digite um e-mail válido",
      ],
      loading: false,
      dialogIntegracaoCadastro: false,
      dadosIntegracao: {},
    };
  },
  computed: {
    ...mapGetters({
      token: "logginStore/token",
    }),
  },
  methods: {
    ...mapActions({
      loginAction: "logginStore/loginAction",
      dadosUsuarioAction: "logginStore/dadosUsuarioAction",
      hasUserIntegration: "logginStore/hasUserIntegration",
    }),
    validate() {
      const isFormValido = this.$refs.form.validate();
      if (isFormValido) {
        this.realizarRequisicao();
      }
    },
    realizarRequisicao() {
      this.loading = true;
      const objReq = {
        email: this.email,
        password: this.senha,
      };

      this.loginAction(objReq)
        .then((res) => {
          if (res.data && res.data.access_token) {
            // this.$router.push({ path: "/" });
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
            this.$router.push({ path: "/" });
          }
        })
        .finally(() => (this.loading = false));
    },
    signWithMicrosoft() {
      this.loading = true;
      // var provider = new authFirebase.OAuthProvider('microsoft.com');
      authFirebase.signInWithPopup(providerMicrosoft)
      .then((result) => {
        // IdP data available in result.additionalUserInfo.profile.
        // var credential = result.credential;
        var user = result.user;

        // console.log('user.email', user.email);
        // console.log('user.displayName', user.displayName);
        // console.log('credential', credential);
        console.log('result', result);
        // this.dadosIntegracao.email = user.email;
        // this.dadosIntegracao.nome = user.displayName;
        // this.dialogIntegracaoCadastro = true;
        this.checkHasUserIntegration(user.email, user.displayName, user.uid)
      })
      .catch((error) => {
        // Handle error.
        console.log('error micro', error);
      });
    },
    checkHasUserIntegration(email, displayName, uid) {
      this.hasUserIntegration({ email, uid })
      .then((res) => {
          if (res.data.hasError) {
            this.dadosIntegracao.email = email;
            this.dadosIntegracao.nome = displayName;
            this.dadosIntegracao.senha = uid;
            this.dialogIntegracaoCadastro = true;
          } else {
            this.buscarDadosUsuario();
          }
        })
        .finally(() => (this.loading = false));
    }
  },
};
</script>

<style>
.bsk-container {
  margin-top: 15px;
}

.x-icon {
  height: 1em;
  width: 1em;
  top: .125em;
  position: relative;
}
.x-alt {
  color: #777;
}
</style>