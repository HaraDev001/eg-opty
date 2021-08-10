<template>
  <v-card>
    <v-container fluid>
      <v-card-title>
        <v-row>
          <v-col cols="12" class="">
            <v-btn dark color="info" @click="show_new_dlg=true">新規</v-btn>
          </v-col>
        </v-row>
      </v-card-title>

      <v-card-text>
        <v-row>
          <v-col>
            <v-simple-table>
              <thead>
                <tr>
                  <th>RANK</th>
                  <th>期間</th>
                  <th>基本報酬額</th>
                  <th>表示の有無</th>
                  <th> </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(r, i) in items" :key="i">
                  <td>{{r.rank.name}}</td>
                  <td>
                    {{$date(r.date_start + ' ' + r.time_start).format('YYYY/MM/DD HH:mm')}}から
                    {{$date(r.date_end + ' ' + r.time_end).format('YYYY/MM/DD HH:mm')}}まで
                  </td>
                  <td>{{r.amount}}円 / 成約</td>
                  <td>{{r.is_show === 1 ? 'する' : 'しない'}}</td>
                  <td>
                    <v-btn dark color="purple darken--2" @click="showDetail(r)">
                      詳細
                    </v-btn>
                    <v-btn dark color="pink darken--2" @click="showDelete(r)">
                      削除
                    </v-btn>
                  </td>
                </tr>
              </tbody>
            </v-simple-table>
          </v-col>
        </v-row>
      </v-card-text>
    </v-container>
    <add-main-reward :campaign_id="campaign_id" :ranks="ranks" :show="show_new_dlg"
                     @onNewClose="show_new_dlg=false"
                     @onNewReward="saveNewReward"/>
    <DetailRewardDlg :show="show_detail_dlg" :item="selected"
                     @onDetailClose="show_detail_dlg=false"/>
    <DeleteRewardDlg :show="show_delete_dlg" :item="selected"
                     @onDeleteYes="deleteReward"
                     @onDeleteClose="show_delete_dlg=false"/>

  </v-card>
</template>

<script>
  import AddMainReward from "./AddMainRewardDlg";
  import DetailRewardDlg from "./DetailRewardDlg";
  import DeleteRewardDlg from "./DeleteRewardDlg"
  // import vuetifyToast from 'vuetify-toast'

  export default {
    components: {AddMainReward, DetailRewardDlg, DeleteRewardDlg},
    props: {
      campaign_id: {type: Number, default: 0}
    },
    data : vm => ({
      selected: {id: 0, campaign_id: 0, rank_id: 0, rank:{name:''}, date_start: '', time_start: '', date_end: '', time_end: '', is_show: 1},
      show_new_dlg: false,
      show_delete_dlg: false,
      show_detail_dlg: false,
      ranks: [],
      items: []
    }),
    mounted() {
      axios.get(`/admin/campaign/main-rewards/list/${this.campaign_id}`)
      .then(res => {
        this.items = res.data.rewards
        this.ranks = res.data.ranks
      })
      .catch(e => {
        vuetifyToast.error('サーバーから基本報酬を取得できません。')
      })
    },
    methods: {
      deleteReward(item) {
        axios.get(`/admin/campaign/main-rewards/delete/${item.id}`)
          .then(res => {
            this.show_delete_dlg = false
            this.items = this.items.filter(v => v.id !== item.id)
          })
          .catch(e => {
            vuetifyToast.error('報酬を削除できません。')
          })
      },
      showDetail(item) {
        this.selected = item
        this.show_detail_dlg = true
      },
      showDelete(item) {
        this.selected = item
        this.show_delete_dlg = true
      },
      saveNewReward(val) {
        val.campaign_id = this.campaign_id
        axios.post(`/admin/campaign/main-rewards/new`, val)
        .then(res => {
          this.items = res.data.rewards

        })
        .catch(e => {
          vuetifyToast.error('新しい報酬を保存できません。')
        })
        this.show_new_dlg = false
      }
    }
  }
</script>

<style scoped>

</style>