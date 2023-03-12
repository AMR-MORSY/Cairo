<template>
  <div>
    <Chart
      type="line"
      :data="TxType"
      :options="lightOptions"
      :plugins="plugins"
    ></Chart>
  </div>
</template>

<script>
export default {
  data() {
    return {
      lightOptions: {
        plugins: {
          legend: {
            labels: {
              color: "red",
            },
          },
          datalabels: {
            anchor: "center",
            color: "red",
          },
        },
      },
      plugins: [ChartDataLabels],
    };
  },
  name: "CairoYearlyAnalysis",
};
</script>

<style lang="scss" scoped>
</style>