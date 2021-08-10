<template>
  <v-container fluid>
    <top-panel :data="data_top" :campaigns="campaigns" :camp_id="campId" @changeCampaign="onChangeCampaign"/>
    <section v-if="compact">
      <v-row>
        <v-col cols="6" xs="12">
          <data-graph :data="data_data" @onExpand="onExpand"/>
        </v-col>
        <v-col cols="6" xs="12">
          <rank-graph :items="data_rank" @onExpand="onExpand"/>
        </v-col>
        <v-col cols="6" xs="12">
          <lp-graph :data="data_lp" @onExpand="onExpand"/>
        </v-col>
        <v-col cols="6" xs="12">
          <affiliate-graph :data="data_affiliate" @onExpand="onExpand"/>
        </v-col>
      </v-row>
    </section>
    <section v-else>
      <v-expansion-panels v-model="kind">
        <v-expansion-panel>
          <v-expansion-panel-header>データ推移</v-expansion-panel-header>
          <v-expansion-panel-content>
            <data-detail-graph :data="detail_data" @onShrink="onShrink"/>
          </v-expansion-panel-content>
        </v-expansion-panel>
<!--        <v-expansion-panel>-->
<!--          <v-expansion-panel-header>ランク別分析</v-expansion-panel-header>-->
<!--          <v-expansion-panel-content>-->
<!--            <rank-detail-graph :data="detail_rank" @onShrink="onShrink"/>-->
<!--          </v-expansion-panel-content>-->
<!--        </v-expansion-panel>-->
        <v-expansion-panel>
          <v-expansion-panel-header>LP分析</v-expansion-panel-header>
          <v-expansion-panel-content>
            <lp-detail-graph :items="detail_lp" @onShrink="onShrink"/>
          </v-expansion-panel-content>
        </v-expansion-panel>
        <v-expansion-panel>
          <v-expansion-panel-header>WP分析</v-expansion-panel-header>
          <v-expansion-panel-content>
            <wp-detail-graph :items="detail_lp" @onShrink="onShrink"/>
          </v-expansion-panel-content>
        </v-expansion-panel>
        <v-expansion-panel>
          <v-expansion-panel-header>アフィリエイター分析</v-expansion-panel-header>
          <v-expansion-panel-content>
            <affiliate-detail-graph :data="detail_affiliate" @onShrink="onShrink"/>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </section>
  </v-container>
</template>

<script>
  import TopPanel from "../../components/user/dashboard/TopPanel";
  import DataGraph from "../../components/user/dashboard/DataGraph";
  import DataDetailGraph from "../../components/user/dashboard/DataDetailGraph";
  import AffiliateGraph from "../../components/user/dashboard/AffiliateGraph";
  import AffiliateDetailGraph from "../../components/user/dashboard/AffiliateDetailGraph";
  import LpGraph from "../../components/user/dashboard/LpGraph";
  import LpDetailGraph from "../../components/user/dashboard/LpDetailGraph";
  import WpDetailGraph from "../../components/user/dashboard/WpDetailGraph";
  import RankGraph from "../../components/user/dashboard/RankGraph";
  import RankDetailGraph from "../../components/user/dashboard/RankDetailGraph";

  export default {
    components: {TopPanel, DataGraph, DataDetailGraph, AffiliateGraph, AffiliateDetailGraph, LpGraph, LpDetailGraph, WpDetailGraph, RankGraph, RankDetailGraph},
    data() {
      return {
        campId: 1,
        compact: true, // compact or expand
        kind: 0,
        data_top: {rank:'SVIP',clicks:1500,contract_number:75,contract_rate:75*100/1500, contract_amount: 10000, accept_amount:1000, reward_unit: 1300,},
        campaigns: [],
        data_data: {access: [], register: [], contract: []},
        data_rank: [],
        data_lp: [],
        data_affiliate: [],
        detail_data: [],
        detail_rank: [],
        detail_lp: [],
        detail_wp: [],
        detail_affiliate: []
      }
    },
    mounted() {
      this.loadData(this.campId)
    },
    methods: {
      onExpand(val) {
        this.compact = false
        this.kind = val
      },
      onShrink(val) {
        this.compact = true
        this.kind = val
      },
      loadData(campId) {
        this.data_top = {application_number: 11111, contract_amount: 22222222, application_unit_price: 33333, target_archive_rate: 88, target_amount: 20000000}
        this.campaigns = [
            {id: 1, name: 'campaign1'},
            {id: 2, name: 'campaign2'},
            {id: 3, name: 'campaign3'},
          ]
        this.data_data = {
            access: [
              {date: '2020-01-01', value: 2222},
              {date: '2020-01-02', value: 3333},
              {date: '2020-01-03', value: 1111},
            ],
            register: [
              {date: '2020-01-01', value: 111},
              {date: '2020-01-02', value: 333},
              {date: '2020-01-03', value: 444},
            ],
            contract: [
              {date: '2020-01-01', value: 11},
              {date: '2020-01-02', value: 33},
              {date: '2020-01-03', value: 22},
            ]
          }
        this.data_rank = [
            {rank: 1, register: 380, contract: 17608},
            {rank: 2, register: 150, contract: 24236},
            {rank: 3, register: 85, contract: 4840},
            {rank: 4, register: 23, contract: 7268},
            {rank: 5, register: 15, contract: 10902},
          ]
        this.data_lp = [
            {name: 'LP1', contract: 826, click: 5710},
            {name: 'LP2', contract: 692, click: 2319},
            {name: 'LP3', contract: 452, click: 2792},
            {name: 'LP4', contract: 420, click: 1805},
          ]
        this.data_affiliate = [
          {name: 'aff1', contract: 826, click: 5710},
          {name: 'aff2', contract: 692, click: 2319},
          {name: 'aff3', contract: 452, click: 2792},
          {name: 'aff4', contract: 420, click: 1805},
        ]
        this.detail_data = [
          {date: '2020-01-01', access: 3333, register: 248, contract:74, block: 81, block_rate: 8100/248, line_register: 2070, line_accept: 333, line_contract:50},
          {date: '2020-01-02', access: 3670, register: 280, contract:88, block: 99, block_rate: 9900/280, line_register: 2800, line_accept: 222, line_contract:88},
          {date: '2020-01-03', access: 2222, register: 333, contract:99, block: 44, block_rate: 4400/333, line_register: 1050, line_accept: 178, line_contract:77},
          {date: '2020-01-04', access: 3500, register: 111, contract:44, block: 11, block_rate: 10, line_register: 2222, line_accept: 250, line_contract:99},
          {date: '2020-01-05', access: 1111, register: 222, contract:55, block: 33, block_rate: 3300/222, line_register: 555, line_accept: 55, line_contract:33},
        ]
        this.detail_rank = [
          {rank: 5, access: 11111, register: 222, register_rate: 22200/11111, expense: 555555, workings: 30, contract_unit: 11111},
          {rank: 4, access: 11111, register: 222, register_rate: 22200/11111, expense: 555555, workings: 30, contract_unit: 11111},
          {rank: 3, access: 11111, register: 222, register_rate: 22200/11111, expense: 555555, workings: 30, contract_unit: 11111},
          {rank: 1, access: 11111, register: 222, register_rate: 22200/11111, expense: 555555, workings: 30, contract_unit: 11111},
        ]
        this.detail_lp = [
          {id:1,image:'/img/sample/buzz-andersen.png',name:'Lp1',title:'title1',expense:5555555,
            datetime:['00:00','06:00','12:00','18:00'],
            contract:[100,105, 120, 200],
            contract_rate:[15,20,18,33],
            workings:[10,20,30,40],
            clicks:[300,400,200,300],
            uniques:[200,300,100,200],
            click_unit:[50,70,60,40],
            average_unit:[1000,2000,1200,2200],
          },
          {id:2,image:'/img/sample/daniel-monteiro.png',name:'Lp2',title:'title2',expense:5555555,
            datetime:['00:00','06:00','12:00','18:00'],
            contract:[100,105, 120, 200],
            contract_rate:[15,20,18,33],
            workings:[10,20,30,40],
            clicks:[300,400,200,300],
            uniques:[200,300,100,200],
            click_unit:[50,70,60,40],
            average_unit:[1000,2000,1200,2200],
          },
          {id:3,image:'/img/sample/icons8-team.png',name:'Lp3',title:'title3',expense:5555555,
            datetime:['00:00','06:00','12:00','18:00'],
            contract:[100,105, 120, 200],
            contract_rate:[15,20,18,33],
            workings:[10,20,30,40],
            clicks:[300,400,200,300],
            uniques:[200,300,100,200],
            click_unit:[50,70,60,40],
            average_unit:[1000,2000,1200,2200],
          },
        ]
        this.detail_wp = [
          {id:1,image:'/img/sample/buzz-andersen.png',name:'Lp1',title:'title1',
            datetime:['00:00','06:00','12:00','18:00'],
            induction:[100,105, 120, 200],
            induction_rate:[15,20,18,33],
            average_induction_rate:[10,20,30,40],
            clicks:[300,400,200,300],
            uniques:[200,300,100,200],
            final_rate:[1000,2000,1200,2200],
          },
          {id:2,image:'/img/sample/daniel-monteiro.png',name:'Lp2',title:'title2',
            datetime:['00:00','06:00','12:00','18:00'],
            induction:[100,105, 120, 200],
            induction_rate:[15,20,18,33],
            average_induction_rate:[10,20,30,40],
            clicks:[300,400,200,300],
            uniques:[200,300,100,200],
            final_rate:[1000,2000,1200,2200],
          },
          {id:3,image:'/img/sample/icons8-team.png',name:'Lp3',title:'title3',
            datetime:['00:00','06:00','12:00','18:00'],
            induction:[100,105, 120, 200],
            induction_rate:[15,20,18,33],
            average_induction_rate:[10,20,30,40],
            clicks:[300,400,200,300],
            uniques:[200,300,100,200],
            final_rate:[1000,2000,1200,2200],
          },
        ]
        this.detail_affiliate = [
          {id:1,affiliate:'aff1',access:15100,contract:1000,contract_rate:30,accepts:1000,reward:500000,reward_unit:5000},
          {id:2,affiliate:'aff2',access:15100,contract:1000,contract_rate:30,accepts:1000,reward:500000,reward_unit:5000},
          {id:3,affiliate:'aff3',access:15100,contract:1000,contract_rate:30,accepts:1000,reward:500000,reward_unit:5000},
          {id:4,affiliate:'aff4',access:15100,contract:1000,contract_rate:30,accepts:1000,reward:500000,reward_unit:5000},
          {id:5,affiliate:'aff5',access:15100,contract:1000,contract_rate:30,accepts:1000,reward:500000,reward_unit:5000},
        ]
      },
      onChangeCampaign(val) {
        this.loadData(val)
      }
    }
  }
</script>

<style scoped>

</style>