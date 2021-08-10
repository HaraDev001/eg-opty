<template>
  <v-sheet class="_lp-item" elevation="3">
    <v-sheet class="_lp-item_main">
      <v-btn
        absolute dark fab small
        color="pink"
        class="_lp-item_main_float"
        @click="expanded=!expanded"
      >
        <v-icon>{{expanded ? 'mdi-chevron-left':'mdi-chevron-right'}}</v-icon>
      </v-btn>
      <v-row>
        <v-col cols="12">
          <v-img :src="data.image" class="_lp-item_main_banner" contain/>
        </v-col>
        <v-col cols="12">
          <h4>{{data.name}} {{data.title}}</h4>
        </v-col>
        <v-col cols="12">
          <v-select
            outlined dense hide-details
            :items="['日間チャート']"
          />
        </v-col>
        <v-col cols="12">
          <v-select
            outlined dense hide-details
            :items="['全体表示']"
          />
        </v-col>
        <v-col cols="12">
          <v-card>
            <v-card-subtitle>経費</v-card-subtitle>
            <v-card-text class="text-center font-weight-bold title">
              {{format(data.expense)}}
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12">
          <v-card>
            <v-card-subtitle>成約数 / 率</v-card-subtitle>
            <v-card-text class="text-center font-weight-bold title">
              {{format(last(data.contract))}}/{{format(last(data.contract_rate),2)}}%
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-sheet>

    <v-sheet class="_lp-item_expand" v-if="expanded">
      <v-row>
        <v-col cols="4">
          <v-card>
            <v-card-subtitle>稼働アフィリエイター数</v-card-subtitle>
            <v-card-text class="text-center title font-weight-bold">
              {{format(last(data.workings))}}
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="4">
          <v-card>
            <v-card-subtitle>クリック数 / ユニーク数</v-card-subtitle>
            <v-card-text class="text-center title font-weight-bold">
              {{format(last(data.clicks))}}
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="4">
          <v-card>
            <v-card-subtitle>クリック単価 / 平均単価</v-card-subtitle>
            <v-card-text class="text-center title font-weight-bold">
              {{format(last(data.click_unit))}}
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12">
          <line-chart :chart-data="chartData" :options="chartOption" class="_lp-item_expand_chart"/>
        </v-col>
      </v-row>
    </v-sheet>
  </v-sheet>
</template>

<script>
  import LineChart from "../../common/LineChart";
  export default {
    name: "LpItem",
    components: {LineChart},
    props: {
      data: {
        type:Object,
        id: {type: Number, default: 0},
        image: {type: String, default: ''},
        name: {type: String, default: ''},
        title: {type: String, default: ''},
        expense: {type: Number, default: 0},
        datetime: {type: Array, default: []},
        contract: {type: Array, default: []},
        contract_rate: {type: Array, default: []},
        workings: {type: Array, default: []},
        clicks: {type: Array, default: []},
        uniques: {type: Array, default: []},
        click_unit: {type: Array, default: []},
        average_unit: {type: Array, default: []},
      }
    },
    data() {
      return {
        expanded: false,
        chartData: {},
        chartOption: {
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
          labels: this.data.datetime,
          datasets: [
            {label: '稼働アフィリエイター数',yAxisID: 'Number',data: this.data.workings,fill: false,backgroundColor: 'grey',borderColor: 'grey'},
            {label: 'クリック数',yAxisID: 'Number',data: this.data.clicks,fill: false,backgroundColor: '#2DF96C',borderColor: '#2DF96C'},
            {label: '成約数',yAxisID: 'Number',data: this.data.contract,fill: false,backgroundColor: 'red',borderColor: 'red'},
            {label: 'ユニーク数',yAxisID: 'Number',data: this.data.uniques,fill: false,backgroundColor: '#007DAC',borderColor: '#007DAC'},
            {label: '成約率',yAxisID: 'Percent',data: this.data.contract_rate,fill: false,backgroundColor: 'pink',borderColor: 'pink'},
          ]
        }
      },
      format(val, digs=0) {
        return val.toFixed(digs).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
      },
      last(arr) {
        if(arr === undefined || arr.length === 0) return 0
        return arr[arr.length-1]
      }
    }
  }
</script>

<style scoped lang="scss">
._lp-item {
  margin-right: 10px;
  /*width: 1000px;*/
  height: 650px;
  display: flex;

  &_main {
    padding: 15px;
    border: 1px solid #eee;
    width: 350px;
    display: inline-flex;
    /*justify-content: center;*/
    position: relative;

    &_float {
      right: -20px;
      top: 46.5%;
    }

    &_banner {
      display: flex;
      width: 320px;
      height: 180px;
      margin: 0 auto;
    }
  }
  &_expand {
    height: 650px;
    width: 650px;
    display: block;
    padding: 15px;
    border: 1px solid #eee;
    &_chart {
      /*height: 300px;*/
    }
  }
}
</style>