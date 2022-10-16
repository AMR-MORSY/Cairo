import Csrf from "./Csrf";
import Api from "./Api";

export default {
    submitEnergySheet(sheet) {
        // await Csrf.getCookie();

        return Api.post("/energysheet/index", sheet);
    },
    getEnergySheetIndex() {
        //  await Csrf.getCookie();
        return Api.get("/energysheet/index");
    },
};
