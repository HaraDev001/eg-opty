<template>
  <v-card>
    <v-container fluid>
      <v-card-title>
        <v-row>
          <v-col cols="12">
            <h3>LP別報酬</h3>
          </v-col>
        </v-row>
      </v-card-title>
      <v-divider/>
      <v-card-text>
        <v-form v-model="valid">
          <v-row>
            <v-col cols="12" class="d-flex justify-space-between">
              <h3>LP別報酬登録</h3>
            </v-col>
            <v-col cols="12">
              <v-row>
                <v-col cols="12">
                  <label>LP選択</label>
                  <v-select
                    single-line outlined hide-details="auto" dense
                    v-model="item.lp_id"
                    :items="lps"
                    item-text="title" item-value="id"
                    :rules="[required]"
                    class="d-inline-flex ml-2 mr-3"
                  />
                  <label>報酬額</label>
                  <v-text-field
                    single-line outlined hide-details="auto" dense
                    class="d-inline-flex ml-2 mr-3"
                    :rules="[required, mustNumber]"
                    v-model="item.amount"
                  />
                </v-col>
                <v-col cols="12">
                  <label>RANK</label>
                  <v-select
                    outlined dense hide-details="auto" single-line
                    v-model="item.rank_id"
                    :items="ranks"
                    item-text="name" item-value="id"
                    :rules="[required, mustNumber]"
                    class="d-inline-flex ml-2 mr-3"
                  />
                  <label>期間設定</label>
                  <v-text-field
                    type="date"
                    v-model="item.date_start"
                    outlined dense single-line hide-details="auto"
                    :rules="[required]"
                    class="d-inline-flex mx-2"
                  />
                  <v-text-field
                    type="time"
                    v-model="item.time_start"
                    outlined dense single-line hide-details="auto"
                    :rules="[required]"
                    class="d-inline-flex mr-2"
                  /> から
                  <v-text-field
                    type="date"
                    v-model="item.date_end"
                    outlined dense single-line hide-details="auto"
                    :rules="[required]"
                    class="d-inline-flex mx-2"
                  />
                  <v-text-field
                    type="time"
                    v-model="item.time_end"
                    outlined dense single-line hide-details="auto"
                    :rules="[required]"
                    class="d-inline-flex mr-3"
                  />まで
                </v-col>
              </v-row>
            </v-col>
            <v-col cols="12">
              <v-btn color="info" dark :disabled="!valid" @click="saveNew">登録</v-btn>
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>
      <v-divider/>
      <v-card-text class="_lp-container">
        <v-row>
          <v-col cols="12" v-for="(lp, i) in lps" :key="i">
            <LpRewardItem :item="lp" @onShowEditDlg="showEditDlg" @onShowDeleteDlg="showDeleteDlg"/>
          </v-col>
        </v-row>
      </v-card-text>
    </v-container>
    <EditLpRewardDlg :show="show_edit" :item="selected" @onEditClose="show_edit=false" @onEditSave="saveEditReward"/>
    <DeleteRewardDlg :show="show_delete" :item="selected" @onDeleteClose="show_delete=false" @onDeleteReward="deleteReward"/>
  </v-card>
</template>

<script>
  import LpRewardItem from "./LpRewardItem";
  // import NewLpRewardDlg from "./NewLpRewardDlg";
  import EditLpRewardDlg from "./EditLpRewardDlg";
  import DeleteRewardDlg from "./DeleteRewardDlg";
  import vuetifyToast from "vuetify-toast"

  export default {
    components: {EditLpRewardDlg, LpRewardItem, DeleteRewardDlg},
    props: {
      campaign_id: {type: Number, default: 0}
    },
    data: vm => ({
      valid: false,
      lps: [],
      ranks: [],
      selected: {
        id: 0,
        lp_id: 0,
        amount: 0,
        rank_id: 0,
        date_start: '',
        time_start: '',
        date_end: '',
        time_end: ''
      },
      item: {
        id: 0,
        lp_id: 0,
        amount: 0,
        rank_id: 0,
        date_start: '',
        time_start: '',
        date_end: '',
        time_end: ''
      },
      show_new: false,
      show_delete: false,
      show_edit: false,
      required: v => !!v || '必須フィールド',
      mustNumber: v => !isNaN(parseInt(v)) || '数ではない'
    }),
    mounted() {
      axios.get(`/admin/campaign/lp-reward/list/${this.campaign_id}`)
      .then(res => {
        this.ranks = res.data.ranks
        this.lps = res.data.lps
      })
      .catch(e => {
        vuetifyToast.error('サーバーからLP報酬リストを取得できません。')
      })
    },
    methods: {
      saveNew() {
        const dts = this.$date(this.item.date_start + '' + this.item.time_start)
        const dte = this.$date(this.item.date_end + '' + this.item.time_end)

        if(dte.isBefore(dts)) {
          vuetifyToast.error('開始日は終了日より前にしてください。')
          return
        }
        this.item.campaign_id = this.campaign_id
        console.log(this.item)
        axios.post(`/admin/campaign/lp-reward/save`, this.item)
        .then(res => {
          this.lps = res.data.lps
        })
        .catch(e => {
          console.log(e.response)
          vuetifyToast.error('LP報酬を保存できません。')
        })
      },
      showEditDlg(item) {
        this.selected = item
        this.show_edit = true
      },
      showDeleteDlg(item) {
        this.selected = item
        this.show_delete = true
      },
      saveEditReward(item) {
        item.campaign_id = this.campaign_id
        const val = {
          id: item.id,
          amount: item.amount,
          campaign_id: item.campaign_id,
          lp_id: item.lp_id,
          rank_id: item.rank_id,
          date_start: item.date_start,
          time_start: item.time_start,
          date_end: item.date_end,
          time_end: item.time_end
        }
        axios.post(`/admin/campaign/lp-reward/save`, val)
          .then(res => {
            this.lps = res.data.lps
            this.show_edit = false
          })
          .catch(e => {
            console.log(e.response)
            vuetifyToast.error('LP報酬を保存できません。')
          })
      },
      deleteReward(item) {
        axios.get(`/admin/campaign/lp-reward/delete/${item.id}`)
          .then(res => {
            this.lps = res.data.lps
            this.show_delete = false
          })
          .catch(e => {
            console.log(e.response)
            vuetifyToast.error('LP報酬を削除できません。')
          })
      }
    }
  }
</script>

<style scoped>
._lp-container {
  max-height: 600px;
  overflow-y: scroll;
}
</style>