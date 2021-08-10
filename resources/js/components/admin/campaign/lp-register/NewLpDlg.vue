<template>
  <v-row justify="center">
    <v-dialog
      class="new-lp-dialog"
      v-model="show"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-card-title class="_title">
          LP新規登録設定
        </v-card-title>
        <v-divider/>
        <v-card-text class="_content">
          <v-form v-model="valid" ref="form">
            <v-row>
              <v-col cols="3" class="pt-5">タイトル</v-col>
              <v-col cols="9">
                <v-text-field
                  dense outlined hide-details="auto"
                  :rules="textRule"
                  v-model="item.title"
                />
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="3" class="pt-5">LP URL</v-col>
              <v-col cols="9">
                <v-text-field
                  dense outlined hide-details="auto"
                  :rules="urlRule"
                  v-model="item.url"
                />
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="3" class="pt-5">バナー登録</v-col>
              <v-col cols="5">
                <v-file-input
                  dense outlined hide-details="auto"
                  v-model="banner"
                />
              </v-col>
              <v-col cols="4">
                <v-switch
                  label="公開設定"
                  v-model="item.is_public"
                  :true-value="1" :false-value="0" hide-details class="mt-0"/>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12">
                <h4>成約後リダイレクトURL</h4>
              </v-col>
              <v-col cols="3" class="pt-5">PC</v-col>
              <v-col cols="9">
                <v-text-field
                  outlined dense hide-details="auto"
                  :rules="urlRule"
                  v-model="item.redirect_url_pc"
                />
              </v-col>
              <v-col cols="3" class="pt-5">スマホ</v-col>
              <v-col cols="9">
                <v-text-field
                  outlined dense hide-details="auto"
                  :rules="urlRule"
                  v-model="item.redirect_url_mobile"
                />
              </v-col>
            </v-row>
            <v-row v-if="item.is_public === 1">
              <v-col>
                <v-card>
                  <v-card-text>
                    <v-list>
                      <v-list-item-group v-model="item.show_type">
                        <v-list-item key="0" :value="1" active-class="primary white--text" class="justify-center">
                          バナー表示
                        </v-list-item>
                        <v-list-item key="1" :value="2" active-class="primary white--text" class="justify-center">
                          タイトル
                        </v-list-item>
                      </v-list-item-group>
                    </v-list>
                  </v-card-text>
                </v-card>
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>
        <v-card-actions class="_action justify-center">
          <v-btn
            :disabled="!valid"
            dark
            color="info"
            @click="save(0)"
          >下書き</v-btn>
          <v-btn
            @click="$emit('onNewClose')"
          >キャンセル</v-btn>
          <v-btn
            dark success
            color="purple"
            :disabled="!valid"
            @click="save(1)"
          >保存</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
  import vuetifyToast from "vuetify-toast"

  export default {
    props: {
      show: {type:Boolean, default: false},
      campaign_id: {type:Number, default: 0}
    },
    data: vm => ({
      banner: null,
      valid: false,
      textRule: [ v => !!v || '必須フィールド', ],
      urlRule: [
        v => !!v || 'URLは空にできません。',
        v => /^(ftp|http|https):\/\/[^ "]+$/.test(v) || '無効なURL'
      ],
      item: {
        id: 0,
        campaign_id: 0,
        title: '',
        url: '',
        banner: null,
        is_public: 1,
        redirect_url_pc: '',
        redirect_url_mobile: '',
        show_type: 1,
        status: 0
      },
    }),
    watch: {
      is_public(val) {
        if(val === 0) this.item.show_type = 0
      },
    },
    methods: {
      save(flag) {
        this.item.status = flag
        if(this.banner) {
          let formData = new FormData()
          Object.keys(this.item).forEach(v => {
            if(v === 'banner') {
              formData.append('banner', this.banner, this.banner.name)
            } else if(v === 'campaign_id') {
              formData.append(v, this.campaign_id)
            } else {
              formData.append(v, this.item[v])
            }
          })
          console.log(formData)
          axios.post(`/admin/campaign/lp/save`, formData, {
            headers: {'Content-Type': 'multipart/form-data'}
          })
            .then( res => {
              this.$emit('onNewLp')
            })
            .catch(e => {
              console.log(e.response)
              if(e.response.data.hasOwnProperty('errors')) {
                const errors = e.response.data.errors
                if(errors.hasOwnProperty('campaign_id')) vuetifyToast.error('広告主を選択してください。');// 出稿広告主
                if(errors.hasOwnProperty('title')) vuetifyToast.error('キャンペーンのタイトルを入力してください。');// キャンペーン名
                if(errors.hasOwnProperty('url')) vuetifyToast.error('バナー画像を選択してください。');// アイキャッチ画像
                if(errors.hasOwnProperty('banner')) vuetifyToast.error('キャンペーン期間を選択してください。');// キャンペーン期間
                if(errors.hasOwnProperty('redirect_url_pc')) vuetifyToast.error('Youtube予告URLを入力してください。');// Youtube予告URL
                if(errors.hasOwnProperty('redirect_url_mobile')) vuetifyToast.error('を入力してください。');// アフィリエイター向け PR文
              } else {
                vuetifyToast.error('サーバーエラー。 後で試してください。')
              }
            })
        } else {
          vuetifyToast.error('バナー画像を選択してください。');// アイキャッチ画像
        }

        this.$emit('onNewLp')
      }
    }
  }
</script>

<style scoped lang="scss">
  .v-list-item {
    margin: 5px !important;
    box-shadow: 1px 2px 3px #bbb;
  }
</style>