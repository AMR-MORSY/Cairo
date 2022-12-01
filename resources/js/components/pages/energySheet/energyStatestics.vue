<template>
  <div></div>
  <cairo-south-energy
    :cairoSouthHieghestPowerAlarmDur="cairoSouthHieghestPowerAlarmDur"
    :cairoSouthSitesPowerAlarmMoreThan2Times="
      cairoSouthSitesPowerAlarmMoreThan2Times
    "
  >
  </cairo-south-energy>
  <cairo-east-energy
    :cairoEastHieghestPowerAlarmDur="cairoEastHieghestPowerAlarmDur"
    :cairoEastSitesPowerAlarmMoreThan2Times="
      cairoEastSitesPowerAlarmMoreThan2Times
    "
  ></cairo-east-energy>
  <cairo-north-energy
    :cairoNorthHieghestPowerAlarmDur="cairoNorthHieghestPowerAlarmDur"
    :cairoNorthSitesPowerAlarmMoreThan2Times="
      cairoNorthSitesPowerAlarmMoreThan2Times
    "
  >
  </cairo-north-energy>
  <giza-energy
    :gizaHieghestPowerAlarmDur="gizaHieghestPowerAlarmDur"
    :gizaSitesPowerAlarmMoreThan2Times="gizaSitesPowerAlarmMoreThan2Times"
  ></giza-energy>
</template>

<script>
import Energy from "../../../apis/Energy";
import CairoEastEnergy from "../energySheet/CairoEastEnergy.vue";
import CairoNorthEnergy from "../energySheet/CairoNorthEnergy.vue";
import CairoSouthEnergy from "../energySheet/CairoSouthEnergy.vue";
import GizaEnergy from "../energySheet/GizaEnergy.vue";
export default {
  data() {
    return {
      alarms: null,
      cairoEastHieghestPowerAlarmDur: null,
      cairoSouthHieghestPowerAlarmDur: null,
      cairoNorthHieghestPowerAlarmDur: null,
      gizaHieghestPowerAlarmDur: null,

      cairoEastSitesPowerAlarmMoreThan2Times: null,
      cairoSouthSitesPowerAlarmMoreThan2Times: null,
      cairoNorthSitesPowerAlarmMoreThan2Times: null,
      gizaSitesPowerAlarmMoreThan2Times: null,
    };
  },
  name: "energyStatestics",
  props: ["week_month", "week", "month", "year"],
  emits: ["displayNoneSpinner"],
  components: {
    CairoEastEnergy,
    CairoNorthEnergy,
    CairoSouthEnergy,
    GizaEnergy,
  },
  watch: {
    week() {
      this.getEnergyStatestics();
    },
  },

  mounted() {
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
          this.alarms = response.data.Alarms;
          ////////////sites with highest alarm duration////////
          this.cairoEastHieghestPowerAlarmDur = Object.values(
            this.alarms.zonesHighiestPowerAlarmDuration["Cairo East"]
          );
          this.cairoSouthHieghestPowerAlarmDur = Object.values(
            this.alarms.zonesHighiestPowerAlarmDuration["Cairo South"]
          );
          this.cairoNorthHieghestPowerAlarmDur = Object.values(
            this.alarms.zonesHighiestPowerAlarmDuration["Cairo North"]
          );
          this.gizaHieghestPowerAlarmDur = Object.values(
            this.alarms.zonesHighiestPowerAlarmDuration["Giza"]
          );

          /////////No of alarms per site/////////////

          this.cairoEastSitesPowerAlarmMoreThan2Times = Object.values(
            this.alarms.zonesSitesPowerAlarmsMoreThan2Times["Cairo East"]
          );
          this.cairoNorthSitesPowerAlarmMoreThan2Times = Object.values(
            this.alarms.zonesSitesPowerAlarmsMoreThan2Times["Cairo North"]
          );
          this.cairoSouthSitesPowerAlarmMoreThan2Times = Object.values(
            this.alarms.zonesSitesPowerAlarmsMoreThan2Times["Cairo South"]
          );
          this.gizaSitesPowerAlarmMoreThan2Times = Object.values(
            this.alarms.zonesSitesPowerAlarmsMoreThan2Times["Giza"]
          );
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