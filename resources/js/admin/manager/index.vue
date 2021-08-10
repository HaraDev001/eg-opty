<template>
  <div class="page_wrap_vue pa-3 advertiser-page">
    <v-card class="mx-auto">
      <v-card-title class="_header">
        <v-container fluid>
          <v-row>
            <v-col>
              <h2 class="d-inline mr-1">管理者管理</h2>
            </v-col>
            <v-col class="d-flex justify-end">
              <v-btn
                class="mr-2"
                color="success"
                @click="show_new_dlg=true"
              >
                管理主登録
              </v-btn>
              <v-btn
                class="mr-2"
                color="info"
                @click="show_account_dlg=true"
              >
                アカウント管理
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
<!--              <th class="text-left" id="_th3">フリガナ</th>-->
              <th class="text-left" id="_th4">メールアドレス</th>
              <th class="text-left" id="_th5">権限</th>
              <th class="text-left" id="_th6">登録状況</th>
<!--              <th class="text-left" id="_th7"/>-->
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
              <td>{{ item.id }}</td>
              <td>{{ item.name_full }}</td>
<!--              <td>{{ item.furi_full}}</td>-->
              <td>{{ item.email }}</td>
              <td>{{ item.permission_label }}</td>
              <td>{{ item.status_label }}</td>
<!--              <td>-->
<!--                <v-btn color="#C694F9" dark @click="showDetail(item)">-->
<!--                  詳細-->
<!--                </v-btn>-->
<!--                <v-btn color="#F99494" dark @click="showDelete(item)">-->
<!--                  退会-->
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

    <NewDlg
      :dialog="show_new_dlg"
      @onNewDlgClose="show_new_dlg=false"
      @onCreated="onNew"
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
  import AccountDlg from "../../components/admin/manager/AccountDialog";
  import vuetifyToast from "vuetify-toast"

  export default {
    components: {AccountDlg, NewDlg},
    data() {
      return {
        show_new_dlg: false,
        show_account_dlg: false,
        selected: null,
        page: 0,
        size: 5,
        all_items: [],
        permissions: [],
        items: [],
      }
    },
    mounted() {
      // load managers
      axios.get('/admin/manager/list')
      .then(res => {
        this.all_items = res.data.managers
        this.loadItem(this.limit)
      })
      .catch(e => {
        vuetifyToast.error('管理者リストを取得できません。 後で試してください。')
      })
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
      showNew() {
        this.show_new_dlg = true
      },
      showAccount() {
        this.show_account_dlg = true
      },
      onNew(val) {
        this.all_items = val.map(v => v)
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
    }
  }
</script>