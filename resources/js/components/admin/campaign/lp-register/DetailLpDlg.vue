<template>
  <v-row justify="center">
    <v-dialog
      class="detail-lp-dialog"
      v-model="show"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-card-title class="_title">
          LP詳細
        </v-card-title>
        <v-divider/>
        <v-card-text class="_content">
          <v-row v-if="item.is_public">
            <v-col>
              <v-btn block>{{item.show_type_label}}</v-btn>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="3">タイトル</v-col>
            <v-col cols="9">{{item.title}}</v-col>
          </v-row>
          <v-row>
            <v-col cols="3">LP URL</v-col>
            <v-col cols="9">{{item.url}}</v-col>
          </v-row>
          <v-row>
            <v-col cols="12">
              <h4>成約後リダイレクトURL</h4>
            </v-col>
            <v-col cols="3">PC</v-col>
            <v-col cols="9">{{item.redirect_url_pc}}</v-col>
            <v-col cols="3">スマホ</v-col>
            <v-col cols="9">{{item.redirect_url_mobile}}</v-col>
          </v-row>
          <v-row>
            <v-col cols="3">公開設定</v-col>
            <v-col cols="9">{{item.public_label}}</v-col>
          </v-row>
          <v-row>
            <v-col cols="4" class="text-center">
              <p>メール登録フォームタグ</p>
              <p><v-btn>コピー</v-btn></p>
            </v-col>
            <v-col cols="4" class="text-center">
              <p>LINE登録フォームタグ</p>
              <p><v-btn>コピー</v-btn></p>
            </v-col>
            <v-col cols="4" class="text-center">
              <p>アフィリエイトリンク</p>
              <p><v-btn>コピー</v-btn></p>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <label class="mr-3">公開後、見えないようにする。</label>
              <v-switch class="d-inline-flex"/>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions class="_action justify-center">
          <v-btn @click="$emit('onDetailClose')">もどる</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
  export default {
    props: {
      show: {type:Boolean, default: false},
      item: {
        type: Object,
        id: {type: Number, default: 0},
        title: {type:String, default: ''},
        url: {type:String, default:''},
        banner: {type:String, default: ''},
        is_public: {type: Number, default: 1},
        redirect_pc: {type: String, default: ''},
        redirect_mobile: {type: String, default: ''},
        show_type: {type: String, default: 'banner'},
      },
    },
    data: vm => ({
    }),
    watch: {
      is_public(val) {
        if(val === 0) this.item.show_type = 'private'
      }
    },
    methods: {
    }
  }
</script>

<style scoped lang="scss">
  .v-list-item {
    margin: 5px !important;
    box-shadow: 1px 2px 3px #bbb;
  }
</style>