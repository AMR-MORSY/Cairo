import { createRouter, createWebHistory } from 'vue-router';
import energySheetIndex from "../components/pages/energySheet/energySheetIndex.vue" ;
import notFount from "../components/notFound.vue";
import newSitesInsert from "../components/pages/sites/newSitesInsert.vue";
import login from "../components/pages/User/login.vue";
import register from "../components/pages/User/register.vue";
import home from "../components/home.vue";
import resetPassword from "../components/pages/User/resetPassword.vue";
import unauthorized from "../components/unauthorized.vue";
import nurIndex from "../components/pages/NUR/nurIndex.vue";
import NUR2G from"../components/pages/NUR/NUR2G.vue";
import NUR3G from"../components/pages/NUR/NUR3G.vue";
import NUR4G from"../components/pages/NUR/NUR4G.vue";



const routes = [
    { path: '/energysheet/index', component: energySheetIndex },
    { path: '/nur', component:nurIndex },
    { path: '/nur/2G', component: NUR2G },
    { path: '/nur/3G', component: NUR3G },
    { path: '/nur/4G', component: NUR4G },
    { path: '/', redirect:"/home" },
    { path: '/home', component:home },
    {path:"/:pathMatch(.*)*",component: notFount},
    {path:"/sites/store", component:newSitesInsert},
    {path:"/user/login", component:login,name:"login"},
    {path:"/user/register", component:register},
    {path:"/user/resetpassword", component:resetPassword},
    {path:"/unauthorized", component:unauthorized},
    
    
  ];
  const router=createRouter({
    history:createWebHistory(),
    routes:routes,
    
  });

  export default router;