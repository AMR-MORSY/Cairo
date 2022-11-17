<template>
  <div>
    <Card class="mt-5" style="background-color: #C3B1E1">
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
                <Chart type="doughnut" :data="subsystem" :plugins="plugins" />
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
                <Chart
                  type="bar"
                  :data="generatorStatestics"
                  :plugins="plugins"
                />
              </template>
            </Card>
          </div>
          <div class="col-12 col-md-6 col-lg-4 mt-2">
            <Card>
              <template #title>
                <p style="font-size: 16px; pading: 0; text-align: center">
                  Access Statestics
                </p>
              </template>
              <template #content>
                <Chart
                  type="bar"
                  :data="accessStatesitcs"
                  :options="lightOptions"
                  :plugins="plugins"
                />
              </template>
            </Card>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-6 mt-2">
            <TopSites :zoneNUR="gizaTopNUR" @siteNUR="getSiteNUR">
              <template #header> Top Sites NUR </template>
              <template #columns>
                <Column field="siteName" header="Name"></Column>
                <Column field="NUR" header="NUR" sortable></Column>
              </template>
            </TopSites>
          </div>
          <div class="col-12 col-md-6 mt-2">
            <TopSites :zoneNUR="gizaRepeatedSites" @siteNUR="getSiteNUR">
              <template #header> Repeated Sites </template>
              <template #columns>
                <Column field="siteName" header="Name"></Column>
                <Column field="count" header="Count" sortable></Column>
              </template>
            </TopSites>
          </div>
        </div>
      </template>
    </Card>
  </div>
  <DynamicDialog />
</template>

<script>
import TopSites from "./TopSites.vue";
import ChartDataLabels from "chartjs-plugin-datalabels";
import siteNURTable from "./siteNURTable.vue";

export default {
  data() {
    return {
      subsystem: null,
      generatorStatestics: null,
      accessStatesitcs: null,
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
    };
  },
  components: {
    TopSites,
    siteNURTable,
  },
  props: [
    "gizaSubsystem",
    "gizaTopNUR",
    "gizaGen",
    "gizaRepeatedSites",
    "gizaAccessStatesitcs",
  ],
  name: "CairoEast",
  beforeMount() {
    this.subsystem = {
      labels: Object.keys(this.gizaSubsystem),
      datasets: [
        {
          data: Object.values(this.gizaSubsystem),

          backgroundColor: [
           "#7F00FF",
            "#C3B1E1",
            "#E0B0FF",
            "#5D3FD3",
            "#CF9FFF",
            "#BF40BF",
            "#CCCCFF",
            "#BDB5D5",
            "#E6E6FA",
            "#AA98A9",
            "#953553",
            "#800080",

          ],
        },
      ],
    };
    this.accessStatesitcs = {
      labels: ["NUR", "Total Tickets", "Access Tickets"],
      datasets: [
        {
          data: [this.gizaAccessStatesitcs.NUR,,],
          label: "NUR",
          backgroundColor: "#7F00FF",
        },
        {
          data: [,this.gizaAccessStatesitcs.totalTickets,],
          label: "Total Tickets",
          backgroundColor: "#C3B1E1",
        },
        {
          data: [,,this.gizaAccessStatesitcs.accessTickets],
          label: "Access Tickets",
          backgroundColor: "#800080",
        },
      ],
    };
    this.genStatestics(this.gizaGen);
   
  },
  methods: {
    getSiteNUR(event) {
      console.log(event.NUR3G);
      this.$dialog.open(siteNURTable, {
        props: {
          header: event.NUR3G[0].problem_site_name,
          style: {
            width: "75vw",
          },
          breakpoints: {
            "960px": "75vw",
            "640px": "90vw",
          },
        },
        // templates: {
        //   footer: () => {
        //     return [
        //       h(Button, {
        //         label: "No",
        //         icon: "pi pi-times",
        //         onClick: () => dialogRef.close({ buttonType: "No" }),
        //         class: "p-button-text",
        //       }),
        //       h(Button, {
        //         label: "Yes",
        //         icon: "pi pi-check",
        //         onClick: () => dialogRef.close({ buttonType: "Yes" }),
        //         autofocus: true,
        //       }),
        //     ];
        //   },
        // },
        data: {
          NUR3G: event.NUR3G,
          NUR2G: event.NUR2G,
          NUR4G: event.NUR4G,
        },
      });
    },

    genStatestics(statestics) {
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
            backgroundColor: "#7F00FF",
          },
          {
            data: NUR,
            label: "NUR",
            backgroundColor: "#C3B1E1",
          },
        ],
      };

      this.generatorStatestics = chart;
    },

   
  },
};
</script>

<style lang="scss" scoped>
</style>