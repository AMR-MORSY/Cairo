import allInstances from "./Api";

export default {
    submitSitesSheet(sheet) {
        return allInstances.Api.post("/sites/store", sheet);
    },
    downloadAll() {
        return allInstances.downloadApi.get("sites/downloadAll");
    },
    getAllCascades() {
        return allInstances.downloadApi.get("sites/cascades");
    },
    importCascades(sheet)
    {
      return allInstances.Api.post("/sites/cascades", sheet);

    },
    importNodals(sheet)
    {
      return allInstances.Api.post("/sites/nodals", sheet);



    },
    searchSites(data)
    {
      return allInstances.Api.get(`/sites/search/${data}`)
    },
    getSiteDetails(id)
    {
      return allInstances.Api.get(`/sites/details/${id}`)
    }
};
