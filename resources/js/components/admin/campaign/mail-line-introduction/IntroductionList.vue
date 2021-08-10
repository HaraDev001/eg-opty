<template>
  <v-container fluid>
    <v-card class="_line-intro-list">
      <v-card-title>
        <v-row>
          <v-col cols="6">
            <h3 class="_title">{{item.title}}</h3>
            <small class="_url">{{item.url}}</small>
          </v-col>
          <v-col cols="6" class="d-flex justify-end">
            <v-btn
              dark color="success" class="mr-2"
              @click="show_new_dlg=true"
            >
              新規
            </v-btn>
<!--            <v-btn-->
<!--              dark color="primary"-->
<!--              @click="save"-->
<!--            >-->
<!--              下書き-->
<!--            </v-btn>-->
          </v-col>
        </v-row>
      </v-card-title>
      <v-card-text class="_content">
        <v-slide-group v-if="introductions.length > 0">
          <v-slide-item v-for="(intro, i) in introductions" :key="i">
            <IntroductionItem
              :item="intro"
              @onDelete="showDelete(intro)"
              @onDetail="showDetail(intro)"
            />
          </v-slide-item>
        </v-slide-group>
        <h3 v-else>登録済みの紹介はありません。</h3>
      </v-card-text>

    </v-card>

    <new-introduction-dlg
      :show="show_new_dlg"
      @onNewClose="show_new_dlg=false"
      @onNew="addItem"/>
    <delete-introduction-dlg
      :item="selected" :show="show_delete_dlg"
      @onDeleteConfirm="deleteConfirm"
      @onDeleteClose="show_delete_dlg=false"
    />

    <scale-loader color="orange darken--1" loading="loading" height="70" width="7"/>
  </v-container>
</template>

<script>
  import vuetifyToast from 'vuetify-toast'
  import NewIntroductionDlg from "./NewIntroductionDlg";
  import DeleteIntroductionDlg from "./DeleteIntroductionDlg";
  import IntroductionItem from "./IntroductionItem";

  export default {
    components: {IntroductionItem, DeleteIntroductionDlg, NewIntroductionDlg},
    props: {
      target: {type: String, default: ''},
      item: {
        type: Object,
        id: { type: Number, default: 0},
        title: {type: String, default: ''},
        url: {type: String, default: ''},
        introductions: {type: Array, default: []}
      }
    },
    data: () => ({
      loading: false,
      new_intro: '',
      selected: {id: 0, title: '', url: '', content: ''},
      show_new_dlg: false,
      show_detail_dlg: false,
      show_delete_dlg: false,

    }),
    computed: {
      introductions() {
        if(this.item === null || this.item === undefined) return []
        return this.item.introductions.filter(v => v.target === this.target)
      }
    },
    methods: {
      showDetail(item) {
        this.selected = item
        this.show_detail_dlg = true
      },
      showDelete(item) {
        this.selected = item
        this.show_delete_dlg = true
      },
      deleteConfirm(item) {
        axios.get(`/admin/campaign/mail-line-intro/delete/${item.id}`)
        .then(res => {
          this.item.introductions = res.data.introductions
          this.show_delete_dlg = false
        })
        .catch(e => {
          vuetifyToast.error('紹介を削除できません。')
        })
      },
      addItem(item) {
        item.target = this.target
        axios.post(`/admin/campaign/mail-line-intro/new/${this.item.id}`, item)
        .then(res => {
          this.item = res.data.lp
          this.show_new_dlg = false
        })
        .catch(e => {
          vuetifyToast.error('紹介を保存できません。')
        })
      },
    }
  }
</script>

<style scoped lang="scss">
  ._line-intro-list {
    ._title {
      font-size: 1.2rem !important;
    }
    ._url {
      font-size: 0.8rem !important;
    }
    ._content {
      display: flex;
      /*overflow-x: scroll;*/
    }
  }
</style>