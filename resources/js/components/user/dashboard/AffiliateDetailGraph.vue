<template>
  <v-card>
    <v-card-title>
      <v-row>
        <v-col cols="12">
          <h4 class="mr-5">アフィリエイター分析</h4>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="2">
          <v-btn outlined @click="$emit('onShrink', 3)">縮小</v-btn>
        </v-col>
        <v-col cols="10" class="d-flex justify-end">
          <v-select
            outlined dense hide-details
            :items="ranks"
            item-value="id" item-text="label"
          />&emsp;
          <v-select
            outlined dense hide-details
            :items="sorts"
            item-value="value" item-text="label"
          />
        </v-col>
      </v-row>
    </v-card-title>
    <v-card-text>
      <v-simple-table>
        <thead>
        <tr>
          <th>アフィリエイター名</th>
          <th>アクセス</th>
          <th>成約数 / 率</th>
          <th>承認数</th>
          <th>報酬額 / 報酬単価</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(d, i) in data" :key="i">
          <td>{{d.affiliate}}</td>
          <td>{{format(d.access)}}</td>
          <td>{{format(d.contract)}}/{{format(d.contract_rate,2)}}%</td>
          <td>{{format(d.accepts)}}</td>
          <td>{{format(d.reward)}}/{{format(d.reward_unit,2)}}</td>
        </tr>
        </tbody>
      </v-simple-table>
    </v-card-text>
    <v-card-text>
      <v-row>
        <v-col cols="12">
          <v-btn block dark color="white" class="text-center black--text" @click="show_graph = !show_graph">
            <v-icon>{{show_graph? 'mdi-chevron-down':'mdi-chevron-up'}}</v-icon>
          </v-btn>
        </v-col>
        <v-col cols="12" v-if="show_graph">
          <bar-chart :chart-data="chartData" :options="chartOption"/>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>

<script>
  import BarChart from "../../common/BarChart";
  export default {
    components: {BarChart},
    props: {
      data: {type: Array, default: []}
    },
    data: vm => ({
      show_graph: false,
      ranks: [{id:1,label:'VIP'}, {id:2,label:'S VIP'}, {id:3,label:'SS VIP'}, {id:4,label:'QUEEN'}, {id:5,label:'KING'}],
      sorts: [{value:1,label:'成約数順'}],
      chartData: {},
      chartOption: {
        scales: {
          yAxes: [
            { id: 'Click', type: 'linear', position: 'left', },
            { id: 'Rate', type: 'linear', position: 'right', ticks: {suggestedMin: 0, suggestedMax: 100 }},
          ]
        },
        responsive: true,
        maintainAspectRatio: false
      }
    }),
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
          labels: this.data.map(x => x.affiliate),
          datasets: [
            {label: 'アクセス', yAxisID: 'Click', data: this.data.map(x => x.access), fill: false, backgroundColor: '#6AD7FF', borderColor: '#6AD7FF'},
            {label: '成約数', yAxisID: 'Click', data: this.data.map(x => x.contract), fill: false, backgroundColor: 'red', borderColor: 'red'},
            {label: '成約率', yAxisID: 'Rate', data: this.data.map(x => x.contract_rate), fill: false, backgroundColor: 'purple', borderColor: 'purple'},
          ]
        }
      },
      format(val, digs=0) {
        return val.toFixed(digs).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
      }
    }
  }
</script>

<style scoped>

</style>