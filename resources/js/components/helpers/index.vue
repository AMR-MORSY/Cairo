<template>
  <div class="container">
    <div class="card index">
      <form @submit.prevent="getNur">
        <div class="row">
        <ul v-if="notFoundErrors">
          <li style="color: red" v-for="error in notFoundErrors" :key="error">
            {{ error }}
          </li>
        </ul>
        <div class="col-12">
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

          <div class="form-group">
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
              class="form-select"
             
            >
              <template v-if="weeks">
                 <option value="">--Select Week/Month--</option>
                <option v-for="period in periods" :key="period">
                  {{ period }}
                </option>
              </template>
              <template v-if="months">
                 <option value="">--Select Week/Month--</option>
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
            <!-- <label for="year">Year</label> -->
            <select
              name=""
              id="year"
              v-model="year"
              :class="{ 'is-invalid': yearError }"
              class="form-select"
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
            class="btn"
                style="background-color:#79589f;color:white;"
          >
            <span> Submit</span>
          </spinner-button>
        </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Energy from "../../apis/Energy";
import NUR from "../../apis/NUR";
import WeeksAndMonths from "../../Helpers/WeeksAndMonths";

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
      month: 0,
      weeks: true,
      months: false,
      notFoundErrors: null,
      NUR2G: null,
    };
  },
  name: "index",
  props: ["alarms"],

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
        let data = {
          week_month: this.week_month,
          week: this.week,
          month: this.month,
          year: this.year,
        };
        console.log(data);

        if (this.alarms == "NUR") {
          this.$router.push(
            `/nur/statestics/${this.week_month}/${this.week}/${this.month}/${this.year}`
          );
        } else {
          this.showSpinner = true;
          Energy.getEnergyStatestics(data)
            .then((response) => {
              console.log(response);
            })
            .catch((error) => {
              console.log(error);
            })
            .finally(() => {
              this.showSpinner = false;
            });
        }
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
      let period = WeeksAndMonths.period(e.target.value);
      if (period.periods == "week") {
        this.periods = period.figures;
        this.week = "week";
        this.month = 0;
        this.weeks = true;
        this.months = false;
      } else {
        this.periods = period.figures;
        this.week = 0;
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
  padding: 2rem;
}
.index {
  margin-top: 6em;
  .header{
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    p{
      font-size: 2rem;
      font-weight: 900;
      color: darkmagenta;
    }
  }
}
</style>