import Api from "./Api";
import Csrf from "./Csrf";
export default {
    async register(form) {
        // await Csrf.getCookie();
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
    resetPassword(form) {
        return Api.post("/user/resetPassword", form);
    },
    validateToken(form) {
        return Api.post("/user/validateToken", form);
    },
    sendToken(form) {
        return Api.post("/user/sendToken", form);
    },
};
