<template>
 
  <template v-if="notFoundErrors">
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
          <transition name="fade" appear>
            <div class="errors card">
              <p v-for="error in notFoundErrors" :key="error">
                {{ error }}
              </p>
                <div>
                  <Button label="Back" class="p-button-danger" @click="this.$router.go(-1)" />
                </div>
            </div>
          </transition>
        </div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </template>
  <template v-else>
    <section id="cairo">
      <div class="container mt-5">
        <Card>
          <template #title>
            <div class="d-flex justify-content-center align-items-center">
              <p style="text-align: center">{{ period }} {{period_No}}</p>
            </div>
          </template>
          <template #content>
            <div class="row mt-5">
              <div class="col-12 col-md-4">
                <Card>
                  <template #title>
                    <div
                      class="d-flex justify-content-center align-items-center"
                    >
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
                    <div
                      class="d-flex justify-content-center align-items-center"
                    >
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
                    <div
                      class="d-flex justify-content-center align-items-center"
                    >
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
        :period="period"
        :period_No="period_No"
        zone="Cairo South"
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
         :period="period"
           :period_No="period_No"
          zone="Cairo East"
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
         :period="period"
           :period_No="period_No"
          zone="Cairo North"
      >
      </cairo-north-energy>
      <giza-energy
        :gizaHieghestPowerAlarmDur="gizaHieghestPowerAlarmDur"
        :gizaSitesPowerAlarmMoreThan2Times="gizaSitesPowerAlarmMoreThan2Times"
        :gizaSitesReportedHTAlarmsDetails="gizaSitesReportedHTAlarmsDetails"
        :gizaSitesReportedGenAlarmsDetails="gizaSitesReportedGenAlarmsDetails"
         :period="period"
           :period_No="period_No"
          zone="Giza"
      ></giza-energy>
    </section>
  </template>
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
      period_No:null,
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
      notFoundErrors: null,
    };
  },
  name: "energyStatestics",
  props: [ "week", "year"],
 
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
      this.$store.dispatch("displaySpinnerPage", false);
      let data = {
        
        week: this.week,
       
        year: this.year,
      };
      Energy.getEnergyStatestics(data)
        .then((response) => {
          console.log(response);
          this.alarms = response.data.Alarms;
          this.period = this.alarms.period;
          this.period_No=this.alarms.period_No;
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
          if (error.response.status == 404) {
            this.notFoundErrors = error.response.data.errors;
          }
        })
        .finally(() => {
          this.$store.dispatch("displaySpinnerPage", true);
        });
    },
  },
};
</script>

<style lang="scss" scoped>
#cairo {
  margin-top: 6em;
}
#zones {
  margin-bottom: 4em;
}

.errors {
  padding: 3rem;
  p {
    color: red;
    text-align: center;
  }
   display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

.fade-enter-active {
  animation:woble 1s ease;
}
@keyframes woble{
  0% {
    opacity: 0;
    transform: translateY(-300px);
  }
  50% {
    opacity: 1;
    transform: translateY(0px);
  }
  60% {
    transform: translateY(16px);
  }
  70% {
    transform: translateY(-16px);
  }
  80% {
    transform: translateY(8px);
  }
  90% {
    transform: translateY(-8px);
  }
  100% {
    transform: translateY(0px);
  }
}
</style>