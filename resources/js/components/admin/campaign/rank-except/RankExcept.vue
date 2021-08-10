<template>
  <v-card>
    <v-container fluid>
      <v-card-title>
        <v-row>
          <v-col cols="12">
            <h3>ランキング対象外者</h3>
          </v-col>
        </v-row>
      </v-card-title>

      <v-card-text>
        <v-row>
          <v-col cols="12">
            <v-btn color="info" @click="show_new=true">登録</v-btn>
          </v-col>
          <v-col cols="12">
            <label>
              キャンペーン期間&emsp;
              {{$date(campaign.date_start + ' ' + campaign.time_start).format('YYYY/MM/DD HH:mm')}} -
              {{$date(campaign.date_end + ' ' + campaign.time_end).format('YYYY/MM/DD HH:mm')}}
            </label>
          </v-col>
        </v-row>
        <v-divider/>
        <v-row>
          <v-col cols="6">
            <v-row>
              <v-col cols="8">アフィリエイター名</v-col>
              <v-col cols="4">ランク</v-col>
            </v-row>
          </v-col>
          <v-col cols="6">
            <v-row>
              <v-col cols="8">アフィリエイター名</v-col>
              <v-col cols="4">ランク</v-col>
            </v-row>
          </v-col>
          <v-col cols="6" v-for="(item, i) in items" :key="i">
            <ExceptItem :item="item" @onExceptDelete="showDelete"/>
          </v-col>
        </v-row>
      </v-card-text>
    </v-container>
    <NewExceptDlg :show="show_new" :affiliates="affiliates" :teams="teams"
                  @onNewClose="show_new=false" @onNewExcept="saveNewExcept"/>
    <DeleteExceptDlg :show="show_delete" :item="selected"
                     @onDeleteClose="show_delete=false" @onDeleteConfirm="deleteExcept"/>
  </v-card>
</template>

<script>
  import ExceptItem from "./ExceptItem";
  import NewExceptDlg from "./NewExceptDlg";
  import DeleteExceptDlg from "./DeleteExceptDlg";
  import vuetifyToast from "vuetify-toast"

  export default {
    components: {DeleteExceptDlg, NewExceptDlg, ExceptItem},
    props: {
      campaign_id: {type: Number, default: 0},
    },
    data: vm => ({
      campaign: {date_start:'', time_start:'', date_end:'', time_end:''},
      items: [],
      selected: {id:0, campaign_id:0, affiliatea_id: 0},
      affiliates: [],
      teams: [],
      show_new: false,
      show_delete: false,
    }),
    mounted() {
      axios.get(`/admin/campaign/rank-except/list/${this.campaign_id}`)
      .then(res => {
        this.campaign = res.data.campaign
        this.items = this.campaign.rank_excepts
        this.affiliates = res.data.affiliates.map(v => {v.id_name = v.id + ' ' + v.name_full; return v})
        this.teams = res.data.teams.map(v => {v.id_name = v.id + ' ' + v.name; return v})
      })
      .catch(e => {
        vuetifyToast.error('ランキング例外リストを取得できません。')
      })
    },
    methods: {
      showDelete(item) {
        this.selected = item
        this.show_delete = true
      },
      saveNewExcept(item) {
        console.log(item)
        const data = {
          campaign_id: this.campaign_id,
        }
        if(item.search_type === 'team') {
          data.team_id = item.team_id
        } else {
          data.affiliate_id = item.member_id
        }
        axios.post('/admin/campaign/rank-except/new', data)
        .then(res => {
          this.items = res.data.list
        })
        .catch(e => {
          vuetifyToast.error('データを保存できません。 後で試してください。')
        })
        this.show_new = false
      },
      deleteExcept(item) {
        console.log(item)
        axios.get(`/admin/campaign/rank-except/delete/${item.id}`)
        .then(res => {
          this.items = res.data.list
        })
        .catch(e => {
          vuetifyToast.error('データを削除できません。 後で試してください。')
        })
        this.show_delete = false
      },
    }
  }
</script>

<style scoped>
</style>