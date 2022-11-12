<template>
  <navbar @displayNoneSpinner="displayTheSpinner" @displaySitesTable="displaySitesTable"></navbar>
  <modal :visible="showSessionNotification">
    <template style="font-weight:900; color:red;" #body>{{ data }}</template>
    <template #footer>
      <button class="btn btn-primary" @click="refreshSession">Yes</button>
      <button class="btn btn-danger" @click="goToLogin">No</button>
    </template>
  </modal>

    <DynamicDialog />

  <SpinnerPage :displayNone="displaySpinnerPage"></SpinnerPage>

  <router-view ></router-view>
</template>

<script>
import User from "../apis/User";
import modal from "./helpers/modal.vue";
import SitesTable from "../components/pages/sites/SitesTable.vue";
export default {
  components: { modal,SitesTable },
  data() {
    return {
      showModal: false,
      displaySpinnerPage:true,
      data: "session will end after 2 minutes, renew session",
    };
  },
  computed: {
    showSessionNotification() {
      return this.$store.state.sessionTimeOut;

     
    },
    sessionEnd() {
      if (this.$store.state.sessionEnd) {
        return true;
      }
    },
  },
  name: "app",

  methods: {
    displaySitesTable(event)
    {
       this.$dialog.open(SitesTable, {
              props: {
                header: "Sites",
                style: {
                  width: "75vw",
                },
                breakpoints: {
                  "960px": "75vw",
                  "640px": "90vw",
                },
                //   modal: true,
              },
              // templates: {
              //   footer: () => {
              //     return [
              //       h(Button, {
              //         label: "No",
              //         icon: "pi pi-times",
              //         onClick: () => dialogRef.close({ buttonType: "No" }),
              //         class: "p-button-text",
              //       }),
              //       h(Button, {
              //         label: "Yes",
              //         icon: "pi pi-check",
              //         onClick: () => dialogRef.close({ buttonType: "Yes" }),
              //         autofocus: true,
              //       }),
              //     ];
              //   },
              // },
              data: {
                sites: event,
              },
            });

    },
    displayTheSpinner(event)
    {
      this.displaySpinnerPage=event;
    },
    refreshSession() {
      User.refreshSession()
        .then((response) => {
          sessionStorage.setItem("Auth", true);
          sessionStorage.setItem("userData", JSON.stringify(response.data));
          this.$store.dispatch("changeLoginState", true);
          this.$store.dispatch("userData", response.data.user);
          this.$store.dispatch("userPermissions", response.data.permissions);
          this.$store.dispatch("userRoles", response.data.roles);
        })
        .catch((error) => {
          if (error) {
            sessionStorage.removeItem("Auth");
            sessionStorage.removeItem("userData");
            this.$store.dispatch("changeLoginState", false);
            this.$store.dispatch("userData", null);
            this.$store.dispatch("userPermissions", null);
            this.$store.dispatch("userRoles", null);
            this.$router.push({ path: "/user/login" });
          }
        });
      // this.$store.dispatch("changeTimeOut",false);
    },
    goToLogin() {
      sessionStorage.removeItem("Auth");
      sessionStorage.removeItem("userData");
      this.$store.dispatch("changeLoginState", false);
      this.$store.dispatch("userData", null);
      this.$store.dispatch("userPermissions", null);
      this.$store.dispatch("userRoles", null);
      this.$router.push({ path: "/user/login" });
    },
  },

  beforeMount() {
    let auth = sessionStorage.getItem("Auth");
    let userData = sessionStorage.getItem("userData");

    {
      if (auth) {
        this.$store.dispatch("changeLoginState", true);
      }
      if (userData) {
        userData = JSON.parse(userData);

        this.$store.dispatch("userData", userData.user);
        this.$store.dispatch("userPermissions", userData.permissions);
        this.$store.dispatch("userRoles", userData.roles);
      }
    }
  },
  mounted() {
    if (this.sessionEnd) {
      sessionStorage.removeItem("Auth");
      sessionStorage.removeItem("userData");
      this.$store.dispatch("changeLoginState", false);
      this.$store.dispatch("userData", null);
      this.$store.dispatch("userPermissions", null);
      this.$store.dispatch("userRoles", null);
      this.$router.push({ path: "/user/login" });
    }
  },
};
</script>

<style lang="scss" >
body {
  background-color: #dde0e3;
}
</style>