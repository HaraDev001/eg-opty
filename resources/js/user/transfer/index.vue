<template>
  <div class="page_wrap_vue pa-3 transfer-page">
    <v-card class="mx-auto">
      <v-card-title class="_header">
        <v-row>
          <v-col cols="12">
            <h2 class="d-inline mr-1">振込管理  -  手動報酬額一覧</h2>
          </v-col>
          <v-col cols="12">
            <v-btn class="float-left">今月振込予定DL</v-btn>
            <v-select
              label="月選択"
              :items="month_filter" item-value="value" item-text="label"
              v-model="sel_month"
              outlined dense hide-details
              class="_filter"
            />
            <v-select
              label="キャンペーン選択"
              :items="camp_filter" item-value="value" item-text="label"
              v-model="sel_camp"
              outlined dense hide-details
              class="_filter mr-2"
            />
            <v-select
              label="ASP選択"
              :items="asp_filter" item-value="value" item-text="label"
              v-model="sel_asp"
              outlined dense hide-details
              class="_filter mr-2"
            />
          </v-col>
        </v-row>
      </v-card-title>
      <v-divider/>
      <v-card-text>
        <v-row>
          <v-col cols="12" class="d-flex justify-space-between">
            <v-card class="_top-card">
              <v-card-subtitle>
                <label class="_underbar">支払</label>件数
              </v-card-subtitle>
              <v-card-text class="headline text-center align-center">
                {{format(count)}}
              </v-card-text>
            </v-card>
            <v-card class="_top-card">
              <v-card-subtitle>
                <label class="_underbar">支払</label>金額
              </v-card-subtitle>
              <v-card-text class="headline text-center align-center">
                {{format(amount)}}
              </v-card-text>
            </v-card>
            <v-card class="_top-card">
              <v-card-subtitle>
                <label class="_underbar">承認</label>金額/支払い金額
              </v-card-subtitle>
              <v-card-text class="title text-center align-center">
                {{format(accept_amount)}}<br/>{{format(pay_amount)}}
              </v-card-text>
            </v-card>
            <v-card class="_top-card">
              <v-card-subtitle>
                <label class="_underbar">平均</label>支払金額
              </v-card-subtitle>
              <v-card-text class="headline text-center align-center">
                {{format(avg_amount)}}
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-text class="d-flex justify-end">
      </v-card-text>
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
              <th>備考</th>
              <th> </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
              <td>{{item.id}}</td>
              <td>{{item.asp_name}}</td>
              <td>{{item.campaign_name}}</td>
              <td>{{$date(item.created_at).format('YYYY/MM/DD HH:mm')}}</td>
              <td>{{$date(item.pay_at).format('YYYY/MM/DD HH:mm')}}</td>
              <td>{{format(item.amount)}}円</td>
              <td>{{item.note}}</td>
              <td>
                <v-btn color="purple" dark :to="`/user/transfer/show?id=${item.id}`">
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
        count: 0,
        amount: 0,
        accept_amount: 0,
        pay_amount: 0,
        avg_amount: 0,
      }
    },
    computed: {
    },
    mounted() {
      this.count = 1300
      this.amount = 1530000
      this.accept_amount = 100000
      this.pay_amount = 77000
      this.avg_amount = 1530
      this.all_items = [
        {id: 1, created_at: '2020/01/01', pay_at: '2020/01/01', asp_id: 1, asp_name: 'asp1', camp_id: 1, campaign_name: 'campaign1', amount: 1000, note: ''},
        {id: 2, created_at: '2020/01/01', pay_at: '2020/01/01', asp_id: 2, asp_name: 'asp2', camp_id: 2, campaign_name: 'campaign2', amount: 1000, note: ''},
        {id: 3, created_at: '2020/01/01', pay_at: '2020/01/01', asp_id: 2, asp_name: 'asp2', camp_id: 3, campaign_name: 'campaign3', amount: 1000, note: ''},
        {id: 4, created_at: '2020/01/01', pay_at: '2020/01/01', asp_id: 3, asp_name: 'asp3', camp_id: 4, campaign_name: 'campaign4', amount: 1000, note: ''},
        {id: 5, created_at: '2020/01/01', pay_at: '2020/01/01', asp_id: 1, asp_name: 'asp1', camp_id: 5, campaign_name: 'campaign5', amount: 1000, note: ''},
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
    float: right;
  }
</style>