<template>
  <div class="container mt-5 mb-5">
    <div class="row mt-5">
      <!-- <div class="col-12 col-lg-1"></div> -->
      <div class="col-12 col-lg-12">
        <div class="card">
          <DataTable
            :value="modifications"
            :paginator="true"
            :rows="5"
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
            :rowsPerPageOptions="[5, 10, 15]"
            responsiveLayout="scroll"
            currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
            class="p-datatable-sm"
            stripedRows
          >
            <Column field="site_code" header="Code"></Column>
            <Column field="site_name" header="Name"></Column>
            <Column field="subcontractor" header="Subcontractor"></Column>
            <Column field="requester" header="Requester"></Column>
            <Column field="action" header="Action"></Column>
            <Column field="status" header="Status"></Column>
            <Column field="project" header="Project"></Column>
            <Column field="request_date" header="Request Date"></Column>
            <Column field="finish_date" header="Finish Date"></Column>
            <Column field="cost" header="Cost"></Column>
            <template #footer>
              <div class="d-flex justify-content-end align-items-center">
                Total Cost {{ totalCost }} LE.
              </div>
            </template>
            <template #paginatorstart>
              <Button
                type="button"
                icon="pi pi-refresh"
                class="p-button-text"
              />
            </template>
            <template #paginatorend>
              <Button type="button" icon="pi pi-cloud" class="p-button-text" />
            </template>
          </DataTable>
        </div>
      </div>
      <!-- <div class="col-12 col-lg-1"></div> -->
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      modifications: null,
    };
  },
  computed: {
    totalCost() {
      if (!this.modifications) {
        return 0;
      } else {
      return  this.modifications.reduce(function (sum, current) {
          return sum + Number(current.cost)  ;
        }, 0);
      }
    },
  },
  beforeMount() {
    this.getModificationsIndex();
   
  },
  name: "modificationsIndex",
  methods: {
    getModificationsIndex() {
      this.modifications = this.$store.state.modificationIndex;
      console.log(this.modifications);
    },
  },
};
</script>

<style lang="scss" scoped>
</style>