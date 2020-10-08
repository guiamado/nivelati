<template>
  <v-row align="center" justify="center">
    <v-col sm="12" lg="6" xl="6">
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
        ></v-text-field>
        <v-text-field
          v-model="senhaConfirmacao"
          :rules="senhaConfirmacaoRules"
          label="Confirmação da senha"
          required
          type="password"
        ></v-text-field>

        <v-btn
          :disabled="!valid"
          color="success"
          class="mr-4"
          @click="validate"
        >
          Cadastrar
        </v-btn>
        <v-btn color="info" :to="'/'"> Entrar </v-btn>
      </v-form>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      valid: true,
      senha: "",
      senhaRules: [(v) => !!v || "A senha é obrigatória"],
      senhaConfirmacao: "",
      senhaConfirmacaoRules: [
        (v) => !!v || "A confirmação da senha é obrigatória",
        (v) => v === this.senha || "Digite a senha igual",
      ],
      email: "",
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
      nome: "",
    };
  },
  methods: {
    validate() {
      this.$refs.form.validate();
    },
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },
  },
};
</script>

<style>
</style>