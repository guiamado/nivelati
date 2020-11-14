import * as types from './types';

export const mutations = {
    [types.USUARIO_LOGIN](state, dadosLogin) {
        state.token = dadosLogin.access_token;
    },
    [types.USUARIO_LOGOUT](state, dadosLogout) {
        state.dadosLogout = dadosLogout;
        state.token = null;
        state.dadosUsuario = null;
    },
    [types.DADOS_USUARIO](state, dadosUsuario) {
        state.dadosUsuario = dadosUsuario;
    },
};