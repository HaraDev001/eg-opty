<template>
  <div class="page_wrap_vue pa-3 contract-page">
    <v-card class="mx-auto">
      <v-card-title class="_header">
        <v-container fluid>
          <v-row>
            <v-col>
              <h2 class="d-inline mr-1">成約管理一覧</h2>
            </v-col>
          </v-row>
        </v-container>
      </v-card-title>
      <v-divider/>
      <v-card-text>
        <v-row>
          <v-col cols="12" class="d-flex justify-space-between">
            <v-card class="_top-card">
              <v-card-subtitle>
                <label class="_underbar">総ア</label>クセス数
              </v-card-subtitle>
              <v-card-text class="headline text-center align-center">
                {{format(access)}}
              </v-card-text>
            </v-card>
            <v-card class="_top-card">
              <v-card-subtitle>
                <label class="_underbar">成約</label>件数
              </v-card-subtitle>
              <v-card-text class="headline text-center align-center">
                {{format(contract)}}/{{format(contract_rate,2)}}%
              </v-card-text>
            </v-card>
            <v-card class="_top-card">
              <v-card-subtitle>
                <label class="_underbar">承認</label>件数
              </v-card-subtitle>
              <v-card-text class="headline text-center align-center">
                {{format(accept)}}/{{format(accept_rate, 2)}}%
              </v-card-text>
            </v-card>
            <v-card class="_top-card">
              <v-card-subtitle>
                <label class="_underbar">成約</label>金額/承認金額
              </v-card-subtitle>
              <v-card-text class="title text-center align-center">
                {{format(contract_amount)}}<br/>{{format(accept_amount)}}
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-text class="d-flex justify-end">
        <v-select
          label="ASP選択"
          :items="asp_filter" item-value="value" item-text="label"
          v-model="sel_asp"
          outlined dense hide-details
          class="_filter mr-2"
        />
        <v-select
          label="キャンペーン選択"
          :items="camp_filter" item-value="value" item-text="label"
          v-model="sel_camp"
          outlined dense hide-details
          class="_filter mr-2"
        />
        <v-select
          label="月選択"
          :items="month_filter" item-value="value" item-text="label"
          v-model="sel_month"
          outlined dense hide-details
          class="_filter"
        />
      </v-card-text>
      <v-card-text class="_content">
        <v-simple-table>
          <template v-slot:default>
            <thead>
            <tr>
              <th>開催日</th>
              <th>ASP名</th>
              <th>キャンペーン名</th>
              <th>成約件数</th>
              <th>承認数</th>
              <th>支払予定額</th>
              <th>平均LP登録率</th>
              <th>平均獲得単価</th>
              <th> </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
              <td>{{item.date_start}}</td>
              <td>{{item.asp_name}}</td>
              <td>{{item.campaign_name}}</td>
              <td>{{format(item.contract)}}件</td>
              <td>{{format(item.accept)}}件</td>
              <td>{{format(item.reward_estimate)}}円</td>
              <td>{{format(item.avg_lp_reg_rate,2)}}%</td>
              <td>{{format(item.avg_unit_price)}}円</td>
              <td>
                <v-btn color="purple" dark :to="`/user/contract/show?id=${item.id}`">
                  詳細
                </v-btn>
              </td>
            </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-card-text>
    </v-card>

  </div>
</template>

<script>
  export default {
    data() {
      return {
        filters: [],
        items: [],
        all_items: [],
        asp_filter: [{value:0, label:''},{value:1, label:'Asp1'},{value:2, label:'Asp2'},{value:3, label:'Asp3'}],
        camp_filter: [{value:0, label:''},{value:1, label:'Camp1'},{value:2, label:'Camp2'},{value:3, label:'Camp3'}],
        month_filter: [{value:-1, label:''},{value:0, label:'Jan'},{value:1, label:'Feb'},{value:2, label:'Mar'},{value:3, label:'Apr'},{value:4, label:'May'},{value:5, label:'Jun'},{value:6, label:'Jul'},{value:7, label:'Aug'},{value:8, label:'Sep'},{value:9, label:'Oct'},{value:10, label:'Nov'},{value:11, label:'Dec'}],
        sel_asp: 0,
        sel_camp: 0,
        sel_month: -1,
        access: 0,
        contract: 0,
        accept: 0,
        contract_amount: 0,
        accept_amount: 0
      }
    },
    computed: {
      contract_rate() {
        return this.access === 0 ? 0 : this.contract * 100 / this.access;
      },
      accept_rate() {
        return this.contract === 0 ? 0 : this.accept * 100 / this.contract;
      },
    },
    mounted() {
      this.access = 2100
      this.contract = 1500
      this.accept = 77
      this.contract_amount = 1530000
      this.accept_amount = 770000
      this.all_items = [
        {id: 1, date_start: '2020/01/01', asp_id: 1, asp_name: 'asp1', camp_id: 1, campaign_name: 'campaign1', contract: 1000, accept: 200, reward_estimate: 10000, avg_lp_reg_rate: 15, avg_unit_price: 1300},
        {id: 2, date_start: '2020/01/01', asp_id: 1, asp_name: 'asp1', camp_id: 2, campaign_name: 'campaign2', contract: 1000, accept: 200, reward_estimate: 10000, avg_lp_reg_rate: 15, avg_unit_price: 1300},
        {id: 3, date_start: '2020/01/01', asp_id: 2, asp_name: 'asp2', camp_id: 3, campaign_name: 'campaign3', contract: 1000, accept: 200, reward_estimate: 10000, avg_lp_reg_rate: 15, avg_unit_price: 1300},
        {id: 4, date_start: '2020/01/01', asp_id: 2, asp_name: 'asp2', camp_id: 4, campaign_name: 'campaign4', contract: 1000, accept: 200, reward_estimate: 10000, avg_lp_reg_rate: 15, avg_unit_price: 1300},
        {id: 5, date_start: '2020/01/01', asp_id: 3, asp_name: 'asp3', camp_id: 5, campaign_name: 'campaign5', contract: 1000, accept: 200, reward_estimate: 10000, avg_lp_reg_rate: 15, avg_unit_price: 1300},
      ]
      this.filter()
    },
    methods: {
      format(val,digs=0) {
        return val.toFixed(digs).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
      },
      filter() {
        this.items = this.all_items
        // asp filter
        if(this.sel_asp !== 0)
          this.items = this.items.filter(it => it.asp_id === this.sel_asp)
        // campaign filter
        if(this.sel_camp !== 0)
          this.items = this.items.filter(it => it.camp_id === this.sel_camp)
        // month filter
        if(this.sel_month !== -1)
          this.items = this.items.filter(it => this.$date(it.date_start).month() === this.sel_month)
      }
    },
    watch: {
      sel_asp(val) {
        console.log(val)
        this.filter()
      },
      sel_camp(val) {
        console.log(val)
        this.filter()
      },
      sel_month(val) {
        console.log(val)
        this.filter()
      }
    }
  }
</script>
<style scoped lang="scss">
  ._underbar {
    border-bottom: 2px solid #83BEDF;
  }
  ._top-card {
    width: 20%;
    display: inline-block;
  }
  ._filter {
    flex: none;
  }
</style>