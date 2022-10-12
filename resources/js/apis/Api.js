import axios from "axios";

let Api=axios.create({
  
    baseURL:"/api",
 

});

Api.defaults.withCredentials=true;
export default Api;