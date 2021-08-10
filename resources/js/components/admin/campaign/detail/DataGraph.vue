<template>
  <v-card>
    <v-card-title>
      <v-col cols="3">
        <label class="title">データ推移</label>
        <br/>
        <v-btn outlined @click="$emit('onExpand', 0)">詳細</v-btn>
      </v-col>
      <v-col cols="3" class="text-center">
        <p class="purple--text subtitle-1 mb-1">アクセス</p>
        <p class="purple--text title font-weight-bold mb-1">{{total(data.access)}}</p>
        <p class="subtitle-1 mb-1">前日比 {{diff(data.access)}}</p>
      </v-col>
      <v-col cols="3" class="text-center">
        <p class="light-blue--text subtitle-1 mb-1">登録</p>
        <p class="light-blue--text title font-weight-bold mb-1">{{total(data.register)}}</p>
        <p class="subtitle-1 mb-1">前日比 {{diff(data.register)}}</p>
      </v-col>
      <v-col cols="3" class="text-center">
        <p class="red--text subtitle-1 mb-1">成約</p>
        <p class="red--text title font-weight-bold mb-1">{{total(data.contract)}}</p>
        <p class="subtitle-1 mb-1">前日比 {{diff(data.contract)}}</p>
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
      data: {
        type: Object,
        access: {type: Array, default: []},
        register: {type: Array, default: []},
        contract: {type: Array, default: []},
      }
    },
    data() {
      return {
        chartData: {},
        chartOption: {
          scales: {
            yAxes: [
              { id: 'Access', type: 'linear', position: 'left', },
              { id: 'Register', type: 'linear', position: 'left',},
              { id: 'Contract', type: 'linear', position: 'left',},
            ]
          },
          responsive: true,
          maintainAspectRatio: false
        }
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
          labels: this.data.access.map(x => x.date),
          datasets: [
            {label: 'アクセス', yAxisID: 'Access', data: this.data.access.map(x => x.value), fill: false, backgroundColor: 'purple', borderColor: 'purple'},
            {label: '新規登録', yAxisID: 'Register', data: this.data.register.map(x => x.value), fill: false, backgroundColor: '#6AD7FF', borderColor: '#6AD7FF'},
            {label: '新規成約', yAxisID: 'Contract', data: this.data.contract.map(x => x.value), fill: false, backgroundColor: 'red', borderColor: 'red'},
          ]
        }
      },
      total(arr) {
        let sum = 0
        arr.forEach(a => { sum += a.value})
        return sum
      } ,
      diff(arr) {
        const length = arr.length
        if(length === 0) return 0
        if(length === 1) return arr[0].value
        if(length > 1) return arr[length-1].value - arr[length-2].value
      }
    }
  }
</script>

<style scoped>

</style>