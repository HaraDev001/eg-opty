<template>
  <div class="page_wrap_vue pa-3 contact-page">
    <v-card class="mx-auto">
      <v-card-title class="_header">
        <v-container fluid>
          <v-row>
            <v-col>
              <h2 class="d-inline mr-1">お問い合わせ</h2>
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
                お問い合わせ送信
              </v-btn>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-text-field
                append-icon="mdi-magnify"
                class="d-inline-block mr-1"
              />
              <v-btn
                class="_header_search_button"
              >
                検索
              </v-btn>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-chip-group
                v-model="filter"
                column
                active-class="info white--text "
              >
                <v-chip color="grey lighten-2" v-for="filter in filters" :key="filter">
                  {{ filter }}
                </v-chip>
              </v-chip-group>
            </v-col>
          </v-row>
        </v-container>
      </v-card-title>

      <v-card-text class="_content">
        <v-simple-table>
          <template v-slot:default>
            <thead>
            <tr>
              <th class="text-left" id="_th1">ID</th>
              <th class="text-left" id="_th2">対象者 </th>
              <th class="text-left" id="_th3">RANK</th>
              <th class="text-left" id="_th4">件名</th>
              <th class="text-left" id="_th5"/>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
              <td>{{ item.id }}</td>
              <td>{{ item.affiliate }}</td>
              <td>{{ item.rank }}</td>
              <td>{{ item.subject }}</td>
              <td>
                <v-btn color="#C694F9" dark @click="showDetail(item.id)">
                  詳細
                </v-btn>
                <v-btn color="#F99494" dark @click="showDelete(item.id)">
                  棄却
                </v-btn>
              </td>
            </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-card-text>

      <v-card-actions class="d-flex justify-center">
        <v-btn text @click="showMore">
          もっと見る
        </v-btn>
      </v-card-actions>
    </v-card>
    <ContactNewDlg
      :dialog="show_new_dlg"
      @onNewDlgClose="show_new_dlg=false"
      @onCreated="onNewContact"
    />
    <ContactEditDlg
      :dialog="show_edit_dlg"
      :item="selected"
      @onEditDlgClose="show_edit_dlg=false"
      @onEdited="onEditContact"
    />
    <ContactDetailDlg
      :dialog="show_detail_dlg"
      :item="selected"
      @onDetailDlgClose="show_detail_dlg=false"
    />
    <ContactDeleteDlg
      :dialog="show_delete_dlg"
      :item="selected"
      @onDeleteDlgClose="show_delete_dlg=false"
      @onDeleted="onDeleteContact"
    />
    <ContactDraftListDlg
      :dialog="show_draft_dlg"
      :drafts="drafts"
      @onDraftDlgClose="show_draft_dlg=false"
      @onEditDraft="editDraft"
    />
  </div>
</template>

<script>
  import ContactNewDlg from "../../../components/admin/contact/ContactNewDialog";
  import ContactEditDlg from "../../../components/admin/contact/ContactEditDialog";
  import ContactDetailDlg from "../../../components/admin/contact/ContactDetailDialog";
  import ContactDeleteDlg from "../../../components/admin/contact/ContactDeleteDialog";
  import ContactDraftListDlg from "../../../components/admin/contact/ContactDraftListDialog";

  export default {
    components: {ContactNewDlg, ContactEditDlg, ContactDetailDlg, ContactDeleteDlg, ContactDraftListDlg},
    data() {
      return {
        show_new_dlg: false,
        show_edit_dlg: false,
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
      }
    },
    mounted() {
      // load categories and QAs
      this.all_items = [
        {id: 1, affiliate: '対象者1', rank: 'SS VIP', subject: 'キャンペーンキャンペーンキャンペーン'},
        {id: 2, affiliate: '対象者2', rank: 'SS VIP', subject: 'キャンペーンキャンペーンキャンペーン'},
        {id: 3, affiliate: '対象者3', rank: 'SS VIP', subject: 'キャンペーンキャンペーンキャンペーン'},
        {id: 4, affiliate: '対象者4', rank: 'SS VIP', subject: 'キャンペーンキャンペーンキャンペーン'},
        {id: 5, affiliate: '対象者5', rank: 'SS VIP', subject: 'キャンペーンキャンペーンキャンペーン'},
        {id: 6, affiliate: '対象者6', rank: 'SS VIP', subject: 'キャンペーンキャンペーンキャンペーン'},
        {id: 7, affiliate: '対象者7', rank: 'SS VIP', subject: 'キャンペーンキャンペーンキャンペーン'},
        {id: 8, affiliate: '対象者8', rank: 'SS VIP', subject: 'キャンペーンキャンペーンキャンペーン'},
        {id: 9, affiliate: '対象者9', rank: 'SS VIP', subject: 'キャンペーンキャンペーンキャンペーン'},
        {id: 10, affiliate: '対象者10', rank: 'SS VIP', subject: 'キャンペーンキャンペーンキャンペーン'},
      ]
      this.filters = ['新規', '返信済', 'リプライ', '完了']
      this.affiliates = [
        {id: 1, name: '対象者1'},
        {id: 2, name: '対象者2'},
        {id: 3, name: '対象者3'},
        {id: 4, name: '対象者4'},
        {id: 5, name: '対象者5'},
      ]
      this.drafts = [
        {id: 1, date: '2020/01/01', subject: 'draft1', content: 'content1'},
        {id: 2, date: '2020/02/01', subject: 'draft2', content: 'content2'},
        {id: 3, date: '2020/03/01', subject: 'draft3', content: 'content3'},
      ]
      this.loadItem(this.limit)
    },
    computed: {
      limit() {
        return (this.page + 1) * this.size
      }
    },
    methods: {
      editDraft(val) {
        console.log(val)
        const draft = this.drafts.find(item => item.id === val)
        if (draft === undefined) return
        console.log(draft)
        this.selected = draft
        this.show_edit_dlg = true
      },
      showDrafts() {
        this.show_draft_dlg = true
      },
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
      showNew() {
        this.show_new_dlg = true
      },
      showEdit(qid) {
        if (!this.findItem(qid)) return
        this.show_edit_dlg = true
      },
      showDetail(qid) {
        if (!this.findItem(qid)) return
        this.show_detail_dlg = true
      },
      showDelete(qid) {
        if (!this.findItem(qid)) return
        this.show_delete_dlg = true
      },
      onNewContact(val) {
        /**
         * save new Contact to server
         */
        this.all_items.unshift({
          id: this.all_items.length + 1,
          affiliate: val.affiliate,
          rank: '',
          subject: val.subject
        })
        this.loadItem(this.limit)
        this.show_new_dlg = false
      },
      onEditContact(val) {
        /**
        * save edited Qa to server
        */
        const id = this.all_items.findIndex(m => m.id === val.id)
        if(id === -1) return
        this.all_items[id] = val
        this.loadItem(this.limit)
      },
      onDeleteContact(val) {
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