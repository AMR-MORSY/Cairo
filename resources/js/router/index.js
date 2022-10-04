import { createRouter, createWebHistory } from 'vue-router';
import energySheetIndex from "../components/pages/energySheet/energySheetIndex.vue" ;
import notFount from "../components/notFound.vue";
import newSitesInsert from "../components/pages/sites/newSitesInsert.vue";


const routes = [
    { path: '/energyindex', component: energySheetIndex },
    { path: '/', component: app },
    {path:"/:pathMatch(.*)*",component: notFount},
    {path:"/sites/store", component:newSitesInsert},
    
  ];
  const router=createRouter({
    history:createWebHistory(),
    routes:routes,
  });

  export default router;