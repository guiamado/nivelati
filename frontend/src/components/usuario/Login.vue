<template>
  <v-row align="center" justify="center">
    <v-col sm="12" lg="6" xl="6">
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
      </v-form>
    </v-col>
    <Loading :loading="loading" />
  </v-row>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Loading from "../utils/Loading";

export default {
  name: "Login",
  components: {
    Loading,
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
            this.$router.push({ path: "/" });
          }
        })
        .finally(() => (this.loading = false));
    },
  },
};
</script>

<style>
</style>