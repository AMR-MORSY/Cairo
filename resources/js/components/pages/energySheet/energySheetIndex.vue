<template>
  <div class="container mt-5">
    <form
      id="energysheet"
      @submit.prevent="submitEnergySheet"
      enctype="multipart/form-data"
    >
      <div class="errors mt-5"></div>
      <div class="row index">
        <div class="progress mb-5">
          <div
            class="progress-bar"
            role="progressbar"
            id="progressbar"
            aria-label="Example with label"
            style="width: 0%"
            aria-valuenow="25"
            aria-valuemin="0"
            aria-valuemax="100"
          >
            0%
          </div>
        </div>
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
         
          <!-- <button class="btn btn-primary" type="submit" >
            <span
              class="spinner-border spinner-border-sm"
              role="status"
              aria-hidden="true" v-if="showSpinner"
            ></span>
            <span > Submit</span>
          </button> -->
          <spinner-button type="submit" :show-spinner="showSpinner" class="btn btn-primary">
             <span> Submit</span>
          </spinner-button>
        </div>
      </div>
    </form>
  </div>
  <modal variant="danger" :visible="showModal">
    <!-- <p class="text-center">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="64"
        height="64"
        fill="#dc3545"
        class="bi bi-exclamation-triangle-fill"
        viewBox="0 0 16 16"
      >
        <path
          d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"
        />
      </svg>
    </p> -->

    <p class="text-center">{{ successMessage }}</p>
  </modal>
</template>

<script>
import axios from "axios";
import spinnerButton from '../../helpers/spinnerButton.vue';
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
      showSpinner:false,
    };
  },
  name: "energySheetIndex",

  mounted() {
    this.getEnergySheetIndex();
    
  },
  methods: {
   
    getEnergySheetIndex() {
      // axios.get("/api/energysheet/index").then((response) => {
      //   this.weeks = response.data.weeks;
      //   this.years = response.data.years;
      // });
       Energy.getEnergySheetIndex().then((response)=>{
        this.weeks = response.data.weeks;
         this.years = response.data.years;

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
     this.showSpinner=true;

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
        .finally(() => {this.showSpinner=false;
        this.week='';
        this.year='';
        var energy_sheet=document.getElementById('energy_sheet');
        energy_sheet.value="";
        });
    },
  },
};
</script>