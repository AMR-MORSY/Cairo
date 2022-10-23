<template>
  <div class="container">
    <div class="row index">
      <form @submit.prevent="getNur">
        <ul v-if="notFoundErrors">
          <li style="color: red" v-for="error in notFoundErrors" :key="error">
            {{ error }}
          </li>
        </ul>
        <div class="col-6">
          <div class="form-group">
            <input
              type="radio"
              @change="changePeriod"
              name="period"
              value="week"
              class="form-controler"
              checked
            />
            <label for="week">Week</label>
          </div>

          <div class="form-grou">
            <input
              type="radio"
              name="period"
              value="month"
              class="form-controler"
              @change="changePeriod"
            />
            <label for="month">Month</label>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <select
              name=""
              v-model="week_month"
              :class="{ 'is-invalid': week_monthError }"
              class="form-control"
            >
              <template v-if="weeks">
                <option v-for="period in periods" :key="period">
                  {{ period }}
                </option>
              </template>
              <template v-if="months">
                <option
                  v-for="period in periods"
                  :value="period.num"
                  :key="period.num"
                >
                  {{ period.char }}
                </option>
              </template>
            </select>
          </div>
          <div v-if="week_monthError">
            <p style="color: red">{{ week_monthError }}</p>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <label for="year">Year</label>
            <select
              name=""
              id="year"
              v-model="year"
              :class="{ 'is-invalid': yearError }"
              class="form-control"
            >
              <option value="">--Select Year--</option>
              <option v-for="year in years" :key="year">
                {{ year }}
              </option>
            </select>
            <div v-if="yearError">
              <p style="color: red">{{ yearError }}</p>
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
      </form>
    </div>
    <!-- <div v-if="NUR2G">
        <p v-for="NUR in NUR2G" :key="NUR">
            {{NUR.impacted_sites}}
        </p>
    </div> -->
  </div>
</template>

<script>
import NUR from "../../../apis/NUR";

export default {
  data() {
    return {
      showSpinner: false,
      years: [],
      year: "",
      yearError: null,
      periods: [],
      week_month: "",
      week_monthError: null,
      week: "week",
      month: "",
      weeks: true,
      months: false,
      notFoundErrors: null,
      NUR2G: null,
    };
  },
  name: "nurIndex",

  methods: {
    getNur() {
      this.week_monthError = null;
      this.yearError = null;
      this.notFoundErrors = null;
      if (!this.week_month) {
        this.week_monthError = "Please select a period";
      }
      if (!this.year) {
        this.yearError = "Please select a year";
      }
      if (this.year && this.week_month) {
        var data = {
          week_month: this.week_month,
          week: this.week,
          month: this.month,
          year: this.year,
        };
        console.log(data);
        this.showSpinner = true;
        NUR.getNur(data)
          .then((response) => {
            console.log(response);
            this.NUR2G = response.data.NUR;
            console.log(this.NUR2G);
          })
          .catch((error) => {
            console.log(error);
            if (error.response.status == 404) {
              this.notFoundErrors = error.response.data.error;
            }
          })
          .finally(() => {
            this.showSpinner = false;
          });
      }
    },
    mountFormData() {
      for (var i = 1; i <= 48; i++) {
        this.periods.push(i);
      }
      for (var i = 2022; i <= 2050; i++) {
        this.years.push(i);
      }
    },
    changePeriod(e) {
      console.log(e.target.value);
      if (e.target.value == "week") {
        var weeks = [];
        for (var i = 1; i <= 48; i++) {
          weeks.push(i);
        }
        this.periods = weeks;
        this.week = "week";
        this.month = "";
        this.weeks = true;
        this.months = false;
      } else {
        var months = [
          { num: 1, char: "January" },
          { num: 2, char: "February" },
          { num: 3, char: "March" },
          { num: 4, char: "April" },
          { num: 5, char: "May" },
          { num: 6, char: "Jun" },
          { num: 7, char: "July" },
          { num: 8, char: "August" },
          { num: 9, char: "September" },
          { num: 10, char: "October" },
          { num: 11, char: "November" },
          { num: 12, char: "December" },
        ];
        this.periods = months;
        this.week = "";
        this.month = "month";
        this.weeks = false;
        this.months = true;
      }
    },
  },
  mounted() {
    this.mountFormData();
  },
};
</script>

<style lang="scss" scoped>
.index,
.helper-table-container {
  width: 70%;
  margin-left: auto;
  margin-right: auto;
}
.index {
  margin-top: 6em;
}
</style>