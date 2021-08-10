<template>
  <div class="page_wrap_vue pa-3 advertiser-page">
    <v-card class="mx-auto">
      <v-card-title class="_header">
        <v-container fluid>
          <v-row>
            <v-col>
              <h3 class="d-inline mr-1">アフィリエイター個人管理</h3>
            </v-col>
            <v-col class="d-flex justify-end">
              <v-btn
                class="mr-2"
                color="error" dark
                @click="show_delete_dlg = true"
              >
                削除
              </v-btn>
              <v-btn
                class="mr-2"
                color="info" dark
                @click="show_new_dlg = true"
              >
                新規
              </v-btn>
            </v-col>
          </v-row>
          <v-row>
            <v-col class="d-flex justify-space-between">
              <v-text-field
                outlined
                dense
                placeholder="検索"
                class="search"
                append-outer-icon="mdi-magnify"
              />
              <v-btn
                color="info"
                dark
                rounded
                class="white--text"
                to="/admin/affiliate-team"
              >
                チーム管理
              </v-btn>
            </v-col>
          </v-row>
          <v-row>
            <v-col class="d-flex justify-space-between">
              <v-chip-group
                v-model="filter"
                column
                active-class="primary white--text"
              >
                <v-chip :value="0">全て</v-chip>
                <v-chip v-for="rank in ranks" :key="rank.id" :value="rank.id">
                  {{ rank.name }}
                </v-chip>
              </v-chip-group>
              <v-select
                label="表示順"
                outlined dense
                v-model="sort"
                :items="sorts"
                item-text="text" item-value="value"
                class="sort"
              />
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
              <th><v-checkbox v-model="checkAll"/></th>
              <th class="text-left" id="_th1">ID</th>
              <th class="text-left" id="_th2">User name / Name</th>
              <th class="text-left" id="_th3">RANK</th>
              <th class="text-left" id="_th4">Mail Address</th>
              <th class="text-left" id="_th5">Status</th>
              <th class="text-left" id="_th6">Joined</th>
              <th class="text-left" id="_th7"> </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
              <th><v-checkbox v-model="item.checked"/></th>
              <td>{{ item.id }}</td>
              <td>{{ item.name_last }} {{ item.name_first }}</td>
              <td>{{ item.rank.name }}</td>
              <td>{{ item.email }}</td>
              <td>{{ item.status_label }}</td>
              <td>{{ $date(item.created_at).format('YYYY/MM/DD HH:mm') }}</td>
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
      :ranks="ranks"
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
      @onDeleteDlgCancel="show_delete_dlg=false"
      @onDeleteDlgOk="onDelete"
    />
  </div>
</template>

<script>
  import NewDialog from "../../components/admin/affiliate/NewDialog";
  import EditDialog from "../../components/admin/affiliate/EditDialog";
  import DeleteDialog from "../../components/admin/affiliate/DeleteDialog";
  import DetailDialog from "../../components/admin/affiliate/DetailDialog";
  import vuetifyToast from 'vuetify-toast'

  export default {
    components: {DetailDialog, DeleteDialog, EditDialog, NewDialog, },
    data() {
      return {
        show_new_dlg: false,
        show_edit_dlg: false,
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
        filter: 0,
        ranks:[],
        drafts: [],
        sort: '',
        sorts: [
          {text: 'ID番号順', value: 'id'},
          {text: '登録日時順', value: 'date'},
          {text: 'ランク順', value: 'rank'},
        ]
      }
    },
    mounted() {
      axios.get('/admin/affiliate/list')
      .then(res => {
        this.all_items = res.data.affiliates
        this.all_items.forEach(item => item.checked = false)
        this.ranks = res.data.ranks
        this.loadItem(this.limit)
      })
      .catch(e => {
        vuetifyToast.error('アフィリエイトデータを取得できません。')
      })
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
      sort() {
        this.loadItem(this.limit)
      },
      filter() {
        this.loadItem(this.limit)
      }
    },
    methods: {
      getItems() {
        let tmp = this.all_items
        if(this.filter !== 0) {
          tmp = tmp.filter(item => item.rank_id === this.filter)
        }
        if(this.sort === 'id') {
          tmp.sort((a, b) => a.id - b.id)
        }
        if(this.sort === 'date') {
          tmp.sort(function(a, b) {
            const atime = new Date(a.created_at).getTime()
            const btime = new Date(b.created_at).getTime()
            return atime - btime
          })
        }
        if(this.sort === 'rank') {
          tmp.sort((a, b) => a.rank_id - b.rank_id)
        }
        return tmp
      },
      showMore() {
        this.page++
        const start = this.page * this.size
        const end = start + this.size
        const new_items = this.all_items.filter((item, key) => key >= start && key < end)
        this.items = [...this.items, ...new_items]
      },
      showTeamManage() {

      },
      loadItem(limit) {
        const tmp = this.getItems()
        this.items = tmp.slice(0, limit)
      },
      findItem(qid) {
        const item = this.items.find(item => item.id === qid)
        if (item === undefined) return false
        this.selected = item
        return true
      },
      showDetail(item) {
        this.selected = item
        // axios.get('/admin/affiliate/get/')
        this.show_detail_dlg = true
      },
      onNew(val) {
        this.all_items = val
        this.loadItem(this.limit)
        this.show_new_dlg = false
      },
      onDelete() {
        this.show_delete_dlg = false
        /**
        * delete Qa from server
        */
        const ids = []
        this.items.forEach(item => {if(item.checked) ids.push(item.id)})
        if(ids.length === 0) {
          vuetifyToast.error('削除するアフィリエイトを選択してください。')
          return
        }

        const sids = ids.join()
        axios.get(`/admin/affiliate/delete?ids=${sids}`)
        .then(res => {
          this.all_items = res.data.affiliates
          this.loadItem(this.limit)
        })
        .catch(e => {
          vuetifyToast.error('アフィリエイトを削除できません。マネージャーに連絡するか、後で試してください。')
        })
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