<template>
  <div class="container mt-5" v-if="isNURAvailable">
    <div class="row">
      <div class="col-12 col-md-6 col-lg-4 mt-5">
        <Card>
          <template #title>
            <p style="font-size: 16px; pading: 0; text-align: center">2G NUR</p>
          </template>
          <template #content>
            <Chart
              type="bar"
              :data="zones2GNUR"
              :options="lightOptions"
              :plugins="plugins"
            />
          </template>
          <template #footer>
            <p>Cairo 2G NUR={{ cairo2GNUR }}</p>
          </template>
        </Card>
      </div>
      <div class="col-12 col-md-6 col-lg-4 mt-5">
        <Card>
          <template #title>
            <p style="font-size: 16px; pading: 0; text-align: center">3G NUR</p>
          </template>
          <template #content>
            <Chart
              type="bar"
              :data="zones3GNUR"
              :options="lightOptions"
              :plugins="plugins"
            />
          </template>
          <template #footer>
            <p>Cairo 3G NUR={{ cairo3GNUR }}</p>
          </template>
        </Card>
      </div>
      <div class="col-12 col-sm-12 col-md-6 col-lg-4 mt-5">
        <Card>
          <template #title>
            <p style="font-size: 16px; pading: 0; text-align: center">4G NUR</p>
          </template>
          <template #content>
            <Chart
              type="bar"
              :data="zones4GNUR"
              :options="lightOptions"
              :plugins="plugins"
            />
          </template>
          <template #footer>
            <p>Cairo 4G NUR={{ cairo4GNUR }}</p>
          </template>
        </Card>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-6 col-lg-4 mt-5">
        <Card>
          <template #title>
            <p style="font-size: 16px; pading: 0; text-align: center">
              Combined NUR
            </p>
          </template>
          <template #content>
            <Chart
              type="bar"
              :data="zonesCombinedNUR"
              :options="lightOptions"
              :plugins="plugins"
            />
          </template>
        </Card>
      </div>
      <div class="col-12 col-md-6 col-lg-4 mt-5">
        <Card>
          <template #title>
            <p style="font-size: 16px; pading: 0; text-align: center">
              Response With Access
            </p>
          </template>
          <template #content>
            <Chart
              type="bar"
              :data="zonesResponseWithAccess"
              :options="lightOptions"
              :plugins="plugins"
            />
          </template>
        </Card>
      </div>
      <div class="col-12 col-md-6 col-lg-4 mt-5">
        <Card>
          <template #title>
            <p style="font-size: 16px; pading: 0; text-align: center">
              Response Without Access
            </p>
          </template>
          <template #content>
            <Chart
              type="bar"
              :data="zonesResponseWithoutAccess"
              :options="lightOptions"
              :plugins="plugins"
            />
          </template>
        </Card>
      </div>
    </div>

    <CairoSouth
      :cairoSouthTopNUR="cairoSouthTopNUR"
      :cairoSouthRepeatedSites="cairoSouthRepeatedSites"
      :cairoSouthGen="cairoSouthGen"
      :cairoSouthSubsystem="cairoSouthSubsystem"
      :cairoSouthAccessStatesitcs="cairoSouthAccessStatesitcs"
    />
    <CairoEast
      :cairoEastTopNUR="cairoEastTopNUR"
      :cairoEastRepeatedSites="cairoEastRepeatedSites"
      :cairoEastGen="cairoEastGen"
      :cairoEastSubsystem="cairoEastSubsystem"
      :cairoEastAccessStatesitcs="cairoEastAccessStatesitcs"
    />
    <CairoNorth
      :cairoNorthTopNUR="cairoNorthTopNUR"
      :cairoNorthRepeatedSites="cairoNorthRepeatedSites"
      :cairoNorthGen="cairoNorthGen"
      :cairoNorthSubsystem="cairoNorthSubsystem"
      :cairoNorthAccessStatesitcs="cairoNorthAccessStatesitcs"
    />
    <Giza
      :gizaTopNUR="gizaTopNUR"
      :gizaRepeatedSites="gizaRepeatedSites"
      :gizaGen="gizaGen"
      :gizaSubsystem="gizaSubsystem"
      :gizaAccessStatesitcs="gizaAccessStatesitcs"
    />
  </div>
  <template v-else>
    <div class="container mt-5">
      <div class="row mt-5">
        <div class="col-12 col-md-4"></div>
        <div class="col-12 col-md-4 mt-5">
          <transition-group name="fade-bounce" appear>
            <template v-if="weekErrors">
              <div class="errors card">
                <p v-for="error in weekErrors" :key="error">
                  {{ error }}
                </p>
              
              </div>
            </template>
            <template v-if="yearErrors">
              <div class="errors card">
                <p v-for="error in yearErrors" :key="error">
                  {{ error }}
                </p>
              </div>
            </template>
            <template v-if="monthErrors">
              <div class="errors card">
                <p v-for="error in monthErrors" :key="error">
                  {{ error }}
                </p>
              </div>
            </template>
            <template v-if="notFoundErrors">
              <div class="errors card">
                <p v-for="error in notFoundErrors" :key="error">
                  {{ error }}
                </p>
                  <div>
                  <Button label="Back" class="p-button-danger" @click="this.$router.go(-1)" />
                </div>
              </div>
            </template>
          </transition-group>
        </div>
        <div class="col-12 col-md-4"></div>
      </div>
    </div>
  </template>
</template>

<script>
import ChartDataLabels from "chartjs-plugin-datalabels";
import NUR from "../../../apis/NUR";
import TopSites from "./TopSites.vue";
import siteNURTable from "./siteNURTable.vue";
import CairoSouth from "./CairoSouth.vue";
import CairoEast from "./CairoEast.vue";
import CairoNorth from "./CairoNorth.vue";
import Giza from "./Giza.vue";
export default {
  data() {
    return {
      weekErrors: null,
      monthErrors: null,
      yearErrors: null,
      notFoundErrors: null,
      isNURAvailable: false,
      zones2GNUR: null,
      zones3GNUR: null,
      zones4GNUR: null,
      zonesCombinedNUR: null,
      cairo3GNUR: null,
      cairo2GNUR: null,
      cairo4GNUR: null,
      cairoCombinedNUR: null,
      cairoSouthSubsystem: null,
      cairoEastSubsystem: null,
      cairoNorthSubsystem: null,
      gizaSubsystem: null,
      zonesResponseWithAccess: null,
      zonesResponseWithoutAccess: null,
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
      cairoSouthGen: null,
      cairoEastGen: null,
      cairoNorthGen: null,
      gizaGen: null,
      cairoSouthTopNUR: null,
      cairoEastTopNUR: null,
      cairoNorthTopNUR: null,
      gizaTopNUR: null,
      cairoSouthRepeatedSites: null,
      gizaRepeatedSites: null,
      cairoNorthRepeatedSites: null,
      cairoEastRepeatedSites: null,
      cairoSouthAccessStatesitcs: null,
      cairoEastAccessStatesitcs: null,
      cairoNorthAccessStatesitcs: null,
      gizaAccessStatesitcs: null,
    };
  },
  name: "NURStatestics",
  beforeMount() {
    this.getNUR();
  },
  props: ["week_month", "week", "month", "year"],
  emits: ["displayNoneSpinner"],
  watch:{
    week(){
      this.getNUR();

    }

  },
  components: {
    TopSites,
    siteNURTable,
    CairoSouth,
    CairoEast,
    CairoNorth,
    Giza,
  },

  methods: {
    Responses(zoneExceed, zoneWith) {
      let exceed = [];
      let withinSLA = [];
      zoneExceed.forEach((element) => {
        exceed.push(element);
      });

      zoneWith.forEach((element) => {
        withinSLA.push(element);
      });
      let response = {
        exceed: exceed,
        withinSLA: withinSLA,
      };
      return response;
    },
    getNUR() {
      this.$emit("displayNoneSpinner", false);
      let data = {
        week_month: this.week_month,
        week: this.week,
        month: this.month,
        year: this.year,
      };

      NUR.getNur(data)
        .then((response) => {
          console.log(response);
          let NUR = response.data.NUR;
          this.isNURAvailable = true;
          this.zones2GNUR = {
            labels: Object.keys(NUR.NUR2G.zonesNUR2G),

            datasets: [
              {
                label: "2G NUR",
                backgroundColor: "#7F00FF",
                data: Object.values(NUR.NUR2G.zonesNUR2G),
                borderWidth: 1,
              },
              {
                label: "No.tickets",
                backgroundColor: "#C3B1E1",
                data: Object.values(NUR.NUR2G.zonesTotalNumTickets),
                borderWidth: 1,
              },
            ],
          };
          this.cairo2GNUR = NUR.NUR2G.cairoNUR2G;
          this.zones3GNUR = {
            labels: Object.keys(NUR.NUR3G.zonesNUR3G),
            datasets: [
              {
                label: "3G NUR",
                backgroundColor: "#7F00FF",
                data: Object.values(NUR.NUR3G.zonesNUR3G),
                borderWidth: 1,
              },
              {
                label: "No.tickets",
                backgroundColor: "#C3B1E1",
                data: Object.values(NUR.NUR3G.zonesTotalNumTickets),
                borderWidth: 1,
              },
            ],
          };
          this.cairo3GNUR = NUR.NUR3G.cairoNUR3G;

          this.zones4GNUR = {
            labels: Object.keys(NUR.NUR4G.zonesNUR4G),
            datasets: [
              {
                label: "4G NUR",
                backgroundColor: "#7F00FF",
                data: Object.values(NUR.NUR4G.zonesNUR4G),
                borderWidth: 1,
              },
              {
                label: "No.tickets",
                backgroundColor: "#C3B1E1",
                data: Object.values(NUR.NUR4G.zonesTotalNumTickets),
                borderWidth: 1,
              },
            ],
          };
          this.cairo4GNUR = NUR.NUR4G.cairoNUR4G;
          this.zonesCombinedNUR = {
            labels: Object.keys(NUR.combined),

            datasets: [
              {
                label: "Combined NUR",
                backgroundColor: "#C3B1E1",
                data: Object.values(NUR.combined),
                borderWidth: 1,
              },
            ],
          };
          this.cairoCombinedNUR = NUR.combined.cairo;

          let zoneExceed = [
            NUR.NUR3G.zonesResponseWithAccess["CAIRO SOUTH"].exceedSLA,
            NUR.NUR3G.zonesResponseWithAccess["CAIRO EAST"].exceedSLA,
            NUR.NUR3G.zonesResponseWithAccess["CAIRO NORTH"].exceedSLA,
            NUR.NUR3G.zonesResponseWithAccess["GIZA"].exceedSLA,
          ];
          let zoneWith = [
            NUR.NUR3G.zonesResponseWithAccess["CAIRO SOUTH"].withinSLA,

            NUR.NUR3G.zonesResponseWithAccess["CAIRO EAST"].withinSLA,

            NUR.NUR3G.zonesResponseWithAccess["CAIRO NORTH"].withinSLA,

            NUR.NUR3G.zonesResponseWithAccess["GIZA"].withinSLA,
          ];
          let resp = this.Responses(zoneExceed, zoneWith);

          this.zonesResponseWithAccess = {
            labels: Object.keys(NUR.NUR4G.zonesNUR4G),
            datasets: [
              {
                data: resp.exceed,
                label: "exceed SLA",
                backgroundColor: "#7F00FF",
              },
              {
                data: resp.withinSLA,
                label: "within SLA",
                backgroundColor: "#C3B1E1",
              },
            ],
          };

          zoneExceed = [
            NUR.NUR3G.zonesResponseWithoutAccess["CAIRO SOUTH"].exceedSLA,
            NUR.NUR3G.zonesResponseWithoutAccess["CAIRO EAST"].exceedSLA,
            NUR.NUR3G.zonesResponseWithoutAccess["CAIRO NORTH"].exceedSLA,
            NUR.NUR3G.zonesResponseWithoutAccess["GIZA"].exceedSLA,
          ];
          zoneWith = [
            NUR.NUR3G.zonesResponseWithoutAccess["CAIRO SOUTH"].withinSLA,

            NUR.NUR3G.zonesResponseWithoutAccess["CAIRO EAST"].withinSLA,

            NUR.NUR3G.zonesResponseWithoutAccess["CAIRO NORTH"].withinSLA,

            NUR.NUR3G.zonesResponseWithoutAccess["GIZA"].withinSLA,
          ];
          resp = this.Responses(zoneExceed, zoneWith);

          this.zonesResponseWithoutAccess = {
            labels: Object.keys(NUR.NUR4G.zonesNUR4G),
            datasets: [
              {
                data: resp.exceed,
                label: "exceed SLA",
                backgroundColor: "#7F00FF",
              },
              {
                data: resp.withinSLA,
                label: "within SLA",
                backgroundColor: "#C3B1E1",
              },
            ],
          };

          this.cairoSouthSubsystem =
            NUR.NUR3G.zonesNUR3GSubsystemNUR["CAIRO SOUTH"];
          this.cairoEastSubsystem =
            NUR.NUR3G.zonesNUR3GSubsystemNUR["CAIRO EAST"];
          this.cairoNorthSubsystem =
            NUR.NUR3G.zonesNUR3GSubsystemNUR["CAIRO NORTH"];
          this.gizaSubsystem = NUR.NUR3G.zonesNUR3GSubsystemNUR["GIZA"];

          this.cairoSouthGen = NUR.NUR3G.zonesNUR3GGenStatestics["CAIRO SOUTH"];
          this.cairoEastGen = NUR.NUR3G.zonesNUR3GGenStatestics["CAIRO EAST"];
          this.cairoNorthGen = NUR.NUR3G.zonesNUR3GGenStatestics["CAIRO NORTH"];
          this.gizaGen = NUR.NUR3G.zonesNUR3GGenStatestics["GIZA"];

          this.cairoSouthTopNUR = Object.values(NUR.topNUR["CAIRO SOUTH"]);
          this.cairoEastTopNUR = Object.values(NUR.topNUR["CAIRO EAST"]);
          this.cairoNorthTopNUR = Object.values(NUR.topNUR["CAIRO NORTH"]);
          this.gizaTopNUR = Object.values(NUR.topNUR["GIZA"]);

          this.cairoSouthRepeatedSites = Object.values(
            NUR.topRepeated["CAIRO SOUTH"]
          );
          this.cairoEastRepeatedSites = Object.values(
            NUR.topRepeated["CAIRO EAST"]
          );
          this.cairoNorthRepeatedSites = Object.values(
            NUR.topRepeated["CAIRO NORTH"]
          );
          this.gizaRepeatedSites = Object.values(NUR.topRepeated["GIZA"]);

          this.cairoSouthAccessStatesitcs = {
            totalTickets: NUR.NUR3G.zonesTotalNumTickets["CAIRO SOUTH"],
            accessTickets:
              NUR.NUR3G.zonesNUR3GAccessCountTickets["CAIRO SOUTH"].access,
            NUR: NUR.NUR3G.zonesNUR3GAccessNUR["CAIRO SOUTH"].access,
          };
          this.cairoNorthAccessStatesitcs = {
            totalTickets: NUR.NUR3G.zonesTotalNumTickets["CAIRO NORTH"],
            accessTickets:
              NUR.NUR3G.zonesNUR3GAccessCountTickets["CAIRO NORTH"].access,
            NUR: NUR.NUR3G.zonesNUR3GAccessNUR["CAIRO NORTH"].access,
          };
          this.cairoEastAccessStatesitcs = {
            totalTickets: NUR.NUR3G.zonesTotalNumTickets["CAIRO EAST"],
            accessTickets:
              NUR.NUR3G.zonesNUR3GAccessCountTickets["CAIRO EAST"].access,
            NUR: NUR.NUR3G.zonesNUR3GAccessNUR["CAIRO EAST"].access,
          };
          this.gizaAccessStatesitcs = {
            totalTickets: NUR.NUR3G.zonesTotalNumTickets["GIZA"],
            accessTickets:
              NUR.NUR3G.zonesNUR3GAccessCountTickets["GIZA"].access,
            NUR: NUR.NUR3G.zonesNUR3GAccessNUR["GIZA"].access,
          };
        })
        .catch((error) => {
          console.log(error);
          this.isNURAvailable = false;
          if (error.response.status == 422) {
            let errors = error.response.data.errors;
            if (errors.week) {
              this.weekErrors = [];
              errors.week.forEach((element) => {
                this.weekErrors.push(element);
              });
            }
            if (errors.month) {
              this.monthErrors = [];
              errors.month.forEach((element) => {
                this.monthErrors.push(element);
              });
            }
            if (errors.year) {
              this.yearErrors = [];
              errors.year.forEach((element) => {
                this.yearErrors.push(element);
              });
            }
          } else if (error.response.status == 404) {
            this.notFoundErrors = error.response.data.errors;
          }
        })
        .finally(() => {
          this.$emit("displayNoneSpinner", true);
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.table-container {
  position: relative;
  .spinner {
    position: absolute;
    display: flex;
    justify-content: center;
    align-items: center;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    z-index: 1;
    background-color: rgba($color: #ffff, $alpha: 0.7);
  }
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

.fade-bounce-enter-active {
  animation: woble 1s ease;
}
@keyframes woble {
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