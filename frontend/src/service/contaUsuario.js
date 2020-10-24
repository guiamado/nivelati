import axios from 'axios';
const config = {
    headers: {
        "Content-Type": "application/json",
    },
};
function login(dadosLogin) {
    return axios.post(`${process.env.VUE_APP_API}/auth/login`, dadosLogin, config);
}

function signUp(dados) {
    return axios.post(`${process.env.VUE_APP_API}/auth/signup`, dados, config);
}

function logout() {
    const token = localStorage.getItem('token');
    // localStorage.removeItem('token');
    return axios.post(`${process.env.VUE_APP_API}/auth/logout`, { token: token }, config);
}

export const contaUsuario = {
    login,
    signUp,
    logout,
};