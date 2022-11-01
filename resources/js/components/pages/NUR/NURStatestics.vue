<template>
  <div class="container mt-5">
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
      :cairo-South-Subsystem="cairoSouthSubsystem"
      :cairoSouthAccessStatesitcs="cairoSouthAccessStatesitcs"
    />
    <CairoEast
      :cairoEastTopNUR="cairoEastTopNUR"
      :cairoEastRepeatedSites="cairoEastRepeatedSites"
      :cairoEastGen="cairoEastGen"
      :cairo-East-Subsystem="cairoEastSubsystem"
       :cairoEastAccessStatesitcs="cairoEastAccessStatesitcs"
    />
    <CairoNorth
      :cairoNorthTopNUR="cairoNorthTopNUR"
      :cairoNorthRepeatedSites="cairoNorthRepeatedSites"
      :cairoNorthGen="cairoNorthGen"
      :cairo-North-Subsystem="cairoNorthSubsystem"
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
      cairoSouthAccessStatesitcs:null,
      cairoEastAccessStatesitcs:null,
      cairoNorthAccessStatesitcs:null,
      gizaAccessStatesitcs:null,
    };
  },
  name: "NURStatestics",
  created() {
    this.getNUR();
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
      let NUR = this.$store.state.NUR;
      if (!NUR) {
        this.$router.push("/nur");
      } else {
        this.zones2GNUR = {
          labels: Object.keys(NUR.NUR2G.zonesNUR2G),

          datasets: [
            {
              label: "2G NUR",
              backgroundColor: "#42A5F5",
              data: Object.values(NUR.NUR2G.zonesNUR2G),
              borderWidth: 1,
            },
            {
              label: "No.tickets",
              backgroundColor: "red",
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
              backgroundColor: "#42A5F5",
              data: Object.values(NUR.NUR3G.zonesNUR3G),
              borderWidth: 1,
            },
            {
              label: "No.tickets",
              backgroundColor: "red",
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
              backgroundColor: "#42A5F5",
              data: Object.values(NUR.NUR4G.zonesTotalNumTickets),
              borderWidth: 1,
            },
            {
              label: "No.tickets",
              backgroundColor: "red",
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
              backgroundColor: "red",
              data: Object.values(NUR.combined),
              borderWidth: 1,
              barThickness: 8,
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
        let response=this.Responses(zoneExceed,zoneWith);

        this.zonesResponseWithAccess = {
          labels: Object.keys(NUR.NUR4G.zonesNUR4G),
          datasets: [
            {
              data: response.exceed,
              label: "exceed SLA",
              backgroundColor: "#42A5F5",
            },
            {
              data: response.withinSLA,
              label: "within SLA",
              backgroundColor: "red",
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
         response=this.Responses(zoneExceed,zoneWith);

      
        this.zonesResponseWithoutAccess = {
          labels: Object.keys(NUR.NUR4G.zonesNUR4G),
          datasets: [
            {
              data: response.exceed,
              label: "exceed SLA",
              backgroundColor: "#42A5F5",
            },
            {
              data: response.withinSLA,
              label: "within SLA",
              backgroundColor: "red",
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

        this.cairoSouthTopNUR = Object.values(
          NUR.NUR3G.zonesNUR3GTopSitesNUR["CAIRO SOUTH"]
        );
        this.cairoEastTopNUR = Object.values(
          NUR.NUR3G.zonesNUR3GTopSitesNUR["CAIRO EAST"]
        );
        this.cairoNorthTopNUR = Object.values(
          NUR.NUR3G.zonesNUR3GTopSitesNUR["CAIRO NORTH"]
        );
        this.gizaTopNUR = Object.values(
          NUR.NUR3G.zonesNUR3GTopSitesNUR["GIZA"]
        );

        this.cairoSouthRepeatedSites = Object.values(
          NUR.NUR3G.zonesNUR3GRepeatedSitesNUR["CAIRO SOUTH"]
        );
        this.cairoEastRepeatedSites = Object.values(
          NUR.NUR3G.zonesNUR3GRepeatedSitesNUR["CAIRO EAST"]
        );
        this.cairoNorthRepeatedSites = Object.values(
          NUR.NUR3G.zonesNUR3GRepeatedSitesNUR["CAIRO NORTH"]
        );
        this.gizaRepeatedSites = Object.values(
          NUR.NUR3G.zonesNUR3GRepeatedSitesNUR["GIZA"]
        );

        this.cairoSouthAccessStatesitcs={
          totalTickets:NUR.NUR3G.zonesTotalNumTickets['CAIRO SOUTH'],
          accessTickets:NUR.NUR3G.zonesNUR3GAccessCountTickets["CAIRO SOUTH"].access,
          NUR:NUR.NUR3G.zonesNUR3GAccessNUR["CAIRO SOUTH"].access
        };
         this.cairoNorthAccessStatesitcs={
          totalTickets:NUR.NUR3G.zonesTotalNumTickets['CAIRO NORTH'],
          accessTickets:NUR.NUR3G.zonesNUR3GAccessCountTickets["CAIRO NORTH"].access,
          NUR:NUR.NUR3G.zonesNUR3GAccessNUR["CAIRO NORTH"].access
        };
         this.cairoEastAccessStatesitcs={
          totalTickets:NUR.NUR3G.zonesTotalNumTickets['CAIRO EAST'],
          accessTickets:NUR.NUR3G.zonesNUR3GAccessCountTickets["CAIRO EAST"].access,
          NUR:NUR.NUR3G.zonesNUR3GAccessNUR["CAIRO EAST"].access
        };
         this.gizaAccessStatesitcs={
          totalTickets:NUR.NUR3G.zonesTotalNumTickets['GIZA'],
          accessTickets:NUR.NUR3G.zonesNUR3GAccessCountTickets["GIZA"].access,
          NUR:NUR.NUR3G.zonesNUR3GAccessNUR["GIZA"].access
        };
      }
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
</style>