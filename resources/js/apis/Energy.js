import Csrf from "./Csrf";
import Api from "./Api";

export default {
    submitEnergySheet(sheet) {
     

        return Api.post("/energysheet/index", sheet);
    },
    getEnergySheetIndex() {
       
        return Api.get("/energysheet/index");
    },
};
