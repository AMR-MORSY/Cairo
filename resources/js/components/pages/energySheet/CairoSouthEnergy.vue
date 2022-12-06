<template>
  <div class="container mt-5">
    <Card>
         <template #title>
                   <div class="d-flex justify-content-center align-items-center">
          <p style="text-align: center">Cairo South</p>
        </div>
     
      </template>
      <template #content>
         <div class="row mt-5">
        <div class="col-12 col-md-6 mt-2">
          <TopSites :zoneAlarms="cairoSouthHieghestPowerAlarmDur" @siteNUR="getSiteNUR">
            <template #header> Hieghest Power Alarm Duration </template>
            <template #columns>
              <Column field="siteName" header="Name"></Column>
              <Column field="duration" header="Duration" sortable></Column>
            </template>
          </TopSites>
        </div>
        <div class="col-12 col-md-6 mt-2">
          <TopSites :zoneAlarms="cairoSouthSitesPowerAlarmMoreThan2Times" @siteNUR="getSiteNUR">
            <template #header> Power Alarms per Site </template>
            <template #columns>
              <Column field="siteName" header="Name"></Column>
              <Column field="count" header="Count" sortable></Column>
            </template>
          </TopSites>
        </div>
         <div class="col-12 col-md-6 mt-2">
          <TopSites :zoneAlarms="cairoSouthSitesReportedHTAlarmsDetails" @siteNUR="getSiteNUR">
            <template #header> Sites Reported HT Alarms </template>
            <template #columns>
              <Column field="siteName" header="Name"></Column>
              <Column field="count" header="Count" sortable></Column>
              <Column field="highest_duration" header="Highest Dur" sortable=""></Column>
            </template>
          </TopSites>
        </div>
          <div class="col-12 col-md-6 mt-2">
          <TopSites :zoneAlarms="cairoSouthSitesReportedGenAlarmsDetails" @siteNUR="getSiteNUR">
            <template #header> Sites Reported Gen Alarms </template>
            <template #columns>
              <Column field="siteName" header="Name"></Column>
              <Column field="count" header="Count" sortable></Column>
              <Column field="highest_duration" header="Highest Dur" sortable=""></Column>
            </template>
          </TopSites>
        </div>
      </div>

      </template>
     
    </Card>
  </div>
</template>

<script>
import TopSites from "../energySheet/TopSites.vue";
export default {
  data() {
    return {};
  },
  components:{
    TopSites,

  },
  props: ["cairoSouthHieghestPowerAlarmDur","cairoSouthSitesPowerAlarmMoreThan2Times","cairoSouthSitesReportedHTAlarmsDetails","cairoSouthSitesReportedGenAlarmsDetails"],
  methods:{
    getSiteNUR()
    {

    },

  },

};
</script>

<style lang="scss" scoped>
</style>