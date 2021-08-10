<template>
  <div class="page_wrap_vue pa-3 advertiser-page">
    <v-card class="mx-auto">
      <v-card-title class="_header">
        <v-container fluid>
          <v-row>
            <v-col>
              <h2 class="d-inline mr-1">成約管理 一覧</h2>
            </v-col>
            <v-col class="d-flex justify-end">
              <v-btn
                class="mr-2"
                rounded color="success"
                :to="'/admin/contract/reservation'"
              >
                承認予約
              </v-btn>
              <v-btn
                class="mr-2"
                rounded color="info"
                @click="showAccount"
              >
                報酬一括更新
              </v-btn>
              <v-btn
                class="mr-2"
                rounded dark color="purple darken--2"
                @click="showAccount"
              >
                報酬任意更新
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
              <th class="text-left" id="_th1">キャンペーン名</th>
              <th class="text-left" id="_th2">成約件数</th>
              <th class="text-left" id="_th3">支払予定額</th>
              <th class="text-left" id="_th4">デポジット額との差分</th>
              <th class="text-left" id="_th5"> </th>
<!--              <th class="text-left" id="_th7"/>-->
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
              <td>{{ item.campaign }}</td>
              <td>{{ item.contract_number }}件</td>
              <td>{{ item.expected_payment }}円</td>
              <td>{{ item.deposit_difference }}円</td>
              <td>
                <v-btn color="purple darken--2" dark @click="showDetail(item)">
                  詳細
                </v-btn>
                <v-btn color="primary" @click="showAnalysis(item)">
                  分析
                </v-btn>
                <v-btn color="error" @click="showDelete(item)">
                  棄却
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

    <NewDlg
      :dialog="show_new_dlg"
      @onNewDlgClose="show_new_dlg=false"
      @onCreated="onNew"
    />
    <EditDlg
      :dialog="show_edit_dlg"
      :item="selected"
      @onEditDlgClose="show_edit_dlg=false"
      @onEdited="onEdit"
    />
    <DetailDlg
      :dialog="show_detail_dlg"
      :item="selected"
      @onDetailDlgClose="show_detail_dlg=false"
    />
    <DeleteDlg
      :dialog="show_delete_dlg"
      :item="selected"
      @onDeleteDlgClose="show_delete_dlg=false"
      @onDeleted="onDelete"
    />
    <AccountDlg
      :dialog="show_account_dlg"
      @onAccountClose="show_account_dlg=false"
      @onNewAccount="onNewAccount"
    />
  </div>
</template>

<script>
  import NewDlg from "../../components/admin/manager/NewDialog";
  import EditDlg from "../../components/admin/manager/EditDialog";
  import DetailDlg from "../../components/admin/manager/DetailDialog";
  import DeleteDlg from "../../components/admin/manager/DeleteDialog";
  import AccountDlg from "../../components/admin/manager/AccountDialog";

  export default {
    components: {AccountDlg, NewDlg, EditDlg, DetailDlg, DeleteDlg},
    data() {
      return {
        show_new_dlg: false,
        show_edit_dlg: false,
        show_detail_dlg: false,
        show_delete_dlg: false,
        show_account_dlg: false,
        selected: null,
        page: 0,
        size: 5,
        filters: [],
        all_items: [],
        affiliates: [],
        items: [],
        filter: '',
      }
    },
    mounted() {
      this.all_items = [
        {id: 1, campaign: 'campaign', contract_number: 10, expected_payment: 1000, deposit_difference: 200},
        {id: 2, campaign: 'campaign', contract_number: 10, expected_payment: 1000, deposit_difference: 200},
        {id: 3, campaign: 'campaign', contract_number: 10, expected_payment: 1000, deposit_difference: 200},
        {id: 4, campaign: 'campaign', contract_number: 10, expected_payment: 1000, deposit_difference: 200},
        {id: 5, campaign: 'campaign', contract_number: 10, expected_payment: 1000, deposit_difference: 200},
        {id: 6, campaign: 'campaign', contract_number: 10, expected_payment: 1000, deposit_difference: 200},
        {id: 7, campaign: 'campaign', contract_number: 10, expected_payment: 1000, deposit_difference: 200},
      ]
      this.loadItem(this.limit)
    },
    computed: {
      limit() {
        return (this.page + 1) * this.size
      }
    },
    methods: {
      showMore() {
        this.page++
        const start = this.page * this.size
        const end = start + this.size
        const new_items = this.all_items.filter((item, key) => key >= start && key < end)
        this.items = [...this.items, ...new_items]
      },
      loadItem(limit) {
        console.log(limit)
        this.items = this.all_items.slice(0, limit)
      },
      findItem(qid) {
        const item = this.items.find(item => item.id === qid)
        if (item === undefined) return false
        this.selected = item
        return true
      },
      showEdit(val) {
        console.log(val)
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
      showAccount() {
        this.show_account_dlg = true
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
        this.all_items.unshift(val)
        this.loadItem(this.limit)
        this.show_new_dlg = false
      },
      onNewAccount(val) {
        /**
         * save new advertiser to server
         * flag=1 => save draft, flag=2 => register
         */
        // this.all_items.unshift(val)
        // this.loadItem(this.limit)
        this.show_account_dlg = false
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