<template>
  <v-card>
    <v-container fluid>
      <v-card-title>
        <v-row>
          <v-col cols="12">
            <h3>先行 / 延長設定</h3>
          </v-col>
        </v-row>
      </v-card-title>

      <v-card-text>
        <v-row>
          <v-col cols="12" class="d-flex justify-space-between">
            <v-btn color="info" @click="showNew">新規登録</v-btn>
            <label>キャンペーン期間&emsp;
              {{$date(campaign.date_start + ' ' + campaign.time_start).format('YYYY/MM/DD HH:mm')}} -
              {{$date(campaign.date_end + ' ' + campaign.time_end).format('YYYY/MM/DD HH:mm')}}
            </label>
          </v-col>
        </v-row>
        <v-divider/>
        <v-row>
          <v-col cols="12">
            <v-tabs v-model="tab">
              <v-tab key="lead">先行登録</v-tab>
              <v-tab key="extend">延長登録</v-tab>
            </v-tabs>
            <v-tabs-items v-model="tab">
              <v-tab-item key="lead">
                <v-simple-table>
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>アフィリエイター名</th>
                      <th>ランク</th>
                      <th>特別報酬額</th>
                      <th>開始 / 終了日時</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(v, i) in vleads" :key="i">
                      <th>{{v.id}}</th>
                      <th>{{v.affiliate_name}}</th>
                      <th>{{v.rank_name}}</th>
                      <th>{{v.affiliate.special_reward_amount}}</th>
                      <th>{{$date(v.date_start + ' ' + v.time_start).format('YYYY/MM/DD HH:mm')}} - </th>
                      <th>
<!--                        <v-btn-->
<!--                          dark color="purple darken&#45;&#45;2"-->
<!--                          @click="showEdit(v)"-->
<!--                        >-->
<!--                          編集-->
<!--                        </v-btn>-->
                        <v-btn
                          color="error"
                          @click="showDelete(v)"
                        >
                          削除
                        </v-btn>
                      </th>
                    </tr>
                  </tbody>
                </v-simple-table>
              </v-tab-item>
              <v-tab-item key="extend">
                <v-simple-table>
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>アフィリエイター名</th>
                    <th>ランク</th>
                    <th>特別報酬額</th>
                    <th>開始 / 終了日時</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="(v, i) in vextends" :key="i">
                    <th>{{v.id}}</th>
                    <th>{{v.affiliate_name}}</th>
                    <th>{{v.rank_name}}</th>
                    <th>{{v.affiliate.special_reward_amount}}</th>
                    <th>- {{$date(v.date_end + ' ' + v.time_end).format('YYYY/MM/DD HH:mm')}}</th>
                    <th>
<!--                      <v-btn-->
<!--                        dark color="purple darken&#45;&#45;2"-->
<!--                        @click="showEdit(v)"-->
<!--                      >-->
<!--                        編集-->
<!--                      </v-btn>-->
                      <v-btn
                        color="error"
                        @click="showDelete(v)"
                      >
                        削除
                      </v-btn>
                    </th>
                  </tr>
                  </tbody>
                </v-simple-table>
              </v-tab-item>
            </v-tabs-items>
          </v-col>
        </v-row>
      </v-card-text>
    </v-container>

    <NewDlg
      :show="show_new" :kind="tab" :affiliates="affiliates" :teams="teams" @onNewClose="show_new=false"
      @onNewSave="saveNew"/>
    <EditDlg
      :show="show_edit" :kind="tab" :item="selected" :affiliates="affiliates" :teams="teams"
      @onEditClose="show_edit=false"
      @onEditSave="saveEdit"/>
    <DeleteDlg
      :show="show_delete" :kind="tab" :item="selected"
      @onDeleteClose="show_delete=false"
      @onDeleteConfirm="deleted"/>
  </v-card>
</template>

<script>
  import NewDlg from "./NewDlg";
  import EditDlg from "./EditDlg";
  import DeleteDlg from "./DeleteDlg";
  import vuetifyToast from "vuetify-toast"

  export default {
    components: {NewDlg, DeleteDlg, EditDlg},
    props: {
      campaign_id: {type: Number, default: 0},
    },
    data: vm => ({
      campaign: {date_start:'', time_start:'', date_end:'', time_end:''},
      vleads: [],
      vextends: [],
      search_type: 'member',
      keyword: '',
      member_id: '',
      team_id: '',
      selected: {id: 0, affiliate_id: 0, campaign_is: 0, kind: '', date_start: '', time_start: '', date_end: '', time_end: '',},
      show_new: false,
      show_edit: false,
      show_delete: false,
      tab: 0,
      affiliates: [],
      teams: []
    }),
    mounted() {
      axios.get(`/admin/campaign/lead-extend/list/${this.campaign_id}`)
      .then(res => {
        this.campaign = res.data.campaign
        this.vleads = this.campaign.lead_extend_affiliates.filter(v => v.kind === 'lead')
        this.vextends = this.campaign.lead_extend_affiliates.filter(v => v.kind === 'extend')
        this.affiliates = res.data.affiliates.map(v => {v.id_name = v.id + ' ' + v.name_full; return v})
        this.teams = res.data.teams.map(v => {v.id_name = v.id + ' ' + v.name; return v})
      })
      .catch(e => {
        vuetifyToast.error('サーバーから先行/延長アフィリエイトリストを取得できません。')
      })
    },
    methods: {
      showNew() {
        this.show_new = true
      },
      showEdit(val) {
        this.selected = val
        this.show_edit = true
      },
      showDelete(val) {
        this.selected = val
        this.show_delete = true
      },
      saveNew(item) {
        this.show_new = false
        console.log(item)
        const data = {
          campaign_id: this.campaign_id,
          kind: ['lead', 'extend'][this.tab],
        }
        if(item.search_type !== 'team') {
          data.affiliate_id = item.member_id
        } else {
          data.team_id = item.team_id
        }
        if(data.kind === 'lead') {
          data.date_start = item.date_start
          data.time_start = item.time_start
        } else {
          data.date_end = item.date_end
          data.time_end = item.time_end
        }
        axios.post(`/admin/campaign/lead-extend/new`, data)
        .then(res => {
          this.campaign = res.data.campaign
          this.vleads = this.campaign.lead_extend_affiliates.filter(v => v.kind === 'lead')
          this.vextends = this.campaign.lead_extend_affiliates.filter(v => v.kind === 'extend')
        })
        .catch(e => {
          vuetifyToast.error('データを保存できません。 後で試してください。')
        })
      },
      saveEdit(item, search_type) {
        this.show_edit = false

        const data = {
          campaign_id: this.campaign_id,
          kind: ['lead', 'extend'][this.tab],
        }
        if(search_type !== 'team') {
          data.affiliate_id = item.member_id
        } else {
          data.team_id = item.team_id
        }
        if(data.kind === 'lead') {
          data.date_start = item.date_start
          data.time_start = item.time_start
        } else {
          data.date_end = item.date_end
          data.time_end = item.time_end
        }
        axios.post(`/admin/campaign/lead-extend/new`, data)
        .then(res => {
          this.campaign = res.data.campaign
          this.vleads = this.campaign.lead_extend_affiliates.filter(v => v.kind === 'lead')
          this.vextends = this.campaign.lead_extend_affiliates.filter(v => v.kind === 'extend')
        })
        .catch(e => {
          vuetifyToast.error('データを保存できません。 後で試してください。')
        })
      },
      deleted(item) {
        axios.get(`/admin/campaign/lead-extend/delete/${item.id}`)
        .then(res => {
          this.campaign = res.data.campaign
          this.vleads = this.campaign.lead_extend_affiliates.filter(v => v.kind === 'lead')
          this.vextends = this.campaign.lead_extend_affiliates.filter(v => v.kind === 'extend')
        })
        .catch(e => {
          vuetifyToast.error('データを削除できません。 後で試してください。')
        })
        this.show_delete = false
      },
    }
  }
</script>

<style scoped>

</style>