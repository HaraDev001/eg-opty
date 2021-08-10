<template>
  <v-card>
    <v-card-title>
      <v-col cols="6">
        <label class="title">アフィリエイター分析</label>
        <br/>
        <v-btn outlined @click="$emit('onExpand', 3)">詳細</v-btn>
      </v-col>
    </v-card-title>
    <v-card-text>
      <bar-chart :chart-data="chartData" :options="chartOption"/>
    </v-card-text>
  </v-card>
</template>

<script>
  import BarChart from "../../../common/BarChart";

  export default {
    components: {BarChart},
    props: {
      data: { type: Array, default: [] }
    },
    data() {
      return {
        chartData: {},
        chartOption: {}
      }
    },
    mounted() {
      this.loadGraph()
    },
    watch: {
      data(val) {
        this.loadGraph()
      }
    },
    methods: {
      loadGraph() {
        this.chartData = {
          labels: this.data.map(x => x.name),
          datasets: [
            {label: 'クリック数', yAxisID: 'Click', data: this.data.map(x => x.click), fill: false, backgroundColor: '#6AD7FF', borderColor: '#6AD7FF'},
            {label: '成約件数', yAxisID: 'Click', data: this.data.map(x => x.contract), fill: false, backgroundColor: 'red', borderColor: 'red'},
            {label: '成約率', yAxisID: 'Rate', data: this.data.map(x => x.click === 0 ? 0 : (x.contract*100/x.click).toFixed(2)), fill: false, backgroundColor: 'purple', borderColor: 'purple'},
          ]
        }
        this.chartOption = {
          scales: {
            yAxes: [
              { id: 'Click', type: 'linear', position: 'left', },
              { id: 'Rate', type: 'linear', position: 'right', ticks: {suggestedMin: 0, suggestedMax: 100 }},
            ]
          },
          responsive: true,
          maintainAspectRatio: false
        }
      },
    }
  }
</script>

<style scoped>

</style>