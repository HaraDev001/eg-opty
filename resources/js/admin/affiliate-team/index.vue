<template>
  <div class="page_wrap_vue pa-3 advertiser-page">
    <v-card class="mx-auto">
      <v-card-title class="_header pb-0">
        <v-container fluid>
          <v-row>
            <v-col class="pb-0">
              <h3 class="d-inline mr-1">アフィリエイター　チーム管理</h3>
            </v-col>
            <v-col class="d-flex justify-end pb-0">
              <v-btn
                class="mr-2"
                color="error"
                @click="show_delete_dlg=true"
              >
                削除
              </v-btn>
              <v-btn
                class="mr-2"
                color="info"
                @click="show_new_dlg=true"
              >
                新規
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
                to="/admin/affiliate"
              >
                個人管理
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
              <th class="text-left"><v-checkbox v-model="checkAll"/> </th>
              <th class="text-left" id="_th1">ID</th>
              <th class="text-left" id="_th2">チームネーム</th>
              <th class="text-left" id="_th3">対象キャンペーン</th>
              <th class="text-left" id="_th4">メンバー</th>
              <th class="text-left" id="_th7"> </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
              <td>
                <v-checkbox v-model="item.checked"/>
              </td>
              <td>{{ item.id }}</td>
              <td>{{ item.name }}</td>
              <td>{{ item.campaign_name }}</td>
              <td>{{ item.affiliate_names }}</td>
              <td>
                <v-btn color="#C694F9" dark @click="showDetail(item)">
                  詳細
                </v-btn>
                <v-btn color="info" dark @click="showAddMember(item)">
                  追加
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
      :campaigns="campaigns"
      @onNewDlgClose="show_new_dlg=false"
      @onCreated="onNew"
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
    <AddMemberDialog
      :dialog="show_member_dlg"
      :item="selected"
      :affiliates="affiliates"
      @onMemberDlgClose="show_member_dlg=false"
      @onNewMember="newMember"
    />
  </div>
</template>

<script>
  import NewDialog from "../../components/admin/affiliate-team/NewDialog";
  import DeleteDialog from "../../components/admin/affiliate-team/DeleteDialog";
  import DetailDialog from "../../components/admin/affiliate-team/DetailDialog";
  import AddMemberDialog from "../../components/admin/affiliate-team/AddMemberDialog";
  import vuetifyToast from "vuetify-toast"

  export default {
    components: {DetailDialog, DeleteDialog, NewDialog, AddMemberDialog},
    data() {
      return {
        show_member_dlg: false,
        show_new_dlg: false,
        show_detail_dlg: false,
        show_delete_dlg: false,
        checkAll: false,
        selected: null,
        page: 0,
        size: 5,
        filters: [],
        all_items: [],
        affiliates: [],
        items: [],
        campaigns:[],
      }
    },
    mounted() {
      // load campaigns and teams
      axios.get('/admin/team/list')
      .then(res => {
        console.log(res.data)
        this.all_items = res.data.teams
        this.all_items.forEach(item => {item.checked = false})
        this.campaigns = res.data.campaigns
        this.affiliates = res.data.affiliates
        this.loadItem(this.limit)
      })
      .catch(e => {
        console.log(e)
      })
    },
    computed: {
      limit() { return (this.page + 1) * this.size }
    },
    watch: {
      checkAll(val) { this.items.forEach(item => item.checked = val) },
    },
    methods: {
      newMember(val) {
        const data = {team_id: this.selected.id, affiliate_id: val.affiliate_id}
        axios.post('/admin/team/add_member', data)
        .then(res => {
          this.all_items = res.data.teams
          this.all_items.forEach(item => {item.checked = false})
          this.loadItem(this.limit)
        })
        .catch(e => {
          vuetifyToast.error('新しいメンバーを保存できません。 マネージャーに連絡するか、後で試してください。')
        })
        this.show_member_dlg = false
      },
      showAddMember(val) {
        this.selected = val
        this.show_member_dlg = true
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
      onNew(val) {
        axios.post('/admin/team/new', val)
        .then(res => {
          this.all_items = res.data.teams
          this.all_items.forEach(item => {item.checked = false})
          this.loadItem(this.limit)
        })
        .catch(e => {
          vuetifyToast.error('新しいチームを保存できません。 マネージャーに連絡するか、後で試してください。')
        })
        this.show_new_dlg = false
      },
      onDelete(val) {
        const selected_items = this.items.filter(item => item.checked)
        const ids = []
        selected_items.forEach(item => { ids.push(item.id)})

        axios.get(`admin/team/delete?ids=${ids.join()}`)
        .then(res => {
          this.all_items = res.data.teams
          this.all_items.forEach(item => {item.checked = false})
          this.loadItem(this.limit)
        })
        .catch(e => {
          vuetifyToast.error('チームを削除できません。 マネージャーに連絡するか、後で試してください。')
        })
        this.show_delete_dlg = false
      },
    }
  }
</script>

<style scoped>
  .sort {
    max-width:400px !important;
  }
  .search {
    max-width: 300px !important;
  }
</style>