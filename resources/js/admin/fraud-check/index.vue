<template>
  <div class="page_wrap_vue pa-3 advertiser-page">
    <v-card class="mx-auto">
      <v-card-title class="_header pb-0">
        <v-container fluid>
          <v-row>
            <v-col class="pb-0">
              <h3 class="d-inline mr-1">不正チェック - レポート管理</h3>
            </v-col>
            <v-col class="d-flex justify-end pb-0">
              <v-btn
                class="mr-2"
                color="success"
                @click="showDrafts"
              >
                下書き
              </v-btn>
              <v-btn
                class="mr-2"
                color="info"
                @click="showNewReserve"
              >
                予約
              </v-btn>
            </v-col>
          </v-row>
          <v-row>
            <v-col class="d-flex justify-end pb-0">
              <v-btn
                color="info"
                dark
                rounded
                class="white--text"
                @click="showNewCandidate"
              >
                候補者登録
              </v-btn>
            </v-col>
          </v-row>
        </v-container>
      </v-card-title>
      <v-divider/>
      <v-card-text class="_content">
        <v-simple-table>
          <template v-slot:default>
            <thead>
            <tr>
              <th class="text-left" id="_th1">ID</th>
              <th class="text-left" id="_th2">レポートの種類</th>
              <th class="text-left" id="_th3">キャンペーン名</th>
              <th class="text-left" id="_th4">対象月</th>
              <th class="text-left" id="_th5">予約日時</th>
              <th class="text-left" id="_th6">作成状況</th>
              <th class="text-left" id="_th7">ステータス更新日時</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
              <td>{{ item.id }}</td>
              <td>{{ item.report_type }}</td>
              <td>{{ campaign_name(item.campaign_id) }}</td>
              <td>{{ $date(item.reserve_month).format('YYYY/MM') }}</td>
              <td>{{ $date(item.created_at).format('YYYY/MM/DD HH:mm') }}</td>
              <td>{{ item.status }}</td>
              <td>{{ $date(item.updated_at).format('YYYY/MM/DD HH:mm') }}</td>
<!--              <td>-->
<!--                <v-btn color="#C694F9" dark @click="showDetail(item)">-->
<!--                  詳細-->
<!--                </v-btn>-->
<!--              </td>-->
            </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-card-text>
      <v-divider/>
      <v-card-actions class="d-flex justify-center">
        <v-btn text @click="showMore">
          もっと見る
        </v-btn>
      </v-card-actions>
    </v-card>

    <NewReserveDialog
      :dialog="show_new_reserve_dlg"
      :campaigns="campaigns"
      @onNewReserveDlgClose="show_new_reserve_dlg=false"
      @onNewReservation="onNewReserve"
    />
    <NewCandidateDialog
      :dialog="show_new_candidate_dlg"
      :affiliates="affiliates"
      :campaigns="campaigns"
      @onNewCandidateDlgClose="show_new_candidate_dlg=false"
      @onNewCandidate="onNewCandidate"
    />
    <EditDialog
      :dialog="show_edit_dlg"
      :item="selected"
      @onEditDlgClose="show_edit_dlg=false"
      @onEdited="onEdit"
    />
    <DraftListDialog
      :dialog="show_draft_dlg"
      :drafts="drafts"
      :affiliates="affiliates"
      @onDraftDlgClose="show_draft_dlg=false"
      @onEditDraft="showEdit"
    />
  </div>
</template>

<script>
  import DraftListDialog from "../../components/admin/fraud-check/DraftListDialog";
  import NewReserveDialog from "../../components/admin/fraud-check/NewReservationDialog";
  import EditDialog from "../../components/admin/fraud-check/EditDialog";
  import NewCandidateDialog from "../../components/admin/fraud-check/NewCandidateDialog";

  export default {
    components: {NewCandidateDialog, EditDialog, NewReserveDialog, DraftListDialog},
    data() {
      return {
        show_new_reserve_dlg: false,
        show_new_candidate_dlg: false,
        show_edit_dlg: false,
        show_detail_dlg: false,
        show_delete_dlg: false,
        show_draft_dlg: false,
        checkAll: false,
        selected: null,
        page: 0,
        size: 5,
        all_items: [],
        affiliates: [],
        items: [],
        drafts: [],
        campaigns: []
      }
    },
    mounted() {
      // load categories and QAs
      this.all_items = [
        {id: 1, report_type: '不正アフィリエイター', campaign_id: 1, created_at: '2020-01-01 12:00:00', updated_at: '2020-02-01 12:00:00', amount: 1000, status: '完了', reserve_month: '2020-05'},
        {id: 2, report_type: '不正アフィリエイター', campaign_id: 1, created_at: '2020-01-01 12:00:00', updated_at: '2020-02-01 12:00:00', amount: 1000, status: '完了', reserve_month: '2020-05'},
        {id: 3, report_type: '不正アフィリエイター', campaign_id: 2, created_at: '2020-01-01 12:00:00', updated_at: '2020-02-01 12:00:00', amount: 1000, status: '完了', reserve_month: '2020-05'},
        {id: 4, report_type: '不正アフィリエイター', campaign_id: 2, created_at: '2020-01-01 12:00:00', updated_at: '2020-02-01 12:00:00', amount: 1000, status: '完了', reserve_month: '2020-05'},
        {id: 5, report_type: '不正アフィリエイター', campaign_id: 3, created_at: '2020-01-01 12:00:00', updated_at: '2020-02-01 12:00:00', amount: 1000, status: '完了', reserve_month: '2020-05'},
        {id: 6, report_type: '不正アフィリエイター', campaign_id: 3, created_at: '2020-01-01 12:00:00', updated_at: '2020-02-01 12:00:00', amount: 1000, status: '完了', reserve_month: '2020-05'},
      ]
      this.drafts = [
        {id: 1, report_type: '不正アフィリエイター', campaign_id: 1, created_at: '2020-01-01 12:00:00', updated_at: '2020-02-01 12:00:00', amount: 1000, status: '完了', reserve_month: '2020-05'},
        {id: 2, report_type: '不正アフィリエイター', campaign_id: 1, created_at: '2020-01-01 12:00:00', updated_at: '2020-02-01 12:00:00', amount: 1000, status: '完了', reserve_month: '2020-05'},
        {id: 3, report_type: '不正アフィリエイター', campaign_id: 2, created_at: '2020-01-01 12:00:00', updated_at: '2020-02-01 12:00:00', amount: 1000, status: '完了', reserve_month: '2020-05'},
      ]
      this.affiliates = [
        {id: 1, name: 'last1first1'},
        {id: 2, name: 'last2first2'},
        {id: 3, name: 'last3first3'},
      ]
      this.campaigns = [
        {id: 1, name: 'campaign1'},
        {id: 2, name: 'campaign2'},
        {id: 3, name: 'campaign3'},
      ]
      this.loadItem(this.limit)
    },
    computed: {
      limit() {
        return (this.page + 1) * this.size
      }
    },
    watch: {
      checkAll(val) {
        this.items.forEach(item => item.checked = val)
      },
    },
    methods: {
      campaign_name(aid) {
        const camp = this.campaigns.find(camp => camp.id ===aid)
        return camp === undefined ? '' : camp.name
      },
      affiliate_name(aid) {
        const aff = this.affiliates.find(aff => aff.id ===aid)
        return aff === undefined ? '' : aff.name_last + aff.name_first
      },
      deleteTransfer() {
        const selected_items = this.items.filter(item => item.checked)
        selected_items.forEach(item => {
          const index = this.all_items.findIndex(m => m.id === item.id)
          if(index > -1) this.all_items.splice(index, 1)
        })
        this.loadItem(this.limit)
      },
      showMore() {
        this.page++
        const start = this.page * this.size
        const end = start + this.size
        const new_items = this.all_items.filter((item, key) => key >= start && key < end)
        this.items = [...this.items, ...new_items]
      },
      loadItem(limit) {
        this.items = this.all_items.slice(0, limit)
      },
      findItem(qid) {
        const item = this.items.find(item => item.id === qid)
        if (item === undefined) return false
        this.selected = item
        return true
      },
      showEdit(val) {
        this.selected = val
        this.show_draft_dlg = false
        this.show_edit_dlg = true
      },
      showDrafts() {
        this.show_draft_dlg = true
      },
      showNewReserve() {
        this.show_new_reserve_dlg = true
      },
      showNewCandidate() {
        this.show_new_candidate_dlg = true
      },
      showDetail(item) {
        this.selected = item
        this.show_detail_dlg = true
      },
      showDelete(item) {
        this.selected = item
        this.show_delete_dlg = true
      },
      onNewReserve(val, flag) {
        /**
         * save new advertiser to server
         * flag=1 => save draft, flag=2 => register
         */
        val.campaign_id = parseInt(val.campaign_id)
        val.id = this.all_items.length + 1
        this.all_items.unshift(val)
        this.loadItem(this.limit)
        this.show_new_reserve_dlg = false
      },
      onNewCandidate(val, flag) {
        /**
         * save new advertiser to server
         * flag=1 => save draft, flag=2 => register
         */
        this.show_new_campaign_dlg = false
      },
      onEdit(val, flag) {
        /**
         * save new advertiser to server
         * flag=1 => save draft, flag=2 => register
         */
        const index = this.all_items.findIndex(m => m.id === val.id)
        if(index === -1) return
        this.all_items[index] = val
        this.loadItem(this.limit)
      },
      onDelete(val) {
        /**
        * delete Qa from server
        */
        const id = this.all_items.findIndex(m => m.id === val.id)
        if(id === -1) return
        this.all_items.splice(id, 1)
        this.loadItem(this.limit)
        this.show_delete_dlg = false
      },
    }
  }
</script>

<style scoped>
</style>