<template>
  <v-card>
    <v-card-title>
      <v-col cols="12">
        <label class="title">ランク別分析</label>
        <br/>
        <v-btn outlined @click="$emit('onExpand', 1)">詳細</v-btn>
      </v-col>
    </v-card-title>
    <v-card-text>
        <v-row>
        <v-col cols="6" xs="12">
          <donut-chart :chart-data="chartData" :options="chartOption"/>
        </v-col>
        <v-col cols="6" xs="12">
          <v-row>
            <v-col cols="6" v-for="(d, i) in items" :key="i">
              <v-row>
                <v-col cols="12" class="py-0">
                  <div class="_rank-mark" :style="styles[i]"></div>
                  &nbsp;{{labels[i]}}
                </v-col>
                <v-col cols="12" class="py-0">{{d.register}}名 / {{format(percents[i], 2)}}%</v-col>
                <v-col cols="12" class="py-0">成約 {{format(d.contract)}}件</v-col>
              </v-row>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>

<script>
  import DonutChart from "../../../common/DonutChart";

  export default {
    components: {DonutChart},
    props: {
      items: {
        type: Array,
        default: []
      }
    },
    data() {
      return {
        chartData: {},
        chartOption: {responsive: true, maintainAspectRatio: false},
        ranks: [ '','VIP','S VIP','SS VIP','QUEEN','KING'],
        colors: ['', '#A3A3A3', '#073B4C', '#A166DD', '#FF7272', '#89DFFF'],
        total: 0,
        labels: [],
        styles: [],
        percents: [],
      }
    },
    mounted() {
      this.loadGraph()
    },
    watch: {
      items(val) {
        if(val.length === 0 ) return
        this.total = 0
        val.forEach(d => {this.total += d.contract})
        this.percents = val.map(d => this.total === 0 ? 0 : d.register * 100 / this.total)
        this.labels = val.map(d => this.ranks[d.rank])
        this.styles = val.map(d => `background-color:${this.colors[d.rank]}`)
        this.loadGraph()
      }
    },
    methods: {
      format(val, digs=0) {
        return val.toFixed(digs).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
      },

      loadGraph() {
        this.chartData = []
        this.percents = []
        this.total = 0
        this.items.forEach(d => this.total += d.register)
        const cdata = []
        const bgcolors = []
        this.items.forEach(d => {
          this.percents.push(this.total === 0 ? 0 : d.register * 100 / this.total)
          cdata.push(d.register)
          bgcolors.push(this.colors[d.rank])
        })
        this.chartData = {labels: this.labels, datasets: [{data:cdata, backgroundColor: bgcolors}]}
      },
    }
  }
</script>

<style scoped>
._rank-mark {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  display: inline-block;
}
</style>