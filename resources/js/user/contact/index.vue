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
                @click="showNew"
              >
                お問い合わせ送信
              </v-btn>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-text-field
                outlined dense hide-details
                append-icon="mdi-magnify"
                class="d-inline-block mr-1"
              />
              <v-btn
                class="_header_search_button"
                @click=""
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
                <v-chip color="grey lighten-2" v-for="filter in filters" :key="filter.value">
                  {{ filter.label }}
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
              <td>{{ item.affiliate_name }}</td>
              <td>{{ item.rank }}</td>
              <td>{{ item.subject }}</td>
              <td>
                <v-btn color="purple" dark @click="showDetail(item)">
                  詳細
                </v-btn>
                <v-btn color="info" dark @click="showEdit(item)">
                  編集
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
    <NewDlg
      :show="show_new" :affiliates="affiliates"
      @onNewClose="show_new=false"
      @onCreated="onNewContact"
    />
    <EditDlg
      :show="show_edit"
      :item="selected" :affiliates="affiliates"
      @onEditClose="show_edit=false"
      @onEdited="onEditContact"
    />
    <DetailDlg
      :show="show_detail"
      :item="selected"
      @onDetailClose="show_detail=false"
    />
  </div>
</template>

<script>
  import NewDlg from "../../components/user/contact/NewDlg";
  import EditDlg from "../../components/user/contact/EditDlg";
  import DetailDlg from "../../components/user/contact/DetailDlg";

  export default {
    components: {NewDlg, EditDlg, DetailDlg},
    data() {
      return {
        show_new: false,
        show_edit: false,
        show_detail: false,
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
        {id: 1, affiliate_id: 1, affiliate_name: '対象者1', rank: 'SS VIP', subject: 'subject1', content:'content'},
        {id: 2, affiliate_id: 2, affiliate_name: '対象者2', rank: 'SS VIP', subject: 'subject2', content:'content'},
        {id: 3, affiliate_id: 3, affiliate_name: '対象者3', rank: 'SS VIP', subject: 'subject3', content:'content'},
        {id: 4, affiliate_id: 4, affiliate_name: '対象者4', rank: 'SS VIP', subject: 'subject4', content:'content'},
        {id: 5, affiliate_id: 5, affiliate_name: '対象者5', rank: 'SS VIP', subject: 'subject5', content:'content'},
        {id: 6, affiliate_id: 6, affiliate_name: '対象者6', rank: 'SS VIP', subject: 'subject6', content:'content'},
        {id: 7, affiliate_id: 7, affiliate_name: '対象者7', rank: 'SS VIP', subject: 'subject7', content:'content'},
        {id: 8, affiliate_id: 8, affiliate_name: '対象者8', rank: 'SS VIP', subject: 'subject8', content:'content'},
        {id: 9, affiliate_id: 9, affiliate_name: '対象者9', rank: 'SS VIP', subject: 'subject9', content:'content'},
        {id: 10, affiliate_id: 10, affiliate_name: '対象者10', rank: 'SS VIP', subject: 'subject10', content:'content'},
      ]
      this.filters = [{label:'新規', value: 'new'}, {label:'返信済',value:'replied'}, {label:'リプライ',value:'reply'}, {label:'完了', value:'completed'}]
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
      showNew() {
        console.log('hhh')
        this.show_new = true
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
      showDetail(item) {
        this.selected = item
        this.show_detail = true
      },
      showEdit(item) {
        this.selected = item
        this.show_edit = true
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
        this.show_new = false
      },
      onEditContact(val) {
        const index = this.items.findIndex(it => it.id === val.id)
        if(index < 0) return
        this.items[index] = val
        this.show_edit = false
      }
    }
  }
</script>