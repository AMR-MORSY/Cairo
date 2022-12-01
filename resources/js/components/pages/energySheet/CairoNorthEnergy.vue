<template>
  <div class="container mt-5">
    <Card>
         <template #title>
        Cairo North
      </template>
      <template #content>
         <div class="row mt-5">
        <div class="col-12 col-md-6 mt-2">
          <TopSites :zoneAlarms="cairoNorthHieghestPowerAlarmDur" @siteNUR="getSiteNUR">
            <template #header> Hieghest Power Alarm Duration </template>
            <template #columns>
              <Column field="siteName" header="Name"></Column>
              <Column field="duration" header="Duration" sortable></Column>
            </template>
          </TopSites>
        </div>
        <div class="col-12 col-md-6 mt-2">
          <TopSites :zoneAlarms="cairoNorthSitesPowerAlarmMoreThan2Times" @siteNUR="getSiteNUR">
            <template #header> Power Alarms per Site </template>
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
  props: ["cairoNorthHieghestPowerAlarmDur","cairoNorthSitesPowerAlarmMoreThan2Times"],
  methods:{
    getSiteNUR()
    {

    },

  },

};
</script>

<style lang="scss" scoped>
</style>