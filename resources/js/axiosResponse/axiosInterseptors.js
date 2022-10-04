

// var isRequestSent = false;
// axios.interceptors.request.use(
//     function (config) {
//         // Do something before request is sent
//         isRequestSent = true;
//         // return config;
//         return isRequestSent
//     },
//     function (error) {
//         isRequestSent = true;
//         // Do something with request error
//         // return Promise.reject(error);
//         return isRequestSent;
//     }
// );
// var isResponseGot = false;
// // Add a response interceptor
// axios.interceptors.response.use(
//     function (response) {
//         // Any status code that lie within the range of 2xx cause this function to trigger
//         // Do something with response data
//         isResponseGot = true;
//         console.log("axiosResponse", response);
//         // return response;
//         return   isResponseGot;
//     },
//     function (error) {
//         isResponseGot = true;
//         // Any status codes that falls outside the range of 2xx cause this function to trigger
//         // Do something with response error
//         // return Promise.reject(error);
//         return   isResponseGot;
//     }
// );

// export default isResponseGot;
