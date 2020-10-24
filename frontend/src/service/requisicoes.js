import axios from 'axios';

function pegarTokenCabecalho() {
    const token = localStorage.getItem('token');
    if (token) {
        return {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        };
    }
}

function get(urlString) {
    return axios.get(`${process.env.VUE_APP_API}${urlString}`);
}

function post(urlString, data) {
    return axios.post(`${process.env.VUE_APP_API}${urlString}`, data, pegarTokenCabecalho());
}

function patch(urlString, data) {
    return axios.patch(`${process.env.VUE_APP_API}${urlString}`, data, pegarTokenCabecalho());
}

function remove(urlString, data) {
    return axios.delete(`${process.env.VUE_APP_API}${urlString}`, data, pegarTokenCabecalho());
}

export const requisicoes = {
    get,
    post,
    patch,
    remove,
};