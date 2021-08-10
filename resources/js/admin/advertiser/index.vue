<template>
  <div class="page_wrap_vue pa-3 advertiser-page">
    <v-card class="mx-auto">
      <v-card-title class="_header">
        <v-container fluid>
          <v-row>
            <v-col>
              <h2 class="d-inline mr-1">広告主管理</h2>
            </v-col>
            <v-col class="d-flex justify-end">
              <v-btn
                class="mr-2"
                @click="showDrafts"
              >
                下書き
              </v-btn>
              <v-btn
                class="mr-2"
                @click="showNew"
              >
                広告主登録
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
              <th class="text-left" id="_th2">名前</th>
              <th class="text-left" id="_th3">(フリガナ)</th>
              <th class="text-left" id="_th4">ランク</th>
              <th class="text-left" id="_th5">ステータス</th>
              <th class="text-left" id="_th6">登録日</th>
              <th class="text-left" id="_th7"/>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
              <td>{{ item.id }}</td>
              <td>{{ item.name_full }}</td>
              <td>{{ item.furi_full }}</td>
              <td>{{ item.rank_name }}</td>
              <td>{{ item.status_label }}</td>
              <td>{{ $date(item.created_at).format('YYYY/MM/DD') }}</td>
              <td>
                <v-btn color="#C694F9" dark @click="showDetail(item)">
                  詳細
                </v-btn>
                <v-btn color="#F99494" dark @click="showDelete(item)">
                  退会
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
      :ranks="ranks"
      @onNewDlgClose="show_new_dlg=false"
      @onCreated="onNew"
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
      @onDeleteDlgOk="onDelete"
    />
    <DraftListDlg
      :dialog="show_draft_dlg"
      :drafts="drafts"
      @onDraftDlgClose="show_draft_dlg=false"
    />
  </div>
</template>

<script>
  import NewDlg from "../../components/admin/advertiser/NewDialog";
  // import EditDlg from "../../components/admin/advertiser/EditDialog";
  import DetailDlg from "../../components/admin/advertiser/DetailDialog";
  import DeleteDlg from "../../components/admin/advertiser/DeleteDialog";
  import DraftListDlg from "../../components/admin/advertiser/DraftListDialog";
  import vuetifyToast from "vuetify-toast"

  export default {
    components: {NewDlg, /*EditDlg,*/ DetailDlg, DeleteDlg, DraftListDlg},
    data() {
      return {
        show_new_dlg: false,
        // show_edit_dlg: false,
        show_detail_dlg: false,
        show_delete_dlg: false,
        show_draft_dlg: false,
        selected: null,
        page: 0,
        size: 5,
        filters: [],
        all_items: [],
        affiliates: [],
        items: [],
        filter: '',
        drafts: [],
        ranks: []
      }
    },
    mounted() {
      // load advertiser list
      axios.get('/admin/advertiser/list')
      .then(res => {
        this.all_items = res.data.advertisers.filter(a => a.status === 1)
        this.drafts = res.data.advertisers.filter(a => a.status === 0)
        this.ranks = res.data.ranks
        this.loadItem(this.limit)
      })
      .catch(e => {
        vuetifyToast.error('広告主リストを読み取ることができません。 マネージャーに連絡するか、後で試してください。')
      })
    },
    computed: {
      limit() {
        return (this.page + 1) * this.size
      }
    },
    methods: {
      filterItems(items) {
        this.all_items = items.filter(item => item.status === 1)
        this.drafts = items.filter(item => item.status === 0)
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
      onNew(val) {
        this.filterItems(val)
        this.loadItem(this.limit)
        this.show_new_dlg = false
      },
      onDelete(val) {
        this.filterItems(val)
        this.loadItem(this.limit)
        this.show_delete_dlg = false
      },
    }
  }
</script>