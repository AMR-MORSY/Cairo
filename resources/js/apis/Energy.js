import Csrf from "./Csrf";
import allInstances from "./Api";

export default {
    submitEnergySheet(sheet) {
     

        return allInstances.Api.post("/energysheet/index", sheet);
    },
    getEnergySheetIndex() {
       
        return allInstances.Api.get("/energysheet/index");
    },
    getEnergyStatestics(data){
        return allInstances.Api.get(`/energysheet/statestics/${data.week_month}/${data.week}/${data.month}/${data.year}`);
    
    }
};
