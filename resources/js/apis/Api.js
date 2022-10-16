import axios from "axios";
import router from "../router/index";
import store from "../vuex/store";

let Api = axios.create({
    baseURL: "/api",
});

Api.defaults.withCredentials = true;
Api.interceptors.response.use(
    function (response) {
        return response;
    },
    function (error) {
        if (
           
            error.response.status == 403 ||
            error.response.status == 419|| error.response.status == 401
        ) {
            sessionStorage.removeItem("Auth");
            sessionStorage.removeItem("userData");
            store.dispatch("changeLoginState", false);
            store.dispatch("userData",null);
            store.dispatch('userPermissions',null)
            store.dispatch('userRoles',null)
            router.push({ path: "/user/login" });
        }

        return Promise.reject(error);
    }
);

export default Api;
