<template>
  <div class="page_wrap_vue pa-3 contract-page">
    <v-card class="mx-auto">
      <v-card-title class="_header">
        <v-container fluid>
          <v-row>
            <v-col>
              <h2 class="d-inline mr-1">振り込み管理　一覧</h2>
            </v-col>
          </v-row>
        </v-container>
      </v-card-title>
      <v-divider/>
      <v-card-text>
        <v-row>
          <v-col cols="12" class="d-flex justify-end">
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
          </v-col>
          <v-col cols="12">
            <v-simple-table>
              <thead>
              <tr>
                <th>ID</th>
                <th>ASP名</th>
                <th>キャンペーン名</th>
                <th>承認件数</th>
                <th>報酬支払日</th>
                <th>合計金額</th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td>{{id}}</td>
                <td>{{asp_name}}</td>
                <td>{{campaign_name}}</td>
                <td>{{format(accept_count)}}</td>
                <td>{{$date(pay_at).format('YYYY/MM/DD HH:mm')}}</td>
                <td>{{format(total)}}円</td>
              </tr>
              </tbody>
            </v-simple-table>
          </v-col>
        </v-row>
      </v-card-text>
      <v-divider/>
      <v-card-text class="_content">
        <v-simple-table>
          <template v-slot:default>
            <thead>
            <tr>
              <th>ID</th>
              <th>ASP名</th>
              <th>キャンペーン名</th>
              <th>報酬発生日</th>
              <th>報酬支払日</th>
              <th>報酬金額</th>
              <th>件数</th>
              <th>備考</th>
              <th> </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
              <td>{{item.id}}</td>
              <td>{{item.asp_name}}</td>
              <td>{{item.campaign_name}}</td>
              <td>{{$date(item.create_at).format('YYYY/MM/DD HH:mm')}}</td>
              <td>{{$date(item.pay_at).format('YYYY/MM/DD HH:mm')}}</td>
              <td>{{format(item.amount)}}円</td>
              <td>{{format(item.count)}}</td>
              <td>{{item.note}}</td>
              <td>
                <v-btn color="purple" dark to="">
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
        id: 12345,
        accept_count: 2300,
        pay_at: '2020-04-05 12:34:44',
        total: 123456,
        asp_name: 'Asp',
        campaign_name: 'campaign',
      }
    },
    computed: {
    },
    mounted() {
      this.all_items = [
        // id asp_name campaign_name reward_create_at reward_pay_at reward_amount reward_count reward_status
        {id: 1, asp_name: 'asp1', campaign_name: 'campaign1', create_at:'2020-01-01 12:00', pay_at:'2020-01-05 12:00', amount:10000,count:1,note:''},
        {id: 2, asp_name: 'asp1', campaign_name: 'campaign1', create_at:'2020-01-01 12:00', pay_at:'2020-01-05 12:00', amount:10000,count:1,note:''},
        {id: 3, asp_name: 'asp1', campaign_name: 'campaign1', create_at:'2020-01-01 12:00', pay_at:'2020-01-05 12:00', amount:10000,count:1,note:''},
        {id: 4, asp_name: 'asp1', campaign_name: 'campaign1', create_at:'2020-01-01 12:00', pay_at:'2020-01-05 12:00', amount:10000,count:1,note:''},
        {id: 5, asp_name: 'asp1', campaign_name: 'campaign1', create_at:'2020-01-01 12:00', pay_at:'2020-01-05 12:00', amount:10000,count:1,note:''},
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
  ._underbar::after {
    content: " ";
    width: 30px;
    color: #83BEDF;
  }
  ._top-card {
    width: 20%;
    display: inline-block;
  }
  ._filter {
    flex: none;
  }
</style>