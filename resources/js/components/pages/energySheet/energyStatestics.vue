<template>
  <div></div>
</template>

<script>
import Energy from "../../../apis/Energy";
export default {
  data() {
    return {};
  },
  name: "energyStatestics",
  props: ["week_month", "week", "month", "year"],
  emits: ["displayNoneSpinner"],
  watch:{
    week(){
     this.getEnergyStatestics();
    }

  },

  beforeMount(){
    this.getEnergyStatestics();

  },
  methods: {
    getEnergyStatestics() {
      this.$emit("displayNoneSpinner", false);
      let data = {
        week_month: this.week_month,
        week: this.week,
        month: this.month,
        year: this.year,
      };
      Energy.getEnergyStatestics(data)
        .then((response) => {
          console.log(response);
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
         this.$emit("displayNoneSpinner", true);
        });
    },
  },
};
</script>

<style lang="scss" scoped>
</style>