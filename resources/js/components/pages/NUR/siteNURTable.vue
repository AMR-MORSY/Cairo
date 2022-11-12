<template>
  <div class="container">
    <div
      class="d-flex flex-column algin-items-center justify-content-center p-2"
    >
      <div class="d-flex  algin-items-center justify-content-start p-1">
        <Button icon="pi pi-bell" class="p-button-rounded p-button-danger" @click="getSiteAlarms" />
      </div>

      <p style="color: red; font-weight:600;">Alarms</p>
    </div>
    <div v-if="count2G">
      <DataTable
        :value="siteNUR2G"
        responsiveLayout="scroll"
        class="p-datatable-sm"
        stripedRows
      >
        <template #header>
          <div class="table-header">2G NUR</div>
        </template>
        <Column
          v-for="col in columns"
          :field="col.field"
          :header="col.header"
          :key="col.field"
        ></Column>
      </DataTable>
    </div>
    <div v-if="count3G">
      <DataTable
        :value="siteNUR3G"
        responsiveLayout="scroll"
        class="p-datatable-sm"
        stripedRows
      >
        <template #header>
          <div class="table-header">3G NUR</div>
        </template>
        <Column
          v-for="col in columns"
          :field="col.field"
          :header="col.header"
          :key="col.field"
        ></Column>
      </DataTable>
    </div>
    <div v-if="count4G">
      <DataTable
        :value="siteNUR4G"
        responsiveLayout="scroll"
        class="p-datatable-sm"
        stripedRows
      >
        <template #header>
          <div class="table-header">4G NUR</div>
        </template>
        <Column
          v-for="col in columns"
          :field="col.field"
          :header="col.header"
          :key="col.field"
        ></Column>
      </DataTable>
    </div>
    <!-- </template>
    </Card> -->
  </div>
</template>

<script>
import SiteAlarmsTable from "./SiteAlarmsTable.vue";
export default {
  data() {
    return {
      siteNUR3G: null,
      siteNUR2G: null,
      siteNUR4G: null,
      siteName:null,
      siteCode:null,
      count2G: false,
      count3G: false,
      count4G: false,
      columns: null,
    };
  },
  created() {
    this.columns = [
      { field: "week", header: "Week" },
      { field: "Dur_Hr", header: "Durations" },
      { field: "begin", header: "Start Time" },
      { field: "end", header: "End Time" },
      { field: "nur", header: "NUR" },
      { field: "sub_system", header: "Subsystem" },
      { field: "cells", header: "Cells" },
      { field: "impacted_sites", header: "impacted" },
    ];
  },
  components:{
    SiteAlarmsTable,


  },
  inject: ["dialogRef"],
  name: "siteNURTable",
  mounted() {
    this.siteNUR3G = this.dialogRef.data.NUR3G;
    if (this.siteNUR3G.length > 0) {
      this.count3G = true;
    }
    this.siteNUR2G = this.dialogRef.data.NUR2G;
    if (this.siteNUR2G.length > 0) {
      this.count2G = true;
    }
    this.siteNUR4G = this.dialogRef.data.NUR4G;
    if (this.siteNUR4G.length > 0) {
      this.count4G = true;
    }
  },
  methods:{
    getSiteAlarms(){
      console.log(this.siteNUR3G);
      if(this.count2G==true)
      {
        this.siteCode=this.siteNUR2G[0].problem_site_code;
         this.siteName=this.siteNUR2G[0].problem_site_name;
      }
      else if(this.count3G==true)
      {
       this.siteCode=this.siteNUR3G[0].problem_site_code;
       this.siteName=this.siteNUR3G[0].problem_site_name;
      }
      else if(this.count4G==true)
      {
        this.siteCode=this.siteNUR4G[0].problem_site_code;
       this.siteName=this.siteNUR4G[0].problem_site_name;
      }
      this.$dialog.open(SiteAlarmsTable, {
        props: {
          header: this.siteName,
          style: {
            width: "75vw",
          },
          breakpoints: {
            "960px": "75vw",
            "640px": "90vw",
          },
        //   modal: true,
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
        data: this.siteCode,
      });


    },
  }
};
</script>

<style lang="scss" scoped>
</style>