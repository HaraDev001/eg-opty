<template>
  <v-card>
    <v-container fluid>
      <v-card-title>
        <v-row>
          <v-col cols="12">
            <h3>LP登録</h3>
          </v-col>
        </v-row>
      </v-card-title>

      <v-card-text>
        <v-row>
          <v-col cols="12">
            <v-btn
              dark color="success"
              @click="show_new=true"
            >新規</v-btn>
            <v-btn
              v-if="!show_draft"
              dark color="info"
              @click="show_draft=true"
            >
              下書き
            </v-btn>
            <v-btn
              v-else
              dark color="info"
              @click="show_draft=false"
            >
              LPs
            </v-btn>
          </v-col>
        </v-row>
        <v-row>
          <v-col v-if="items.length > 0">
            <v-slide-group class="pa-4">
              <v-slide-item
                v-for="(lp, i) in items"
                :key="i"
              >
                <LpItem :item="lp" @onLpDetail="showDetail" @onLpDelete="showDelete"/>
              </v-slide-item>
            </v-slide-group>
          </v-col>
          <v-col v-else class="text-center">
            <h3>登録されたLPはありません。</h3>
          </v-col>
        </v-row>
      </v-card-text>
    </v-container>
    <NewLpDlg :show="show_new" :campaign_id="campaign_id" @onNewClose="show_new=false" @onNewLp="saveNewLp"/>
    <DetailLpDlg :show="show_detail" :item="selected" @onDetailClose="show_detail=false"/>
    <DeleteLpDlg :show="show_delete" :item="selected" @onDeleteCancel="show_delete=false" @onDeleteConfirm="deleteLp"/>
  </v-card>
</template>

<script>
  import LpItem from "./LpItem"
  import NewLpDlg from "./NewLpDlg";
  import DetailLpDlg from "./DetailLpDlg"
  import DeleteLpDlg from "./DeleteLpDlg"
  export default {
    components: {DetailLpDlg, NewLpDlg, LpItem, DeleteLpDlg},
    props: {
      campaign_id: {type: Number, default: 0}
    },
    data: vm => ({
      selected: {id:0, title:'', url:'', banner:'', is_public: 1, redirect_url_pc:'', redirect_url_mobile:'', show_type: 0},
      show_new: false,
      show_detail: false,
      show_delete: false,
      all_items: [],
      items: [],
      show_draft: false,
    }),
    mounted() {
      this.loadLpList()
    },
    watch: {
      show_draft(val) {
        console.log('show_draft=', val)
        this.filterLPs(val)
      }
    },
    methods: {
      loadLpList() {
        if(this.campaign_id === 0) {
          console.log('empty campaign id')
          return
        }
        axios.get(`/admin/campaign/lp/list/${this.campaign_id}`)
        .then(res => {
          this.all_items = res.data.lps
          this.filterLPs(this.show_draft)
        })
        .catch(e => {
          vuetifyToast.error('サーバーからLPリストを取得できません。 後で試してください。')
        })
      },
      filterLPs(isDraft) {
        this.items = this.all_items.filter(e => e.status === (isDraft ? 0 : 1))
      },
      saveNewLp() {
        this.show_new = false
        this.loadLpList()
      },
      showDetail(item) {
        this.selected = item
        this.show_detail = true
      },
      showDelete(item) {
        this.selected = item
        this.show_delete = true
      },
      deleteLp(item) {
        this.show_delete = false
        console.log(item)
        axios.get(`/admin/campaign/lp/delete/${item.id}`)
        .then(res => {
          this.loadLpList()
        })
        .catch(e => {
          vuetifyToast.error('LPを削除できませんでした。 後で試してください。')
        })
      }
    }
  }
</script>

<style scoped>

</style>