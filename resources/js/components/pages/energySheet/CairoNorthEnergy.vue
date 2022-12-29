<template>
  <div class="container mt-5">
    <Card>
         <template #title>
             <div class="d-flex justify-content-center align-items-center">
          <p style="text-align: center">Cairo North</p>
        </div>
     
      </template>
      <template #content>
         <div class="row mt-5">
        <div class="col-12 col-md-6 mt-2">
          <TopSites :zoneAlarms="{
                alarms: cairoNorthHieghestPowerAlarmDur,
                alarmsName: 'hieghestPowerAlarmDur',
              }"  @siteCode=" getSiteCode">
            <template #header> Highest Power Alarm Duration </template>
            <template #columns>
              <Column field="siteName" header="Name"></Column>
              <Column field="duration" header="Duration" sortable></Column>
            </template>
          </TopSites>
        </div>
        <div class="col-12 col-md-6 mt-2">
          <TopSites  :zoneAlarms="{
                alarms: cairoNorthSitesPowerAlarmMoreThan2Times,
                alarmsName: 'sitesPowerAlarmMoreThan2Times',
              }" @siteCode=" getSiteCode">
            <template #header> Power Alarms per Site </template>
            <template #columns>
              <Column field="siteName" header="Name"></Column>
              <Column field="count" header="Count" sortable></Column>
            </template>
          </TopSites>
        </div>
         <div class="col-12 col-md-6 mt-2">
          <TopSites :zoneAlarms="{
                alarms: cairoNorthSitesReportedHTAlarmsDetails,
                alarmsName: 'sitesReportedHTAlarmsDetails',
              }"  @siteCode=" getSiteCode">
            <template #header> Sites Reported HT Alarms </template>
            <template #columns>
              <Column field="siteName" header="Name"></Column>
              <Column field="count" header="Count" sortable></Column>
              <Column field="highest_duration" header="Highest Dur" sortable=""></Column>
            </template>
          </TopSites>
        </div>
         <div class="col-12 col-md-6 mt-2">
          <TopSites :zoneAlarms="{
                alarms: cairoNorthSitesReportedGenAlarmsDetails,
                alarmsName: 'sitesReportedGenAlarmsDetails',
              }"  @siteCode=" getSiteCode">
            <template #header> Sites Reported Gen Alarms </template>
            <template #columns>
              <Column field="siteName" header="Name"></Column>
              <Column field="count" header="Count" sortable></Column>
              <Column field="highest_duration" header="Highest Dur" sortable></Column>
            </template>
          </TopSites>
        </div>
      </div>

      </template>
     
    </Card>
  </div>
   <!-- <DynamicDialog key="cairoNorth" v-model:visible="dialog">
    <SiteAlarmsTable/>

  </DynamicDialog> -->
 
</template>

<script>
import TopSites from "../energySheet/TopSites.vue";
import EnergyHelperFunctions from "./EnergyHelperFunctions";
import SiteAlarmsTable from "../energySheet/SiteAlarmsTable.vue";
export default {
  data() {
    return {
      selectedSiteCode: null,
      alarmsName: null,
      selectedSite: null,
      dialog:false,
    
    };
  },
  components:{
    TopSites,
    SiteAlarmsTable,

  },
   watch:{
    siteAlarms(value){
      if(value)
      {
        
      //   this.$dialog.open(SiteAlarmsTable,{
      //   props: {
       
      //     style: {
      //       width: "75vw",
      //     },
      //     breakpoints: {
      //       "960px": "75vw",
      //       "640px": "90vw",
      //     },
      //       modal: true,
      //   },
      //   onClose:(options)=>{
      //      this.$store.dispatch("siteAlarms",null);
            

      //   },
       
      
      // });
     

       }

    },

  },
  computed:{

    siteAlarms(){

      if(this.$store.state.siteAlarms)
      {
        return true;
      }
      else{
        return false;
      }

    },



  },
  props: ["cairoNorthHieghestPowerAlarmDur","cairoNorthSitesPowerAlarmMoreThan2Times","cairoNorthSitesReportedHTAlarmsDetails","cairoNorthSitesReportedGenAlarmsDetails"],
  methods:{
     getSiteCode(event) {
   
      this.selectedSiteCode = event.siteCode;
      this.alarmsName = event.alarmsName;
    
      if (
        this.alarmsName == "hieghestPowerAlarmDur" ||
        this.alarmsName == "sitesPowerAlarmMoreThan2Times"
      ) {
        EnergyHelperFunctions.getSitePowerAlarms(this.selectedSiteCode);
         

       
      } else if (this.alarmsName == "sitesReportedHTAlarmsDetails") {
        EnergyHelperFunctions.getSiteHighTempAlarms(this.selectedSiteCode);
      } else if (this.alarmsName == "sitesReportedGenAlarmsDetails") {
         EnergyHelperFunctions.getSiteGenAlarms(this.selectedSiteCode);
      }
    },
   
  },
    

  

};
</script>

<style lang="scss" scoped>
</style>