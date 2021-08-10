<template>
  <v-card>
    <v-card-title>
      <v-col cols="3">
        <label class="title">データ推移</label>
        <br/>
        <v-btn outlined @click="$emit('onShrink', 'data')">縮小</v-btn>
      </v-col>
      <v-col cols="9">
        <v-row>
          <v-col cols="12" class="d-flex justify-end py-0">
            <div class="text-center pr-2">
              <p class="purple--text subtitle-1 mb-0">アクセス</p>
              <p class="purple--text title font-weight-bold mb-0 _lh-1">{{last(data, 'access')}}</p>
              <p class="subtitle-2 mb-1">前日比 {{diff(data, 'access')}}</p>
            </div>
            <div class="text-center pr-2">
              <p class="light-blue--text subtitle-1 mb-0">登録</p>
              <p class="light-blue--text title font-weight-bold mb-0 _lh-1">{{last(data, 'register')}}</p>
              <p class="subtitle-2 mb-1">前日比 {{diff(data, 'register')}}</p>
            </div>
            <div class="text-center pr-2">
              <p class="red--text subtitle-1 mb-0">成約</p>
              <p class="red--text title font-weight-bold mb-0 _lh-1">{{last(data, 'contract')}}</p>
              <p class="subtitle-2 mb-1">前日比 {{diff(data, 'contract')}}</p>
            </div>
            <div class="text-center">
              <p class="black--text subtitle-1 mb-0">成約</p>
              <p class="black--text title font-weight-bold mb-0 _lh-1">{{last(data, 'block')}}</p>
              <p class="subtitle-2 mb-1">前日比 {{diff(data, 'block')}}</p>
            </div>
          </v-col>
          <v-col cols="12" class="d-flex justify-end py-0">
            <div class="text-center pr-2">
              <p class="subtitle-1 mb-0" style="color:#00B593">LINE登録</p>
              <p class="title font-weight-bold mb-0 _lh-1" style="color:#00B593">{{last(data, 'line_register')}}</p>
              <p class="subtitle-2 mb-1">前日比 {{diff(data, 'line_register')}}</p>
            </div>
            <div class="text-center pr-2">
              <p class="subtitle-1 mb-0" style="color:#3100FF">LINE承認</p>
              <p class="title font-weight-bold mb-0 _lh-1" style="color:#3100FF">{{last(data, 'line_accept')}}</p>
              <p class="subtitle-2 mb-1">前日比 {{diff(data, 'line_accept')}}</p>
            </div>
            <div class="text-center pr-2">
              <p class="subtitle-1 mb-0" style="color:#55F774">LINE成約</p>
              <p class="title font-weight-bold mb-0 _lh-1" style="color:#55F774">{{last(data.line_contract)}}</p>
              <p class="subtitle-2 mb-1">前日比 {{diff(data.line_contract)}}</p>
            </div>
            <div class="text-center">
              <p class="black--text subtitle-1 mb-0">ブロック率</p>
              <p class="black--text title font-weight-bold mb-0 _lh-1">{{last(data, 'block_rate').toFixed(2)}}%</p>
              <p class="subtitle-2 mb-1">前日比 {{diff(data, 'block_rate').toFixed(2)}}%</p>
            </div>
          </v-col>
        </v-row>
      </v-col>
    </v-card-title>
    <v-card-text>
      <line-chart :chart-data="chartData" :options="chartOption"/>
    </v-card-text>
  </v-card>
</template>

<script>
  import LineChart from "../../../common/LineChart";

  export default {
    components: {LineChart},
    props: {
      data: {type: Array, default: []},
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
          labels: this.data.map(x => x.date),
          datasets: [
            {label: 'アクセス', yAxisID: 'Number', data: this.data.map(x => x.access), fill: false, backgroundColor: 'purple', borderColor: 'purple'},
            {label: '登録', yAxisID: 'Number', data: this.data.map(x => x.register), fill: false, backgroundColor: '#6AD7FF', borderColor: '#6AD7FF'},
            {label: '成約', yAxisID: 'Number', data: this.data.map(x => x.contract), fill: false, backgroundColor: 'red', borderColor: 'red'},
            {label: 'ブロック', yAxisID: 'Number', data: this.data.map(x => x.block), fill: false, backgroundColor: 'black', borderColor: 'black'},
            {label: 'ブロック率', yAxisID: 'Percent', data: this.data.map(x => x.block_rate), fill: false, backgroundColor: 'grey', borderColor: 'grey'},
            {label: 'LINE登録', yAxisID: 'Number', data: this.data.map(x => x.line_register), fill: false, backgroundColor: '#00B593', borderColor: '#00B593'},
            {label: 'LINE承認', yAxisID: 'Number', data: this.data.map(x => x.line_accept), fill: false, backgroundColor: '#3100FF', borderColor: '#3100FF'},
            {label: 'LINE成約', yAxisID: 'Number', data: this.data.map(x => x.line_contract), fill: false, backgroundColor: '#55F774', borderColor: '#55F774'},
          ]
        }
        this.chartOption = {
          scales: {
            yAxes: [
              { id: 'Number', type: 'linear', position: 'left', },
              { id: 'Percent', type: 'linear', position: 'right', ticks: {suggestedMin: 0, suggestedMax: 100 }},
            ]
          },
          tooltips: {
            mode: 'index',
            intersect: false,
          },
          responsive: true,
          maintainAspectRatio: false
        }
      },
      last: (arr, index) => (arr === undefined || arr.length === 0 ? 0 : arr[arr.length-1][index]),
      diff(arr, index) {
        if (arr === undefined) return 0
        const length = arr.length
        if(length === 0) return 0
        if(length === 1) return arr[0][index]
        if(length > 1) return arr[length-1][index] - arr[length-2][index]
      }
    }
  }
</script>

<style scoped>
._lh-1 {
  line-height: 1;
}
</style>