import Api from "./Api";
import Csrf from "./Csrf";
export default {
    async register(form) {
        await Csrf.getCookie();
        Api.post("/user/register", form).catch((error) => {
            if (error.response) {
                console.log(error.response);
            }
        });
    },
   async login(form) {
        await Csrf.getCookie();
        return Api.post("/user/login", form);
    },
    async logout() {
        await Csrf.getCookie();
        return Api.post("/user/logout");
    },
    async resetPassword(form) {
        await Csrf.getCookie();
        return Api.post("/user/resetPassword", form);
    },
    async validateToken(form) {
        await Csrf.getCookie();
        return Api.post("/user/validateToken", form);
    },
    async sendToken(form) {
        await Csrf.getCookie();
        return Api.post("/user/sendToken", form);
    },
    refreshSession(){

        return Api.get("/user/refreshsession");

    }
};
