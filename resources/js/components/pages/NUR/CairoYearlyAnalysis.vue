<template>
  <div>
    <Chart
      type="line"
      :data="yearlyData"
      :options="lightOptions"
      :plugins="plugins"
    ></Chart>
  </div>
</template>

<script>
import ChartDataLabels from "chartjs-plugin-datalabels";
export default {
  data() {
    return {
      yearlyData: null,
      lightOptions: {
        plugins: {
           title: {
                display: true,
                text: 'NUR_C'
            },
          legend: {
            labels: {
              color: "red",
            },
          },
          datalabels: {
            anchor: "center",
            color: "red",
            labels: {
              title: {
                color: "green",
              },
              value: {
                color: "green",
              },
            },
          },
        },

        scales: {
          y: {
            suggestedMin: 0,
          },
        },
      },
      plugins: [ChartDataLabels],
    };
  },
  name: "CairoYearlyAnalysis",
  inject: ["dialogRef"],
  mounted() {
    this.mountLineChartData();
  },
  methods: {
    mountLineChartData() {
      if (this.dialogRef.data.cairo && this.dialogRef.data.zones) {
        this.yearlyData = {
          labels: Object.keys(this.dialogRef.data.cairo),
          datasets: [
            {
              data: this.dialogRef.data.cairo,
              label: "Cairo",
              borderColor: "green",
              // datalabels: {
              //   color: "red",
              // },
            },
            {
              data: this.dialogRef.data.zones["CAIRO EAST"],
              label: "Cairo East",
              borderColor: "#C3B1E1",
              datalabels: {
                // anchor: "center",
                // color: "red",
                labels: {
                  title: {
                    color: "black",
                  },
                  value: {
                    color: "green",
                  },
                },
              },
            },
            {
              data: this.dialogRef.data.zones["GIZA"],
              label: "Giza",
              borderColor: "yellow",
            },
            {
              data: this.dialogRef.data.zones["CAIRO SOUTH"],
              label: "Cairo South",
              borderColor: "red",
            },
            {
              data: this.dialogRef.data.zones["CAIRO NORTH"],
              label: "Cairo North",
              borderColor: "blue",
            },
          ],
        };
      }
    },
  },
};
</script>

<style lang="scss" scoped>
</style>