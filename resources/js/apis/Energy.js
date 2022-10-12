import Csrf from "./Csrf";
import Api from "./Api";

export default{
    async submitEnergySheet(sheet)
    {
        await Csrf.getCookie();

        return Api.post("/energysheet/index",sheet);


    },
  async getEnergySheetIndex()
    {
         await Csrf.getCookie();
        return Api.get("/energysheet/index");

    }
}