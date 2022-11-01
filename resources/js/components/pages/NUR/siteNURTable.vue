<template>
  <div class="container">
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
export default {
  data() {
    return {
      siteNUR3G: null,
      siteNUR2G: null,
      siteNUR4G: null,
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
};
</script>

<style lang="scss" scoped>
</style>