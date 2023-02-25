<template>
  <div>
    <div class="table-container">
      <h3>2G Tickets</h3>
      <DataTable
        :value="NUR_2G_tickets"
        responsiveLayout="scroll"
        class="p-datatable-sm"
        stripedRows
        :rows="5"
      >
        <Column field="begin" header="begin"></Column>
        <Column field="end" header="End"></Column>
        <Column field="Dur_Hr" header="Dur_Hr"></Column>
        <Column field="cells" header="Cells"></Column>
        <Column field="impacted_sites" header="impacted Sites"></Column>
        <Column field="nur" header="NUR"></Column>
        <Column field="sub_system" header="Sub System"></Column>
        <Column field="solution" header="solution"></Column>
        <Column field="week" header="Week"></Column>
        <Column field="year" header="Year"></Column>
      </DataTable>
    
    </div>
    <div class="table-container">
      <h3>3G Tickets</h3>
      <DataTable
        :value="NUR_3G_tickets"
        responsiveLayout="scroll"
        class="p-datatable-sm"
        stripedRows
        :rows="5"
      >
        <Column field="begin" header="begin"></Column>
        <Column field="end" header="End"></Column>
        <Column field="Dur_Hr" header="Dur_Hr"></Column>
        <Column field="cells" header="Cells"></Column>
        <Column field="impacted_sites" header="impacted Sites"></Column>
        <Column field="nur" header="NUR"></Column>
        <Column field="sub_system" header="Sub System"></Column>
        <Column field="solution" header="solution"></Column>
        <Column field="week" header="Week"></Column>
        <Column field="year" header="Year"></Column>
      </DataTable>
    </div>
    <div class="table-container">
      <h3>4G Tickets</h3>
      <DataTable
        :value="NUR_4G_tickets"
        responsiveLayout="scroll"
        class="p-datatable-sm"
        stripedRows
        :rows="5"
      >
        <!-- <Column field="site_name" header="Site Name"></Column>
        <Column field="site_code" header="site_code"></Column> -->

        <Column field="begin" header="begin"></Column>
        <Column field="end" header="End"></Column>
        <Column field="Dur_Hr" header="Dur_Hr"></Column>
        <Column field="cells" header="Cells"></Column>
        <Column field="impacted_sites" header="impacted Sites"></Column>
        <Column field="nur" header="NUR"></Column>
        <Column field="sub_system" header="Sub System"></Column>
        <Column field="solution" header="solution"></Column>
        <Column field="week" header="Week"></Column>
        <Column field="year" header="Year"></Column>
      </DataTable>
    </div>

     <button class="btn btn-danger mt-5" @click="download2GTickets">Download</button>
  </div>
</template>

<script>
import exportFromJSON from "export-from-json";

export default {
  data() {
    return {
      NUR_2G_tickets: [],
      NUR_3G_tickets: [],
      NUR_4G_tickets: [],
    };
  },
  inject: ["dialogRef"],
  name: "VIPsORNodalsNURTickets",
  mounted() {
    this.mountTablesData();
  },

  methods: {
    mountTablesData() {
      this.NUR_2G_tickets = this.dialogRef.data.NUR_2G_tickets;
      this.NUR_3G_tickets = this.dialogRef.data.NUR_3G_tickets;
      this.NUR_4G_tickets = this.dialogRef.data.NUR_4G_tickets;
    },
    download2GTickets() {
        let tickets=[];
        this.NUR_2G_tickets.forEach((element)=>{
            tickets.push(element);

        });
         this.NUR_3G_tickets.forEach((element)=>{
            tickets.push(element);

        });
         this.NUR_4G_tickets.forEach((element)=>{
            tickets.push(element);

        });
      const data =  tickets;
      const fileName = "Tickets2G";
      const exportType = exportFromJSON.types.xls;

      if (data) exportFromJSON({ data, fileName, exportType });
    },
  },
};
</script>

<style lang="scss" scoped>
</style>