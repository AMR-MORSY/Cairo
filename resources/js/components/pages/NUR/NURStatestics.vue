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
    <Card class="mt-5" style="background-color: #79589f">
      <template #title>
        <p style="font-size: 16px; color: white; pading: 0; text-align: center">
          Cairo South
        </p>
      </template>
      <template #content>
        <div class="row">
          <div class="col-12 col-md-6 col-lg-4 mt-2">
            <Card>
              <template #title>
                <p style="font-size: 16px; pading: 0; text-align: center">
                  Subsystem
                </p>
              </template>
              <template #content>
                <Chart
                  type="doughnut"
                  :data="cairoSouthSubsystem"
                  :plugins="plugins"
                />
              </template>
            </Card>
          </div>
          <div class="col-12 col-md-6 col-lg-4 mt-2">
            <Card>
              <template #title>
                <p style="font-size: 16px; pading: 0; text-align: center">
                  Generator Statestics
                </p>
              </template>
              <template #content>
                <Chart type="bar" :data="cairoSouthGen" :plugins="plugins" />
              </template>
            </Card>
          </div>
          <div class="col-12 col-md-6 col-lg-4 mt-2">
            <Card>
              <template #title>
                <p style="font-size: 16px; pading: 0; text-align: center">
                  Top Sites NUR
                </p>
              </template>
              <template #content>
                <DataTable
                  :value="cairoSouthTopNUR"
                  responsiveLayout="scroll"
                  class="p-datatable-sm"
                  stripedRows
                >
                  <Column field="siteName" header="Name"></Column>
                  <Column field="NUR" header="NUR"></Column>
                </DataTable>
              </template>
            </Card>
          </div>
        </div>
      </template>
    </Card>
    <Card class="mt-5" style="background-color: #79589f">
      <template #title>
        <p style="font-size: 16px; color: white; pading: 0; text-align: center">
          Cairo East
        </p>
      </template>
      <template #content>
        <div class="row">
          <div class="col-12 col-md-6 col-lg-4 mt-2">
            <Card>
              <template #title>
                <p style="font-size: 16px; pading: 0; text-align: center">
                  Subsystem
                </p>
              </template>
              <template #content>
                <Chart
                  type="doughnut"
                  :data="cairoEastSubsystem"
                  :plugins="plugins"
                />
              </template>
            </Card>
          </div>
          <div class="col-12 col-md-6 col-lg-4 mt-2">
            <Card>
              <template #title>
                <p style="font-size: 16px; pading: 0; text-align: center">
                  Generator Statestics
                </p>
              </template>
              <template #content>
                <Chart type="bar" :data="cairoEastGen" :plugins="plugins" />
              </template>
            </Card>
          </div>
           <div class="col-12 col-md-6 col-lg-4 mt-2">
            <Card>
              <template #title>
                <p style="font-size: 16px; pading: 0; text-align: center">
                  Top Sites NUR
                </p>
              </template>
              <template #content>
                <DataTable
                  :value="cairoEastTopNUR"
                  responsiveLayout="scroll"
                  class="p-datatable-sm"
                  stripedRows
                >
                  <Column field="siteName" header="Name"></Column>
                  <Column field="NUR" header="NUR"></Column>
                </DataTable>
              </template>
            </Card>
          </div>
        </div>
      </template>
    </Card>
    <Card class="mt-5" style="background-color: #79589f">
      <template #title>
        <p style="font-size: 16px; color: white; pading: 0; text-align: center">
          Cairo North
        </p>
      </template>
      <template #content>
        <div class="row">
          <div class="col-12 col-md-6 col-lg-4 mt-2">
            <Card>
              <template #title>
                <p style="font-size: 16px; pading: 0; text-align: center">
                  Subsystem
                </p>
              </template>
              <template #content>
                <Chart
                  type="doughnut"
                  :data="cairoNorthSubsystem"
                  :plugins="plugins"
                />
              </template>
            </Card>
          </div>
          <div class="col-12 col-md-6 col-lg-4 mt-2">
            <Card>
              <template #title>
                <p style="font-size: 16px; pading: 0; text-align: center">
                  Generator Statestics
                </p>
              </template>
              <template #content>
                <Chart type="bar" :data="cairoNorthGen" :plugins="plugins" />
              </template>
            </Card>
          </div>
           <div class="col-12 col-md-6 col-lg-4 mt-2">
            <Card>
              <template #title>
                <p style="font-size: 16px; pading: 0; text-align: center">
                  Top Sites NUR
                </p>
              </template>
              <template #content>
                <DataTable
                  :value="cairoNorthTopNUR"
                  responsiveLayout="scroll"
                  class="p-datatable-sm"
                  stripedRows
                >
                  <Column field="siteName" header="Name"></Column>
                  <Column field="NUR" header="NUR"></Column>
                </DataTable>
              </template>
            </Card>
          </div>
        </div>
      </template>
    </Card>
    <Card class="mt-5" style="background-color: #79589f">
      <template #title>
        <p style="font-size: 16px; color: white; pading: 0; text-align: center">
          Giza
        </p>
      </template>
      <template #content>
        <div class="row">
          <div class="col-12 col-md-6 col-lg-4 mt-2">
            <Card>
              <template #title>
                <p style="font-size: 16px; pading: 0; text-align: center">
                  Subsystem
                </p>
              </template>
              <template #content>
                <Chart
                  type="doughnut"
                  :data="gizaSubsystem"
                  :plugins="plugins"
                />
              </template>
            </Card>
          </div>
          <div class="col-12 col-md-6 col-lg-4 mt-2">
            <Card>
              <template #title>
                <p style="font-size: 16px; pading: 0; text-align: center">
                  Generator Statestics
                </p>
              </template>
              <template #content>
                <Chart type="bar" :data="gizaGen" :plugins="plugins" />
              </template>
            </Card>
          </div>
           <div class="col-12 col-md-6 col-lg-4 mt-2">
            <Card>
              <template #title>
                <p style="font-size: 16px; pading: 0; text-align: center">
                  Top Sites NUR
                </p>
              </template>
              <template #content>
                <DataTable
                  :value="gizaTopNUR"
                  responsiveLayout="scroll"
                  class="p-datatable-sm"
                  stripedRows
                >
                  <Column field="siteName" header="Name"></Column>
                  <Column field="NUR" header="NUR"></Column>
                </DataTable>
              </template>
            </Card>
          </div>
        </div>
      </template>
    </Card>
  </div>
</template>

<script>
import ChartDataLabels from "chartjs-plugin-datalabels";
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
    };
  },
  name: "NURStatestics",
  created() {},
  mounted() {
    this.getNUR();
  },
 

  methods: {
    genStatestics(statestics, zone) {
      let count = [];
      let NUR = [];
      count.push(statestics.ET.count);
      count.push(statestics.ORG.count);
      count.push(statestics.Rented.count);
      count.push(statestics.VF.count);
      NUR.push(statestics.ET.nur);
      NUR.push(statestics.ORG.nur);
      NUR.push(statestics.Rented.nur);
      NUR.push(statestics.VF.nur);

      let chart = {
        labels: ["ET", "ORG", "Rented", "VF"],
        datasets: [
          {
            data: count,
            label: "Count",
            backgroundColor: "red",
          },
          {
            data: NUR,
            label: "NUR",
            backgroundColor: "blue",
          },
        ],
      };
      if (zone == "cairoSouth") {
        this.cairoSouthGen = chart;
      } else if (zone == "cairoEast") {
        this.cairoEastGen = chart;
      } else if (zone == "cairoNorth") {
        this.cairoNorthGen = chart;
      } else if (zone == "giza") {
        this.gizaGen = chart;
      }
    },
    topSitesNUR(sites, zone) {
      let siteNames = Object.keys(sites);
      let NUR = Object.values(sites);

      let topSitesNUR = [];

      for (var i = 0; i < siteNames.length; i++) {
        let siteNUR = {
          siteName: siteNames[i],
          NUR: NUR[i],
        };

        topSitesNUR.push(siteNUR);
      }
      if (zone == "cairoEast") {
        this.cairoEastTopNUR = topSitesNUR;
      } else if (zone == "cairoSouth") {
        this.cairoSouthTopNUR = topSitesNUR;
        console.log(this.cairoSouthTopNUR);
      } else if (zone == "cairoNorth") {
        this.cairoNorthTopNUR = topSitesNUR;
      } else if (zone == "giza") {
        this.gizaTopNUR = topSitesNUR;
      }
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
        // this.cairo3GNUR=Object.values(NUR.NUR3G.zonesNUR3G );
        // let nums=this.cairo3GNUR.map(function(str){
        //   return parseInt(str);

        // });
        // this.cairo3GNUR=nums.reduce(function(sum,current){
        //   return sum+current
        // },0);
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
        let withAccessexceed = [];
        let withAccesswithinSLA = [];
        withAccessexceed.push(
          NUR.NUR3G.zonesResponseWithAccess["CAIRO SOUTH"].exceedSLA
        );
        withAccessexceed.push(
          NUR.NUR3G.zonesResponseWithAccess["CAIRO EAST"].exceedSLA
        );
        withAccessexceed.push(
          NUR.NUR3G.zonesResponseWithAccess["CAIRO NORTH"].exceedSLA
        );
        withAccessexceed.push(
          NUR.NUR3G.zonesResponseWithAccess["GIZA"].exceedSLA
        );
        withAccesswithinSLA.push(
          NUR.NUR3G.zonesResponseWithAccess["CAIRO SOUTH"].withinSLA
        );
        withAccesswithinSLA.push(
          NUR.NUR3G.zonesResponseWithAccess["CAIRO EAST"].withinSLA
        );
        withAccesswithinSLA.push(
          NUR.NUR3G.zonesResponseWithAccess["CAIRO NORTH"].withinSLA
        );
        withAccesswithinSLA.push(
          NUR.NUR3G.zonesResponseWithAccess["GIZA"].withinSLA
        );
        this.zonesResponseWithAccess = {
          labels: Object.keys(NUR.NUR4G.zonesNUR4G),
          datasets: [
            {
              data: withAccessexceed,
              label: "exceed SLA",
              backgroundColor: "#42A5F5",
            },
            {
              data: withAccesswithinSLA,
              label: "within SLA",
              backgroundColor: "red",
            },
          ],
        };

        let withoutAccessexceed = [];
        let withoutAccesswithinSLA = [];
        withoutAccessexceed.push(
          NUR.NUR3G.zonesResponseWithoutAccess["CAIRO SOUTH"].exceedSLA
        );
        withoutAccessexceed.push(
          NUR.NUR3G.zonesResponseWithoutAccess["CAIRO EAST"].exceedSLA
        );
        withoutAccessexceed.push(
          NUR.NUR3G.zonesResponseWithoutAccess["CAIRO NORTH"].exceedSLA
        );
        withoutAccessexceed.push(
          NUR.NUR3G.zonesResponseWithoutAccess["GIZA"].exceedSLA
        );
        withoutAccesswithinSLA.push(
          NUR.NUR3G.zonesResponseWithoutAccess["CAIRO SOUTH"].withinSLA
        );
        withoutAccesswithinSLA.push(
          NUR.NUR3G.zonesResponseWithoutAccess["CAIRO EAST"].withinSLA
        );
        withoutAccesswithinSLA.push(
          NUR.NUR3G.zonesResponseWithoutAccess["CAIRO NORTH"].withinSLA
        );
        withoutAccesswithinSLA.push(
          NUR.NUR3G.zonesResponseWithoutAccess["GIZA"].withinSLA
        );
        this.zonesResponseWithoutAccess = {
          labels: Object.keys(NUR.NUR4G.zonesNUR4G),
          datasets: [
            {
              data: withoutAccessexceed,
              label: "exceed SLA",
              backgroundColor: "#42A5F5",
            },
            {
              data: withoutAccesswithinSLA,
              label: "within SLA",
              backgroundColor: "red",
            },
          ],
        };
        this.cairoSouthSubsystem = {
          labels: Object.keys(NUR.NUR3G.zonesNUR3GSubsystemNUR["CAIRO SOUTH"]),
          datasets: [
            {
              data: Object.values(
                NUR.NUR3G.zonesNUR3GSubsystemNUR["CAIRO SOUTH"]
              ),

              backgroundColor: [
                "red",
                "green",
                "yellow",
                "blue",
                "purple",
                "black",
                "gray",
              ],
            },
          ],
        };
        this.cairoEastSubsystem = {
          labels: Object.keys(NUR.NUR3G.zonesNUR3GSubsystemNUR["CAIRO EAST"]),
          datasets: [
            {
              data: Object.values(
                NUR.NUR3G.zonesNUR3GSubsystemNUR["CAIRO EAST"]
              ),

              backgroundColor: [
                "red",
                "green",
                "yellow",
                "blue",
                "purple",
                "black",
                "gray",
              ],
            },
          ],
        };
        this.cairoNorthSubsystem = {
          labels: Object.keys(NUR.NUR3G.zonesNUR3GSubsystemNUR["CAIRO NORTH"]),
          datasets: [
            {
              data: Object.values(
                NUR.NUR3G.zonesNUR3GSubsystemNUR["CAIRO NORTH"]
              ),

              backgroundColor: [
                "red",
                "green",
                "yellow",
                "blue",
                "purple",
                "black",
                "gray",
              ],
            },
          ],
        };
        this.gizaSubsystem = {
          labels: Object.keys(NUR.NUR3G.zonesNUR3GSubsystemNUR["GIZA"]),
          datasets: [
            {
              data: Object.values(NUR.NUR3G.zonesNUR3GSubsystemNUR["GIZA"]),

              backgroundColor: [
                "red",
                "green",
                "yellow",
                "blue",
                "purple",
                "black",
                "gray",
              ],
            },
          ],
        };
        this.genStatestics(
          NUR.NUR3G.zonesNUR3GGenStatestics["CAIRO SOUTH"],
          "cairoSouth"
        );
        this.genStatestics(
          NUR.NUR3G.zonesNUR3GGenStatestics["CAIRO NORTH"],
          "cairoNorth"
        );
        this.genStatestics(
          NUR.NUR3G.zonesNUR3GGenStatestics["CAIRO EAST"],
          "cairoEast"
        );
        this.genStatestics(NUR.NUR3G.zonesNUR3GGenStatestics["GIZA"], "giza");
        this.topSitesNUR(
          NUR.NUR3G.zonesNUR3GTopSitesNUR["CAIRO EAST"],
          "cairoEast"
        );
        this.topSitesNUR(
          NUR.NUR3G.zonesNUR3GTopSitesNUR["CAIRO SOUTH"],
          "cairoSouth"
        );
        this.topSitesNUR(
          NUR.NUR3G.zonesNUR3GTopSitesNUR["CAIRO NORTH"],
          "cairoNorth"
        );
        this.topSitesNUR(NUR.NUR3G.zonesNUR3GTopSitesNUR["GIZA"], "giza");
      }
    },
  },
};
</script>

<style lang="scss" scoped>
</style>