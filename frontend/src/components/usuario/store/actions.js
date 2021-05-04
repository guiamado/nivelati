import * as types from './types';
import { contaUsuario } from '../../../service/contaUsuario';
import { requisicoes } from '../../../service/requisicoes';
export const loginAction = ({ commit }, params) => {
    return contaUsuario.login(params)
        .then((response) => {
            const { data } = response;
            localStorage.setItem("token", data.access_token);
            commit(types.USUARIO_LOGIN, data);
            return response;
        });
};

export const logoutAction = ({ commit }) => {
    return contaUsuario.logout()
        .then((response) => {
            const { data } = response;
            localStorage.removeItem("token");
            commit(types.USUARIO_LOGOUT, data);
            return response;
        })
        .catch((error) => {
            localStorage.removeItem("token");
            commit(types.USUARIO_LOGOUT, error);
            return error;
        });
};

export const signUpAction = ({ commit }, params) => {
    return contaUsuario.signUp(params)
        .then((response) => {
            const { data } = response;
            localStorage.setItem("token", data.access_token);
            commit(types.USUARIO_LOGIN, data);
            return response;
        });
};

export const dadosUsuarioAction = ({ commit }) => {
    return requisicoes.post('/auth/me')
        .then((response) => {
            const { data } = response;
            commit(types.DADOS_USUARIO, data);
            return response;
        });
};

export const hasUserIntegration = ({ commit }, params) => {
    return contaUsuario.hasUserIntegration(params)
        .then((response) => {
            const { data } = response;
            if(!data.hasError) {
                localStorage.setItem("token", data.access_token);
                commit(types.USUARIO_LOGIN, data);
            }
            return response;
        });
};