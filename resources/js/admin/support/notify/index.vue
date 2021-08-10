<template>
  <div class="page_wrap_vue pa-3 notify-page">
    <v-card class="mx-auto">
      <v-card-title class="_header">
        <v-container fluid class="pb-0">
          <v-row>
            <v-col>
              <h2 class="d-inline mr-1">お知らせ</h2>
            </v-col>
            <v-col class="d-flex justify-end">
              <v-btn
                class="mr-2"
                @click="show_new_dlg=true"
              >
                新規
              </v-btn>
            </v-col>
          </v-row>
          <v-row>
            <v-col class="d-flex pb-0">
              <v-checkbox
                v-model="checkAll"
                class="mr-10 mt-0"
                label="すべて選択"
              />
              <v-btn class="" @click="show_delete_dlg=true">
                削除
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
              <th> </th>
              <th class="text-left" id="_th1">ID</th>
              <th class="text-left" id="_th2">User name / Name</th>
              <th class="text-left" id="_th3">RANK</th>
              <th class="text-left" id="_th4">Mail Address</th>
              <th class="text-left" id="_th5">Status</th>
              <th class="text-left" id="_th6">Joined</th>
              <th class="text-left" id="_th7"/>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
              <td>
                <v-checkbox
                  v-model="item.checked"
                />
              </td>
              <td>{{ item.id }}</td>
              <td>{{ item.user_name }}</td>
              <td>{{ item.rank }}</td>
              <td>{{ item.mail }}</td>
              <td>{{ item.status }}</td>
              <td>{{ item.joined }}</td>
              <td>
                <v-btn color="#C694F9" dark @click="show_detail_dlg=true">
                  詳細
                </v-btn>
<!--                <v-btn color="#F99494" dark @click="show_delete_dlg=true">-->
<!--                  棄却-->
<!--                </v-btn>-->
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
    <NotifyNewDlg
      :dialog="show_new_dlg"
      :users="users"
      @onNewDlgClose="show_new_dlg=false"
      @onCreated="onNewNotify"
    />
    <NotifyEditDlg
      :dialog="show_edit_dlg"
      :item="selected"
      @onEditDlgClose="show_edit_dlg=false"
      @onEdited="onEditNotify"
    />
    <NotifyDetailDlg
      :dialog="show_detail_dlg"
      :item="selected"
      @onDetailDlgClose="show_detail_dlg=false"
    />
    <NotifyDeleteDlg
      :dialog="show_delete_dlg"
      @onDeleteDlgClose="show_delete_dlg=false"
      @onDeleted="onDeleteNotify"
    />
  </div>
</template>

<script>
  import NotifyNewDlg from "../../../components/admin/notify/NotifyNewDialog"
  import NotifyEditDlg from "../../../components/admin/notify/NotifyEditDialog"
  import NotifyDetailDlg from "../../../components/admin/notify/NotifyDetailDialog"
  import NotifyDeleteDlg from "../../../components/admin/notify/NotifyDeleteDialog"

  export default {
    components: {NotifyNewDlg, NotifyEditDlg, NotifyDeleteDlg, NotifyDetailDlg},
    data() {
      return {
        show_new_dlg: false,
        show_edit_dlg: false,
        show_detail_dlg: false,
        show_delete_dlg: false,
        selected: null,
        page: 0,
        size: 5,
        all_items: [],
        items: [],
        users: [],
        checkAll: false
      }
    },
    mounted() {
      // load categories and QAs
      this.all_items = [
        {id: 1, checked: false, title:'all', user_name: '対象者1', rank: 'SS VIP', mail: 'test@mail.com', status: '本登録', joined: '2020/01/01'},
        {id: 2, checked: false, title:'affiliate', user_name: '対象者1', rank: 'SS VIP', mail: 'test@mail.com', status: '', joined: '2020/01/01'},
        {id: 3, checked: false, title:'affiliate', user_name: '対象者1', rank: 'SS VIP', mail: 'test@mail.com', status: '本登録', joined: '2020/01/01'},
        {id: 4, checked: false, title:'affiliate', user_name: '対象者1', rank: 'SS VIP', mail: 'test@mail.com', status: '本登録', joined: '2020/01/01'},
        {id: 5, checked: false, title:'all', user_name: '対象者1', rank: 'SS VIP', mail: 'test@mail.com', status: '', joined: '2020/01/01'},
        {id: 6, checked: false, title:'all', user_name: '対象者1', rank: 'SS VIP', mail: 'test@mail.com', status: '', joined: '2020/01/01'},
        {id: 7, checked: false, title:'advertiser', user_name: '対象者1', rank: 'SS VIP', mail: 'test@mail.com', status: '本登録', joined: '2020/01/01'},
        {id: 8, checked: false, title:'advertiser', user_name: '対象者1', rank: 'SS VIP', mail: 'test@mail.com', status: '本登録', joined: '2020/01/01'},
        {id: 9, checked: false, title:'advertiser', user_name: '対象者1', rank: 'SS VIP', mail: 'test@mail.com', status: '', joined: '2020/01/01'},
        {id: 10, checked: false, title:'all', user_name: '対象者1', rank: 'SS VIP', mail: 'test@mail.com', status: '本登録', joined: '2020/01/01'},
        {id: 11, checked: false, title:'all', user_name: '対象者1', rank: 'SS VIP', mail: 'test@mail.com', status: '本登録', joined: '2020/01/01'},
      ]
      this.users = [
        {id: 1, name: '対象者1', rank: 'vip', mail: 'user1@mail.com'},
        {id: 2, name: '対象者2', rank: 'vip', mail: 'user2@mail.com'},
        {id: 3, name: '対象者3', rank: 'vip', mail: 'user3@mail.com'},
        {id: 4, name: '対象者4', rank: 'vip', mail: 'user4@mail.com'},
        {id: 5, name: '対象者5', rank: 'vip', mail: 'user5@mail.com'},
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
        this.items.forEach(item => {
          item.checked = val
        })
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
      onNewNotify(val) {
        /**
         * save new Notify to server
         */
        this.all_items.unshift({
          id: this.all_items.length + 1,
          type: val.type,
          user_name: val.user_name,
          title: val.title,
          rank: '',
          detail: val.detail,
          status: '本登録',
          joined: this.$date().format('YYYY/MM/DD HH:mm')
        })
        this.loadItem(this.limit)
        this.show_new_dlg = false
      },
      onEditNotify(val) {
        /**
        * save edited Notify to server
        */
        const id = this.all_items.findIndex(m => m.id === val.id)
        if(id === -1) return
        this.all_items[id] = val
        this.loadItem(this.limit)
      },
      onDeleteNotify(val) {
        /**
        * delete Notify from server
        */
        const selected = this.items.filter(item => item.checked)
        selected.forEach(s => {
          const k = this.all_items.findIndex(item => s.id === item.id)
          if(k > -1) this.all_items.splice(k, 1)
        })
        this.loadItem(this.limit)
        this.show_delete_dlg = false
      },
    }
  }
</script>