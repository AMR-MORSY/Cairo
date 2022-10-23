// import Vuex, { mapActions } from "vuex";
import { createStore } from "vuex";
const store = createStore({
    state: {
        isLogin: false,
        user: null,
        userPermissions: null,
        userRoles: null,
        sessionTimeOut:false,
        sessionEnd:false,

    },
    getters: {},
    mutations: {
        NEW_STATUS(state, status) {
            state.isLogin = status;
        },
        USER_DATA(state, user) {
            state.user = user;
            if(user)
            {
                state.sessionTimeOut=false;
                let sessionEnd = user.session.session_end;
                let sessionEndDateMS = Date.parse(sessionEnd);

                let nowLocalDateMS = Date.now();
                let d = new Date(nowLocalDateMS);
                let nowUTCString = d.toUTCString();
                let nowUTCMS = Date.parse(nowUTCString);
    
    
                if (sessionEndDateMS > nowUTCMS) {
                    let sessionRemainDurMS = sessionEndDateMS - nowUTCMS;
                    let timeOut = sessionRemainDurMS-120000;
                    console.log(timeOut);
                    
    
                    setTimeout(() => {
                        state.sessionTimeOut = true;
                    }, timeOut);
    
                  
                }
                else if(sessionEndDateMS < nowUTCMS)
                {
                    state.sessionEnd=true;
                }
                else{
                    state.sessionTimeOut=false;
                }

            }
            else{
                state.sessionTimeOut=false;

            }
           

           
        },
        USER_PERMISSIONS(state, permissions) {
            state.userPermissions = permissions;
        },
        USER_Roles(state, Roles) {
            state.userRoles = Roles;
        },
        CHANGE_TIME_OUT(state,status)
        {
            state.sessionTimeOut=status;
        }
    },
    actions: {
        changeLoginState({ commit }, status) {
            commit("NEW_STATUS", status);
        },
        userData({ commit }, user) {
            commit("USER_DATA", user);
        },
        userPermissions({ commit }, permissions) {
            commit("USER_PERMISSIONS", permissions);
        },
        userRoles({ commit }, roles) {
            commit("USER_Roles", roles);
        },
        // changeTimeOut({commit},status){
        //     commit("CHANGE_TIME_OUT",status);
        // }
    },
});
export default store;
