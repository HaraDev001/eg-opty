<template>
  <div class="page_wrap_vue pa-3 campaign-page">
    <v-card class="mx-auto">
      <v-container
        class="campaign-page_header"
        fuild
      >
        <v-row class="campaign-page_header_title">
          <v-col cols="12">
            <h2>キャンペーン一覧</h2>
          </v-col>
        </v-row>
        <v-row class="campaign-page_header_toolbar">
          <v-col cols="12">
            <v-btn
              class="campaign-page_header_toolbar_button"
              to="/admin/campaign/new"
            >
              新規作成
            </v-btn>
            <v-btn
              class="campaign-page_header_toolbar_button"
              @click="show_edit_campaign_dlg = true"
            >
              下書き
            </v-btn>
            <v-select
              class="campaign-page_header_toolbar_sort"
              :items="sort_orders"
              item-text="label"
              item-value="value"
              label="表示順"
            />
          </v-col>
        </v-row>
      </v-container>

      <v-container class="campaign-page_container" fluid>
        <v-row dense>
          <v-col
            v-for="card in cards"
            :key="card.id"
            cols="4"
          >
            <CampaignItem :item="card"/>
          </v-col>
        </v-row>
      </v-container>
    </v-card>
<!--    <NewCampaignDialog :dialog="show_new_campaign_dlg"/>-->
<!--    <EditCampaignDialog :dialog="show_edit_campaign_dlg"/>-->
  </div>
</template>

<script>
  import CampaignItem from "../../components/admin/campaign/CampaignItem";
  // import NewCampaignDialog from "../../components/admin/campaign/NewCampaignDialog";
  // import EditCampaignDialog from "../../components/admin/campaign/EditCampaignDialog";
  import vuetifyToast from 'vuetify-toast'

  export default {
    components: {CampaignItem, /*NewCampaignDialog, EditCampaignDialog*/},
    data() {
      return {
        show_new_campaign_dlg: false,
        show_edit_campaign_dlg: false,
        sort_orders: [
          {value: 'latest', label: '最新順'},
          {value: 'price_high', label: '単価高い順'},
          {value: 'expected_reward', label: '報酬予定額順'},
        ],
        cards: []
      }
    },
    mounted() {
      const flag = 1 // 1: posted, 0: drafts
      axios.get(`/admin/campaign/list/${flag}`)
      .then(res => {
        console.log(res.data)
        const campaigns = res.data.campaigns
        this.cards = campaigns.map(c => {
          c.block_rate = c.register_number === 0 ? 0 : c.block_number * 100 / c.register_number
          return c
        })
      })
      .catch(e => {
        console.log(e.response)
        vuetifyToast.error('サーバーエラー。 マネージャーに連絡するか、後で試してください。')
      })
    }
  }
</script>