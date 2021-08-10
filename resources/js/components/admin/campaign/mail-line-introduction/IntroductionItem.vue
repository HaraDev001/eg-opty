<template>
  <v-card class="_mail-intro-item">
    <v-card-title class="_title">
      {{item.title}}
    </v-card-title>
    <v-card-text class="_content">
      <div v-html="item.content"/>
    </v-card-text>
    <v-card-actions>
      <v-btn dark color="purple darken--2" @click="show_detail_dlg=true">
        詳細
      </v-btn>
      <v-btn dark color="error" @click="$emit('onDelete', item)">
        削除
      </v-btn>
    </v-card-actions>
    <detail-introduction-dlg
      :item="item" :show="show_detail_dlg"
      @onDetailClose="show_detail_dlg=false"/>

  </v-card>
</template>

<script>
  import vuetifyToast from 'vuetify-toast'
  import DetailIntroductionDlg from "./DetailIntroductionDlg";

  export default {
    components: {DetailIntroductionDlg},
    props: {
      item: {
        type: Object,
        id: {type: Number, default: 0},
        title: {type: String, default: ''},
        url: {type: String, default: ''},
        content: {type: String, default: ''},
      }
    },
    data() {
      return {
        show_detail_dlg: false
      }
    }
  }
</script>

<style scoped lang="scss">
  ._mail-intro-item {
    margin-right: 10px;
    ._title {}
    ._subtitle {}
    ._content {}
  }
</style>