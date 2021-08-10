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
<!--        <v-col cols="12">-->
<!--          <v-select-->
<!--            outlined dense hide-details-->
<!--            :items="['全体表示']"-->
<!--          />-->
<!--        </v-col>-->
        <v-col cols="12">
          <v-card>
            <v-card-subtitle>誘導数</v-card-subtitle>
            <v-card-text class="text-center font-weight-bold title">
              {{format(last(data.induction))}}
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12">
          <v-card>
            <v-card-subtitle>誘導率</v-card-subtitle>
            <v-card-text class="text-center font-weight-bold title">
              {{format(last(data.induction_rate),2)}}%
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-sheet>

    <v-sheet class="_lp-item_expand" v-if="expanded">
      <v-row>
        <v-col cols="4">
          <v-card>
            <v-card-subtitle>平均移行率</v-card-subtitle>
            <v-card-text class="text-center title font-weight-bold">
              {{format(last(data.average_induction_rate))}}
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
            <v-card-subtitle>最終残存率</v-card-subtitle>
            <v-card-text class="text-center title font-weight-bold">
              {{format(last(data.final_rate))}}
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
        datetime: {type: Array, default: []},
        induction: {type: Array, default: []},
        induction_rate: {type: Array, default: []},
        clicks: {type: Array, default: []},
        uniques: {type: Array, default: []},
        average_induction_rate:{type: Array, default: []},
        final_rate:{type: Array, default: []},
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
            {label: '視聴数',yAxisID: 'Number',data: this.data.induction,fill: false,backgroundColor: '#89DFFF',borderColor: '#89DFFF'},
            {label: '視聴率',yAxisID: 'Percent',data: this.data.induction_rate,fill: false,backgroundColor: '#FF8997',borderColor: '#FF8997'},
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