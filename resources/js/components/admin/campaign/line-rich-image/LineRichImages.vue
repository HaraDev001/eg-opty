<template>
  <v-card class="_line-rich-images">
    <v-container fluid>
      <v-card-title class="_title">
        <v-row>
          <v-col cols="12">
            <h3>LINE用リッチ画像</h3>
          </v-col>
        </v-row>
      </v-card-title>

      <v-card-text class="_content">
        <v-row v-if="lps.length > 0">
          <v-col cols="12" v-for="(lp, i) in lps" :key="i">
            <LineRichImageList :item="lp" @onSave="saveLineRichImage"/>
          </v-col>
        </v-row>
        <v-row v-else>
          <v-col cols="12">
            <h3 class="text-center">登録されたLPはありません。</h3>
          </v-col>
        </v-row>
      </v-card-text>
    </v-container>
  </v-card>
</template>

<script>
  import LineRichImageList from "./LineRichImageList";
  import vuetifyToast from 'vuetify-toast'

  export default {
    name: "SettingStory",
    components: {LineRichImageList},
    props: {
      campaign_id: { type: Number, default: 0 }
    },
    data() {
      return {
        lps: [],
      }
    },
    mounted() {
      axios.get(`/admin/campaign/line-rich-image/lp_list/${this.campaign_id}`)
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