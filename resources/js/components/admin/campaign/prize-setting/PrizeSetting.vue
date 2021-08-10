<template>
  <v-card class="prize-setting">
    <v-container fluid>
      <v-card-title>
        <v-row>
          <v-col cols="12">
            <h3>賞品設定</h3>
            <v-btn color="info" @click="show_new=true">新規追加</v-btn>
          </v-col>
        </v-row>
      </v-card-title>
      <v-divider/>
      <v-card-text>
        <PrizeItem v-for="(item, k) in items" :key="k" :item="item" @onDeleteItem="deleteItem"/>
      </v-card-text>
    </v-container>

    <NewPrizeDlg :show="show_new" @onNew="saveNew" @onCancel="show_new=false"/>
  </v-card>
</template>

<script>
  import vuetifyToast from "vuetify-toast"
  import PrizeItem from "./PrizeItem";
  import NewPrizeDlg from "./NewPrizeDlg";

  export default {
    components: {NewPrizeDlg, PrizeItem},
    props: {
      campaign_id: {type:Number, default: 0},
    },
    data: vm => ({
      items: [],
      show_new: false,
      prev_url: '',
      image: null
    }),
    mounted() {
      axios.get(`/admin/campaign/prize/list/${this.campaign_id}`)
      .then(res => {
        console.log(res.data)
        this.items = res.data.prizes
      })
      .catch(e => {
        vuetifyToast.error('サーバーから賞品リストを取得できません。 マネージャーに連絡するか、後で試してください。')
      })
    },
    methods: {
      deleteItem(item) {
        axios.get(`/admin/campaign/prize/delete/${item.id}`)
        .then(res => {
          this.items = res.data.prizes
        })
        .catch(e => {
          vuetifyToast.error('サーバーへの賞品は削除できません。 マネージャーに連絡するか、後で試してください。')
        })
      },
      saveNew(item) {
        console.log(item)
        const index = this.items.findIndex(v => v.contract_rank === item.contract_rank)
        if(index > -1) {
          vuetifyToast.error(`${item.contract_rank}位の賞品はすでに登録されています。`)
          return
        }
        item.campaign_id = this.campaign_id
        const formData = new FormData()
        const keys = Object.keys(item)
        keys.forEach(key => {
          if(key === 'image') {
            formData.append(key, item[key], item[key].name)
          } else {
            formData.append(key, item[key])
          }
        })
        axios.post(`/admin/campaign/prize/save`, formData, {
          headers: {'Content-Type': 'multipart/form-data'}
        })
        .then(res => {
          this.items = res.data.prizes
        })
        .catch(e => {
          vuetifyToast.error('新しい賞品をサーバーに保存できません。 マネージャーに連絡するか、後で試してください。')
        })
        this.show_new = false
      }
    }
  }
</script>

<style scoped>
</style>