<template >
  <navbar
    @displayNoneSpinner="displayTheSpinner"
    @displaySitesTable="displaySitesTable"
  ></navbar>
  <!-- <modal :visible="showSessionNotification">
    <template style="font-weight:900; color:red;" #body>{{ data }}</template>
    <template #footer>
      <button class="btn btn-primary" @click="refreshSession">Yes</button>
      <button class="btn btn-danger" @click="goToLogin">No</button>
    </template>
  </modal> -->

  <DynamicDialog />
  <ConfirmDialog></ConfirmDialog>

  <SpinnerPage :displayNone="displaySpinnerPage"></SpinnerPage>

  <router-view @displayNoneSpinner="displayTheSpinner"></router-view>
</template>

<script>
import User from "../apis/User";
import modal from "./helpers/modal.vue";
import SitesTable from "../components/pages/sites/SitesTable.vue";
export default {
  components: { modal, SitesTable },
  data() {
    return {
      showModal: false,
      displaySpinnerPage: true,

      data: "session will end after 2 minutes, renew session",
    };
  },
  watch: {
    sessoinTimeOut(value) {
      // this.showSessionTimeOutNotification();
      console.log(value);
      if (value) {
        this.showSessionTimeOutNotification();
      }
    },
  },
  // created(){
  //   this.$store.watch((state)=>{
  //     return this.$store.state.sessionTimeOut;
  //   },(newValue,oldValue)=>{
  //     console.log(newValue);
  //       console.log(oldValue);
  //   })

  // },
  computed: {
  
    sessoinTimeOut() {
      if (this.$store.state.sessionTimeOut) {
        return true;
      } else {
        return false;
      }
    },
    sessionEnd() {
      if (this.$store.state.sessionEnd) {
        return true;
      }
    },
  },
  name: "app",

  methods: {
    showSessionTimeOutNotification() {
      this.$confirm.require({
        message: "Session will expire in 2 minutes.renew the session?",
        header: "Confirmation",
        icon: "pi pi-exclamation-triangle",
        position: "top",
        acceptClass: "p-button-help",
        rejectClass: "p-button-danger",
        accept: () => {
          this.refreshSession();
        },
        reject: () => {
          this.goToLogin();
        },
      });
    },
    displaySitesTable(event) {
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
    displayTheSpinner(event) {
      this.displaySpinnerPage = event;
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
    this.sessoinTimeOut = this.$store.state.sessionTimeOut;
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