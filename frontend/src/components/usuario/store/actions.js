import * as types from './types';
import { contaUsuario } from '../../../service/contaUsuario';
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