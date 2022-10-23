import allInstances from "./Api";


export default {
    submitSitesSheet(sheet) {
      return allInstances.Api.post("/sites/store", sheet);
    },
    downloadAll(){

       return allInstances.downloadApi.get("sites/downloadAll");


    },
};
