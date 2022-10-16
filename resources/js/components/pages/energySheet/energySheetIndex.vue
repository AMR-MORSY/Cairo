<template>
  <div class="container mt-5">
    <form
      id="energysheet"
      @submit.prevent="submitEnergySheet"
      enctype="multipart/form-data"
    >
      <div class="errors mt-5"></div>
      <div class="row index">
        <p v-if="serverError">{{ serverError }}</p>
        <div class="col-12">
          <div v-if="isServerError">
            {{ serverError }}
          </div>
        </div>

        <div class="col-6">
          <div class="form-group">
            <select
              v-model="week"
              @change="clearWeeksErrors"
              id="weeks"
              class="form-control"
            >
              <option value="">select week</option>

              <option v-for="week in weeks" :key="week">{{ week }}</option>
            </select>
            <div v-if="isWeekError">
              <ul>
                <li v-for="error in weekErrors" style="color: red" :key="error">
                  {{ error }}
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <select
              v-model="year"
              @change="clearYearsErrors"
              class="form-control"
            >
              <option value="">select year</option>

              <option v-for="year in years" :key="year">{{ year }}</option>
            </select>
            <div v-if="isYearError">
              <ul>
                <li v-for="error in yearErrors" style="color: red" :key="error">
                  {{ error }}
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="form-group">
            <label for="power">Energy Sheet:</label>
            <input
              type="file"
              name="energy_sheet"
              class="form-control"
              @change="energySheetFile"
              id="energy_sheet"
            />
            <div v-if="isEnergySheetError">
              <ul>
                <li
                  v-for="error in energySheetErrors"
                  style="color: red"
                  :key="error"
                >
                  {{ error }}
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-12 mt-2">
          <spinner-button
            type="submit"
            :show-spinner="showSpinner"
            class="btn btn-primary"
          >
            <span> Submit</span>
          </spinner-button>
        </div>
      </div>
    </form>
  </div>
  <modal variant="danger" :visible="showModal">
    <p class="text-center">{{ successMessage }}</p>
  </modal>
</template>

<script>
import axios from "axios";
import spinnerButton from "../../helpers/spinnerButton.vue";
import Energy from "../../../apis/Energy";

export default {
  components: { spinnerButton },
  data() {
    return {
      weeks: [],
      years: [],
      year: "",
      week: "",
      energySheet: null,
      isYearError: false,
      yearErrors: [],
      isWeekError: false,
      weekErrors: [],
      isEnergySheetError: false,
      energySheetErrors: [],
      serverError: null,
      isServerError: false,
      successMessage: "hello from index",
      isSuccessMessage: false,
      showModal: false,
      showSpinner: false,
    };
  },
  name: "energySheetIndex",

  computed: {
    isLogin() {
      return this.$store.state.isLogin;
    },
    isSuperAdmin() {
      let userRoles = this.$store.state.userRoles;
      let userRole = null;
      userRoles.forEach((role) => {
        if (role.name == "super-admin") {
          userRole = role.name;
        }
      });
      if (userRole) {
        return true;
      } else {
        return false;
      }
    },
  },

  beforeRouteEnter(to, from, next) {
    next((vm) => {
      if (!vm.isLogin || vm.isSuperAdmin == false) {
        return vm.$router.push(from.path);
      } else {
        vm.getEnergySheetIndex();
      }
    });
  },

  mounted() {},
  methods: {
    getEnergySheetIndex() {
      this.serverError = null;
      this.yearErrors = null;
      this.weekErrors = null;
      // axios.get("/api/energysheet/index").then((response) => {
      //   this.weeks = response.data.weeks;
      //   this.years = response.data.years;
      // });
      Energy.getEnergySheetIndex()
        .then((response) => {
          this.weeks = response.data.weeks;
          this.years = response.data.years;
        })
        .catch((error) => {
          // if (error.response.status == 403 || error.response.status == 401) {
          //   this.$router.push({ path: "/user/login" });
          //  }
          if (error.response.status == 500) {
            this.serverError = "internal Server Error";
          }
        });
    },
    clearYearsErrors() {
      this.yearErrors = [];
      this.serverError = null;
      this.isYearError = false;
      this.isServerError = false;
    },
    clearWeeksErrors() {
      this.weekErrors = [];
      this.serverError = null;
      this.isWeekError = false;
      this.isServerError = false;
    },
    energySheetFile(e) {
      this.energySheetErrors = [];
      this.serverError = null;
      this.isServerError = false;
      this.isEnergySheetError = false;
      return (this.energySheet = e.target.files[0]);
    },

    submitEnergySheet() {
      var data = {
        energy_sheet: this.energySheet,
        // down: this.down,
        // high_temp: this.high_temp,
        // gen: this.gen,
        week: this.week,
        year: this.year,
      };
      this.showSpinner = true;

      axios
        .post("/api/energysheet/index", data, {
          headers: {
            "Content-Type": "multipart/form-data",
            responseType: "json",
          },
        })
        .then((response) => {
          console.log(response.data.message);
          this.successMessage = response.data.message;
          this.showModal = true;
          // this.weeks = response.data.weeks;
          // this.years = response.data.years;
          //   console.log(isResponseGot);
        })
        .catch((error) => {
          if (error.response) {
            if (error.response.status == "500") {
              this.serverError = "internal server error";
              this.isServerError = true;
            }
            if (error.response.status == 403 || response.status == 401) {
              this.$router.push({ path: "/user/login" });
            }
            // The request was made and the server responded with a status code
            // that falls out of the range of 2xx
            // console.log(error.response.data);
            if (error.response.data) {
              var errors = error.response.data.errors;
              if (errors.week) {
                this.weekErrors = errors.week;
                this.isWeekError = true;
              }
              if (errors.year) {
                this.yearErrors = errors.year;
                this.isYearError = true;
              }
              if (errors.energy_sheet) {
                this.energySheetErrors = errors.energy_sheet;
                this.isEnergySheetError = true;
              }
            }
          } else if (error.request) {
            // The request was made but no response was received
            // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
            // http.ClientRequest in node.js
            console.log(error.request);
          } else {
            // Something happened in setting up the request that triggered an Error
            console.log("Error", error.message);
          }
          //   console.log(error.config);
        })
        .finally(() => {
          this.showSpinner = false;
          this.week = "";
          this.year = "";
          var energy_sheet = document.getElementById("energy_sheet");
          energy_sheet.value = "";
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.index {
  margin-top: 6em;
  width: 70%;
  margin-left: auto;
  margin-right: auto;
}
</style>