import allInstances from "./Api";

export default {

    getModificationAnalysis()
    {
        return allInstances.Api.get("/modifications/analysis");
    },
    getModificationIndex(data)
    {
        return allInstances.Api.post("/modifications/index",data);
    }
    
};