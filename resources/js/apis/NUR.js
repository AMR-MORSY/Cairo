import allInstances from "./Api";

export default {
    get2GNurIndex() {
        return allInstances.Api.get("/Nur/index");
    },
    submit2GNurSheet(sheet) {
        return allInstances.Api.post("/Nur/2G", sheet);
    },
    get3GNurIndex() {
        return allInstances.Api.get("/Nur/index");
    },
    submit3GNurSheet(sheet) {
        return allInstances.Api.post("/Nur/3G", sheet);
    },
    get4GNurIndex() {
        return allInstances.Api.get("/Nur/index");
    },
    submit4GNurSheet(sheet) {
        return allInstances.Api.post("/Nur/4G", sheet);
    },
    getNur(data)
    {
        return allInstances.Api.post("/Nur/show", data);

    },
    getSiteNUR(siteCode)
    {
        return allInstances.Api.post("/Nur/siteNUR", siteCode);

    }
};