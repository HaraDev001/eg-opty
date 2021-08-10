<template>
  <div class="page_wrap_vue pa-3 advertiser-page">
    <v-card class="mx-auto">
      <v-card-title class="_header pb-0">
        <v-container fluid>
          <v-row>
            <v-col class="pb-0">
              <h3 class="d-inline mr-1">振込管理 - 手動報酬額一覧</h3>
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
                @click="showNew"
              >
                新規
              </v-btn>
            </v-col>
          </v-row>
          <v-row>
            <v-col class="d-flex justify-space-between pb-0">
              <v-btn
                class="search"
                to=""
              >
                今月振込予定DL
              </v-btn>
              <v-btn
                color="info"
                dark
                rounded
                class="white--text"
                to=""
              >
                消し込み一覧
              </v-btn>
            </v-col>
          </v-row>
          <v-row>
            <v-col class="d-flex justify-space-between pb-0">
              <v-checkbox v-model="checkAll"/>
              <v-btn @click="deleteTransfer">削除</v-btn>
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
              <th class="text-left"> </th>
              <th class="text-left" id="_th1">ID</th>
              <th class="text-left" id="_th2">アフィリエイター名</th>
              <th class="text-left" id="_th3">報酬発生日</th>
              <th class="text-left" id="_th4">報酬支払日</th>
              <th class="text-left" id="_th5">報酬金額</th>
              <th class="text-left" id="_th6">備考</th>
              <th class="text-left" id="_th7"> </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
              <td>
                <v-checkbox v-model="item.checked"/>
              </td>
              <td>{{ item.id }}</td>
              <td>{{ affiliate_name(item.affiliate_id) }}</td>
              <td>{{ $date(item.made_at).format('YYYY/MM/DD HH:mm') }}</td>
              <td>{{ $date(item.pay_at).format('YYYY/MM/DD HH:mm') }}</td>
              <td>{{ item.amount }}円</td>
              <td>{{ item.note === '' ? item.note : 'なし' }}</td>
              <td>
                <v-btn color="#C694F9" dark @click="showDetail(item)">
                  詳細
                </v-btn>
              </td>
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

    <NewDialog
      :dialog="show_new_dlg"
      @onNewDlgClose="show_new_dlg=false"
      @onCreated="onNew"
    />
    <EditDialog
      :dialog="show_edit_dlg"
      :item="selected"
      @onEditDlgClose="show_edit_dlg=false"
      @onEdited="onEdit"
    />
    <DetailDialog
      :dialog="show_detail_dlg"
      :item="selected"
      @onDetailDlgClose="show_detail_dlg=false"
    />
    <DeleteDialog
      :dialog="show_delete_dlg"
      :item="selected"
      @onDeleteDlgClose="show_delete_dlg=false"
      @onDeleted="onDelete"
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
  import DraftListDialog from "../../components/admin/transfer/DraftListDialog";
  import NewDialog from "../../components/admin/transfer/NewDialog";
  import EditDialog from "../../components/admin/transfer/EditDialog";
  import DeleteDialog from "../../components/admin/transfer/DeleteDialog";
  import DetailDialog from "../../components/admin/transfer/DetailDialog";

  export default {
    components: {DetailDialog, DeleteDialog, EditDialog, NewDialog, DraftListDialog},
    data() {
      return {
        show_new_dlg: false,
        show_edit_dlg: false,
        show_detail_dlg: false,
        show_delete_dlg: false,
        show_draft_dlg: false,
        checkAll: false,
        selected: null,
        page: 0,
        size: 5,
        filters: [],
        all_items: [],
        affiliates: [],
        items: [],
        drafts: [],
      }
    },
    mounted() {
      // load categories and QAs
      this.all_items = [
        {id: 1, affiliate_id: 1, made_at: '2020-01-01 12:00:00', pay_at: '2020-02-01 12:00:00', amount: 1000, campaign_id: '', checked: false},
        {id: 2, affiliate_id: 1, made_at: '2020-01-01 12:00:00', pay_at: '2020-02-01 12:00:00', amount: 1000, campaign_id: '', checked: false},
        {id: 3, affiliate_id: 2, made_at: '2020-01-01 12:00:00', pay_at: '2020-02-01 12:00:00', amount: 1000, campaign_id: '', checked: false},
        {id: 4, affiliate_id: 2, made_at: '2020-01-01 12:00:00', pay_at: '2020-02-01 12:00:00', amount: 1000, campaign_id: '', checked: false},
        {id: 5, affiliate_id: 3, made_at: '2020-01-01 12:00:00', pay_at: '2020-02-01 12:00:00', amount: 1000, campaign_id: '', checked: false},
        {id: 6, affiliate_id: 3, made_at: '2020-01-01 12:00:00', pay_at: '2020-02-01 12:00:00', amount: 1000, campaign_id: '', checked: false},
      ]
      this.drafts = [
        {id: 1, affiliate_id: 1, made_at: '2020-01-01 12:00:00', pay_at: '2020-02-01 12:00:00', amount: 1000, campaign_id: '', checked: false},
        {id: 2, affiliate_id: 2, made_at: '2020-01-01 12:00:00', pay_at: '2020-02-01 12:00:00', amount: 1000, campaign_id: '', checked: false},
        {id: 3, affiliate_id: 3, made_at: '2020-01-01 12:00:00', pay_at: '2020-02-01 12:00:00', amount: 1000, campaign_id: '', checked: false},
      ]
      this.affiliates = [
        {id: 1, name_last: 'last1', name_first: 'first1'},
        {id: 2, name_last: 'last2', name_first: 'first2'},
        {id: 3, name_last: 'last3', name_first: 'first3'},
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
      showNew() {
        this.show_new_dlg = true
      },
      showDetail(item) {
        this.selected = item
        this.show_detail_dlg = true
      },
      showDelete(item) {
        this.selected = item
        this.show_delete_dlg = true
      },
      onNew(val, flag) {
        /**
         * save new advertiser to server
         * flag=1 => save draft, flag=2 => register
         */
        val.affiliate_id = parseInt(val.affiliate_id)
        val.id = this.all_items.length + 1
        this.all_items.unshift(val)
        this.loadItem(this.limit)
        this.show_new_dlg = false
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