<template>
  <v-card>
    <v-container fluid>
      <v-card-title>
        <v-row>
          <v-col cols="12" class="d-flex justify-space-between">
            <v-btn dark color="success" @click="show_new_dlg=true">新規</v-btn>
            <v-btn dark color="warning" @click="show_bulk_edit_dlg=true">一括編集</v-btn>
          </v-col>
        </v-row>
      </v-card-title>

      <v-card-text>
        <v-row>
          <v-col>
            <v-simple-table>
              <thead>
                <tr>
                  <th> </th>
                  <th>ID</th>
                  <th>アフィリエイター名</th>
                  <th>RANK</th>
                  <th>増加報酬額</th>
                  <th>表示の有無</th>
                  <th> </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(r, i) in items" :key="i">
                  <td><v-checkbox v-model="r.checked"/></td>
                  <td>{{r.id}}</td>
                  <td>{{r.affiliate.name_full}}</td>
                  <td>{{r.rank.name}}</td>
                  <td>{{r.amount}}円 / 成約</td>
                  <td>{{r.is_show === 1 ? 'する' : 'しない'}}</td>
                  <td>
                    <v-btn dark color="purple darken--2" @click="showDetail(r)">
                      詳細
                    </v-btn>
                    <v-btn dark color="error" @click="showDelete(r)">
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

    <new-special-reward-dlg
      :show="show_new_dlg"
      :ranks="ranks" :affiliates="affiliates"
      @onNewClose="show_new_dlg=false"
      @onNewReward="saveNewReward"/>
    <delete-reward-dlg
      :item="selected"
      :show="show_delete_dlg"
      @onDeleteClose="show_delete_dlg=false"
      @onDeleteYes="deleteReward"/>
    <detail-reward-dlg
      :item="selected"
      :show="show_detail_dlg"
      @onDetailClose="show_detail_dlg=false"/>
    <bulk-edit-reward-dlg
      :show="show_bulk_edit_dlg"
      @onEditClose="show_bulk_edit_dlg=false"
      @onEdited="saveEdited"/>
  </v-card>
</template>

<script>

  import NewSpecialRewardDlg from "./NewSpecialRewardDlg";
  import DeleteRewardDlg from "./DeleteRewardDlg";
  import DetailRewardDlg from "./DetailRewardDlg";
  import BulkEditRewardDlg from "./BulkEditRewardDlg";
  import vuetifyToast from 'vuetify-toast'

  export default {
    name: "SettingStory",
    components: {BulkEditRewardDlg, DetailRewardDlg, DeleteRewardDlg, NewSpecialRewardDlg},
    props: {
      campaign_id: {type: Number, default: 0}
    },
    data: () => ({
      show_new_dlg: false,
      show_detail_dlg: false,
      show_delete_dlg: false,
      show_bulk_edit_dlg: false,
      selected: {id: 0, campaign_id: 0, affiliate_id: 0, affiliate: {name:''}, rank_id: 0, rank:{name:''}, date_start: '', time_start: '', date_end: '', time_end: '', is_show: 1},
      bulks: [],
      ranks: [],
      items: [],
      affiliates: []
    }),
    mounted() {
      axios.get(`/admin/campaign/increased-reward/list/${this.campaign_id}`)
      .then(res => {
        this.items = res.data.rewards.map(r => {
          r.checked = false
          return r
        })
        this.ranks = res.data.ranks
        this.affiliates = res.data.affiliates
      })
      .catch(e => {
        vuetifyToast.error('サーバーから特別報酬リストを読み込めません。')
      })
    },
    methods: {
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
        axios.post(`/admin/campaign/increased-reward/new`, val)
          .then(res => {
            this.items = res.data.rewards
          })
          .catch(e => {
            vuetifyToast.error('新しい報酬を保存できません。')
          })
        this.show_new_dlg = false
      },
      deleteReward(val) {
        axios.get(`/admin/campaign/increased-reward/delete/${val.id}`)
          .then(res => {
            this.items = this.items.filter(v => v.id !== val.id)
          })
          .catch(e => {
            vuetifyToast.error('新しい報酬を保存できません。')
          })
        this.show_delete_dlg = false
      },
      saveEdited(val) {
        this.show_bulk_edit_dlg = false
        const selectIds = []
        this.items.forEach(v => {
          if(v.checked) selectIds.push(v.id)
        })
        if(selectIds.length === 0) return

        val.campaign_id = this.campaign_id
        val.ids = selectIds
        axios.post('/admin/campaign/increased-reward/bulk-edit', val)
        .then(res => {
          this.items = res.data.rewards.map(r => {
            r.checked = false
            return r
          })
        })
        .catch(e => {
          vuetifyToast.error('選択した特典は変更できませんでした。')
        })
      }
    }
  }
</script>

<style scoped>

</style>