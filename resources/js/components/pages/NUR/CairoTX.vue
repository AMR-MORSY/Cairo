<template>
  <div class="table-container">
    <h3>Sites</h3>
    <DataTable
      :value="sites"
      responsiveLayout="scroll"
      class="p-datatable-sm"
      stripedRows
      :rows="5"
      v-model:selection="selectedSite"
      selectionMode="single"
      dataKey="site_code"
      @row-select="onRowSelect"
    >
      <Column selectionMode="single"></Column>
      <Column field="site_name" header="Name"></Column>
      <Column field="site_code" header="Code"></Column>
      <Column field="NUR_2G_sum" header="NUR-2G" sortable></Column>
      <Column field="NUR_3G_sum" header="NUR-3G" sortable></Column>
      <Column field="NUR_4G_sum" header="NUR-4G" sortable></Column>
      <Column field="NUR_C" header="NUR-C" sortable></Column>
      <Column field="oz" header="oz" sortable></Column>
    </DataTable>
  </div>
</template>

<script>
import NURTicketsVue from "./NURTickets.vue";
export default {
  data() {
    return {
      sites: [],
      tickets: [],
      selectedSite: null,
    };
  },
  name: "CairoTx",
  components:{
    NURTicketsVue,

  },
  inject: ["dialogRef"],
  mounted() {
    this.mountData();
  },
  methods: {
    mountData() {
      this.$store.dispatch("displaySpinnerPage", true);

      this.sites = this.dialogRef.data.sites;
      this.tickets = this.dialogRef.data.tickets;
    },
    onRowSelect() {
        let siteCode=this.selectedSite.site_code;
      console.log(this.selectedSite.site_code);
      let tickets_2G=this.tickets.filter((ticket)=>{
        return ticket.problem_site_code==siteCode && ticket.technology=="2G"
      });
      let tickets_3G=this.tickets.filter((ticket)=>{
        return ticket.problem_site_code==siteCode && ticket.technology=="3G"
      });
      let tickets_4G=this.tickets.filter((ticket)=>{
        return ticket.problem_site_code==siteCode && ticket.technology=="4G"
      });
      
      this.$dialog.open(VIPsORNodalsNURTicketsVue, {
        props: {
          style: {
            width: "75vw",
          },
          breakpoints: {
            "960px": "75vw",
            "640px": "90vw",
          },
          modal: true,
        },

        data: {
          NUR_2G_tickets: tickets_2G,
          NUR_3G_tickets: tickets_3G,
          NUR_4G_tickets: tickets_4G,
        },
      });
    },
  },
};
</script>

<style lang="scss" scoped>
</style>