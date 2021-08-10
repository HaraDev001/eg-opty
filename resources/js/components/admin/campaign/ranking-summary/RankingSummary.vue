<template>
  <v-card class="ranking-summary">
    <v-container fluid>
      <v-card-title>
        <v-row>
          <v-col cols="12">
            <h3>ランキング集計</h3>
          </v-col>
        </v-row>
      </v-card-title>
      <v-divider/>
      <v-card-text>
        <v-row>
          <v-col class="text-center">集計期間入力</v-col>
        </v-row>
        <v-row>
          <v-col class="d-flex justify-center align-center">
            <v-text-field
              type="date"
              v-model="start_date"
              outlined dense hide-details
              prepend-inner-icon="mdi-calendar"
              class="_date mr-2"
            />
            <v-text-field
              type="time"
              v-model="start_time"
              outlined dense hide-details
              prepend-inner-icon="mdi-clock-outline"
              class="_time mr-2"
            />
            から
            <v-text-field
              type="date"
              v-model="end_date"
              outlined dense hide-details
              prepend-inner-icon="mdi-calendar"
              class="mx-2 _date"
            />
            <v-text-field
              type="time"
              v-model="end_time"
              outlined dense hide-details
              prepend-inner-icon="mdi-clock-outline"
              class="_time"
            />
          </v-col>
        </v-row>
        <v-row>
          <v-col class="d-flex justify-center">
            <v-btn
              dark
              color="success"
              @click="filter"
            >
              検索
            </v-btn>
          </v-col>
        </v-row>
        <v-divider/>
        <v-row class="_container">
          <v-col cols="12" class="d-flex justify-space-around">
            <strong>合計成約数 : {{contract_all}}件</strong>
            <strong>合計報酬額 : {{reward_all}}円</strong>
          </v-col>
          <v-col cols="12">
            <v-simple-table>
              <thead>
                <tr>
                  <th>アフィリエイター名</th>
                  <th>RANK</th>
                  <th>成約数</th>
                  <th>報酬額</th>
                  <th>ランキング</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(s, i) in items" :key="i">
                  <td>{{s.affiliate}}</td>
                  <td>{{ranks[s.rank-1]}}</td>
                  <td>{{s.contract_number}}</td>
                  <td>{{s.reward}}</td>
                  <td>{{s.ranking}}位</td>
                </tr>
              </tbody>
            </v-simple-table>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" class="d-flex justify-center">
            <v-btn @click="download">ダウンロード</v-btn>
          </v-col>
          <v-col cols="12" class="text-center">Tableタグ形式</v-col>
        </v-row>
      </v-card-text>
    </v-container>

  </v-card>
</template>

<script>
  export default {
    props: {
      items: {
        type: Array,
        default: () => []
      }
    },
    data: vm => ({
      ranks: ['VIP', 'S VIP', 'SS VIP', 'QUEEN', 'KING'],
      start_date: '',
      start_time: '',
      end_date: '',
      end_time: ''
    }),
    computed: {
      contract_all() {
        let s = 0
        this.items.forEach(i => { s += i.contract_number })
        return s
      },
      reward_all() {
        let s = 0
        this.items.forEach(i => {s += i.reward})
        return s
      }
    },
    methods: {
      filter() {

      },
      download() {

      }
    }
  }
</script>

<style scoped>
  ._date {
    width: 200px;
    flex: none;
    display:inline-flex;
  }
  ._time {
    width: 150px;
    flex: none;
    display:inline-flex;
  }
</style>