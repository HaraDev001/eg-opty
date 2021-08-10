<template>
  <v-card class="_mail-line-introduction">
    <v-container fluid>
      <v-card-title class="_title">
        <v-row>
          <v-col cols="12">
            <h3>メール/LINE紹介文</h3>
          </v-col>
        </v-row>
      </v-card-title>

      <v-card-text>
        <v-tabs
          background-color="white"
          color="deep-purple accent-4"
          v-model="tab"
        >
          <v-tab key="mail">メール</v-tab>
          <v-tab key="line">LINE</v-tab>
        </v-tabs>
      </v-card-text>
      <v-card-text class="_content">
        <v-tabs-items v-model="tab">
          <v-tab-item key="mail">
            <IntroductionList v-for="(lp, i) in lps" :key="i" :item="lp" :target="'mail'"/>
          </v-tab-item>
          <v-tab-item key="line">
            <IntroductionList v-for="(lp, i) in lps" :key="i" :item="lp" :target="'line'"/>
          </v-tab-item>
        </v-tabs-items>
      </v-card-text>
    </v-container>
  </v-card>
</template>

<script>
  import IntroductionList from "./IntroductionList"
  import vuetifyToast from 'vuetify-toast'

  export default {
    components: {IntroductionList},
    props: {
      campaign_id: {type: Number, default: 0},
    },
    data() {
      return {
        tab: 'mail',
        lps: [],
      }
    },
    mounted() {
      axios.get(`/admin/campaign/mail-line-intro/lp_list/${this.campaign_id}`)
      .then(res => {
        this.lps = res.data.lps
      })
      .catch(e => {
        vuetifyToast.error('サーバーからLPリストを取得できません。')
      })
    },
    methods: {
      saveLineRichImage(item) {

      }
    }
  }
</script>

<style scoped lang="scss">
  ._line-rich-images {
    ._content {
      padding: 15px;
      max-height: 600px !important;
      overflow-y: scroll;
    }
  }
</style>