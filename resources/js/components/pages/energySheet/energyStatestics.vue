<template>
  <section id="cairo">
    <div class="container mt-5">
      <Card>
        <template #title>
          <div class="d-flex justify-content-center align-items-center">
            <p style="text-align: center">{{ period }}</p>
          </div>
        </template>
        <template #content>
          <div class="row mt-5">
            <div class="col-12 col-md-4">
              <Card>
                <template #title>
                  <div class="d-flex justify-content-center align-items-center">
                    <p style="text-align: center">Power Alarms</p>
                  </div>
                </template>
                <template #content>
                  <Chart
                    type="bar"
                    :data="zonesPowerAlrarmsCount"
                    :options="lightOptions"
                    :plugins="plugins"
                  />
                </template>
              </Card>
            </div>
            <div class="col-12 col-md-4">
              <Card>
                <template #title>
                  <div class="d-flex justify-content-center align-items-center">
                    <p style="text-align: center">HT Alarms</p>
                  </div>
                </template>
                <template #content>
                  <Chart
                    type="bar"
                    :data="zonesHTAlrarmsCount"
                    :options="lightOptions"
                    :plugins="plugins"
                  />
                </template>
              </Card>
            </div>
            <div class="col-12 col-md-4">
              <Card>
                <template #title>
                  <div class="d-flex justify-content-center align-items-center">
                    <p style="text-align: center">Gen Alarms</p>
                  </div>
                </template>
                <template #content>
                  <Chart
                    type="bar"
                    :data="zonesGenAlrarmsCount"
                    :options="lightOptions"
                    :plugins="plugins"
                  />
                </template>
              </Card>
            </div>
          </div>
        </template>
      </Card>
    </div>
  </section>

  <section id="zones">
    <cairo-south-energy
      :cairoSouthHieghestPowerAlarmDur="cairoSouthHieghestPowerAlarmDur"
      :cairoSouthSitesPowerAlarmMoreThan2Times="
        cairoSouthSitesPowerAlarmMoreThan2Times
      "
      :cairoSouthSitesReportedHTAlarmsDetails="
        cairoSouthSitesReportedHTAlarmsDetails
      "
      :cairoSouthSitesReportedGenAlarmsDetails="
        cairoSouthSitesReportedGenAlarmsDetails
      "
    >
    </cairo-south-energy>
    <cairo-east-energy
      :cairoEastHieghestPowerAlarmDur="cairoEastHieghestPowerAlarmDur"
      :cairoEastSitesPowerAlarmMoreThan2Times="
        cairoEastSitesPowerAlarmMoreThan2Times
      "
      :cairoEastSitesReportedHTAlarmsDetails="
        cairoEastSitesReportedHTAlarmsDetails
      "
      :cairoEastSitesReportedGenAlarmsDetails="
        cairoEastSitesReportedGenAlarmsDetails
      "
    ></cairo-east-energy>
    <cairo-north-energy
      :cairoNorthHieghestPowerAlarmDur="cairoNorthHieghestPowerAlarmDur"
      :cairoNorthSitesPowerAlarmMoreThan2Times="
        cairoNorthSitesPowerAlarmMoreThan2Times
      "
      :cairoNorthSitesReportedHTAlarmsDetails="
        cairoNorthSitesReportedHTAlarmsDetails
      "
      :cairoNorthSitesReportedGenAlarmsDetails="
        cairoNorthSitesReportedGenAlarmsDetails
      "
    >
    </cairo-north-energy>
    <giza-energy
      :gizaHieghestPowerAlarmDur="gizaHieghestPowerAlarmDur"
      :gizaSitesPowerAlarmMoreThan2Times="gizaSitesPowerAlarmMoreThan2Times"
      :gizaSitesReportedHTAlarmsDetails="gizaSitesReportedHTAlarmsDetails"
      :gizaSitesReportedGenAlarmsDetails="gizaSitesReportedGenAlarmsDetails"
    ></giza-energy>
  </section>
</template>

<script>
import Energy from "../../../apis/Energy";
import CairoEastEnergy from "../energySheet/CairoEastEnergy.vue";
import CairoNorthEnergy from "../energySheet/CairoNorthEnergy.vue";
import CairoSouthEnergy from "../energySheet/CairoSouthEnergy.vue";
import GizaEnergy from "../energySheet/GizaEnergy.vue";
import ChartDataLabels from "chartjs-plugin-datalabels";
export default {
  data() {
    return {
      alarms: null,
      period: null,
      cairoEastHieghestPowerAlarmDur: null,
      cairoSouthHieghestPowerAlarmDur: null,
      cairoNorthHieghestPowerAlarmDur: null,
      gizaHieghestPowerAlarmDur: null,

      cairoEastSitesPowerAlarmMoreThan2Times: null,
      cairoSouthSitesPowerAlarmMoreThan2Times: null,
      cairoNorthSitesPowerAlarmMoreThan2Times: null,
      gizaSitesPowerAlarmMoreThan2Times: null,

      cairoEastSitesReportedHTAlarmsDetails: null,
      cairoNorthSitesReportedHTAlarmsDetails: null,
      cairoSouthSitesReportedHTAlarmsDetails: null,
      gizaSitesReportedHTAlarmsDetails: null,

      cairoEastSitesReportedGenAlarmsDetails: null,
      cairoNorthSitesReportedGenAlarmsDetails: null,
      cairoSouthSitesReportedGenAlarmsDetails: null,
      gizaSitesReportedGenAlarmsDetails: null,

      zonesPowerAlrarmsCount: null,
      lightOptions: {
        plugins: {
          legend: {
            labels: {
              color: "#495057",
            },
          },
          datalabels: {
            anchor: "end",
          },
        },
      },
      plugins: [ChartDataLabels],

      zonesHTAlrarmsCount: null,
      zonesGenAlrarmsCount: null,
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
          this.period = this.alarms.period;
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

          /////////No of Power alarms per site/////////////

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
          ////////////Zones Sites reported HT Alarms Details///////////

          this.cairoNorthSitesReportedHTAlarmsDetails = Object.values(
            this.alarms.zonesSitesReportedHTAlarmsDetails["Cairo North"]
          );

          this.cairoEastSitesReportedHTAlarmsDetails = Object.values(
            this.alarms.zonesSitesReportedHTAlarmsDetails["Cairo East"]
          );

          this.cairoSouthSitesReportedHTAlarmsDetails = Object.values(
            this.alarms.zonesSitesReportedHTAlarmsDetails["Cairo South"]
          );

          this.gizaSitesReportedHTAlarmsDetails = Object.values(
            this.alarms.zonesSitesReportedHTAlarmsDetails["Giza"]
          );

          ////////////Zones Sites reported Gen Alarms Details///////////

          this.cairoNorthSitesReportedGenAlarmsDetails = Object.values(
            this.alarms.zonesSitesReportedGenAlarmsDetails["Cairo North"]
          );

          this.cairoEastSitesReportedGenAlarmsDetails = Object.values(
            this.alarms.zonesSitesReportedGenAlarmsDetails["Cairo East"]
          );

          this.cairoSouthSitesReportedGenAlarmsDetails = Object.values(
            this.alarms.zonesSitesReportedGenAlarmsDetails["Cairo South"]
          );

          this.gizaSitesReportedGenAlarmsDetails = Object.values(
            this.alarms.zonesSitesReportedGenAlarmsDetails["Giza"]
          );

          /////////////Cairo zones Power Alarms Count//////////

          this.zonesPowerAlrarmsCount = {
            labels: Object.keys(this.alarms.zonesPowerAlarmsCount),

            datasets: [
              {
                label: "Count Power Alarms",
                backgroundColor: "#C3B1E1",
                data: Object.values(this.alarms.zonesPowerAlarmsCount),
                borderWidth: 1,
              },
              {
                label: "Sites reported Power Alarms",
                backgroundColor: "var(--purple-500)",
                data: Object.values(this.alarms.zonesSitesReportedPowerAlarms),
                borderWidth: 1,
              },
            ],
          };
          /////////////////////////Cairo Zones HT Alarms count///////////////////////

          this.zonesHTAlrarmsCount = {
            labels: Object.keys(this.alarms.zonesHTAlarmsCount),

            datasets: [
              {
                label: "Count HT Alarms",
                backgroundColor: "#C3B1E1",
                data: Object.values(this.alarms.zonesHTAlarmsCount),
                borderWidth: 1,
              },
              {
                label: "Sites reported HT Alarms",
                backgroundColor: "var(--purple-500)",
                data: Object.values(this.alarms.zonesSitesReportedHTAlarms),
                borderWidth: 1,
              },
            ],
          };
          ////////////////////////Cairo Zones Gen Alarms count///////////////
          this.zonesGenAlrarmsCount = {
            labels: Object.keys(this.alarms.zonesGenAlarmsCount),

            datasets: [
              {
                label: "Count Gen Alarms",
                backgroundColor: "#C3B1E1",
                data: Object.values(this.alarms.zonesGenAlarmsCount),
                borderWidth: 1,
              },
              {
                label: "Sites reported Gen Alarms",
                backgroundColor: "var(--purple-500)",
                data: Object.values(this.alarms.zonesSitesReportedGenAlarms),
                borderWidth: 1,
              },
            ],
          };
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
#cairo {
  margin-top: 6em;
}
#zones{
  margin-bottom: 4em;
}
</style>