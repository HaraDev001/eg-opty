<template>
  <v-card class="line-register">
    <v-container fluid>
      <v-card-title>
        <v-row>
          <v-col cols="12">
            <h3>LINE連携</h3>
          </v-col>
        </v-row>
      </v-card-title>
      <v-divider/>
      <v-card-text>
        <v-form v-model="valid">
          <v-row>
            <v-col cols="3">チャネルURL</v-col>
            <v-col cols="9">
              <v-text-field
                :rules="urlRule"
                v-model="item.channel_url"
                outlined dense hide-details="auto"/>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="3">チャネルシークレット</v-col>
            <v-col cols="9">
              <v-text-field
                :rules="textRule"
                v-model="item.channel_secret"
                outlined dense hide-details="auto"/>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="3">アクセストークン</v-col>
            <v-col cols="9">
              <v-text-field
                :rules="textRule"
                v-model="item.access_token"
                outlined dense hide-details="auto"/>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="3">リダイレクトURL</v-col>
            <v-col cols="9">
              <v-text-field
                :rules="urlRule"
                v-model="item.redirect_url"
                outlined dense hide-details="auto"/>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="3">あいさつ画像</v-col>
            <v-col cols="9">
              <v-img
                :src="item.image_url"
                contain
                class="_preview"
                width="200" height="200"
              />
              <v-file-input
                class="img-select"
                v-model="image"
                accept="image/*"
                prepend-icon="mdi-camera"
                @change="imgSelect"
              />
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>
      <v-card-actions class="d-flex justify-center">
        <v-btn
          :disabled="!valid"
          color="success" dark @click="register"
        >保存</v-btn>
      </v-card-actions>
    </v-container>
  </v-card>
</template>

<script>
  import vuetifyToast from "vuetify-toast"

  export default {
    props: {
      campaign_id: {type:Number, default:0}
    },
    data: vm => ({
      valid: false,
      item: {
        id: 0,
        campaign_id: 0,
        channel_url: '',
        channel_secret: '',
        access_token: '',
        redirect_url: '',
        image_url: '',
      },
      preview_url: '',
      image: null,
      textRule: [v => !!v || '必須フィールド'],
      urlRule: [
        v => !!v || '必須フィールド',
        v => /^(ftp|http|https):\/\/[^ "]+$/.test(v) || '無効なURL'
      ],
    }),
    mounted() {
      axios.get(`/admin/campaign/line-account/get/${this.campaign_id}`)
      .then(res => {
        if(res.data.account !== null) {
          this.item = res.data.account
        }
      })
      .catch(e => {
        vuetifyToast.error('サーバーからラインアカウントを取得できません。')
      })
    },
    methods: {
      register() {
        if(this.item.image_url === '' || (this.item.id === 0 && this.image === null)) {
          vuetifyToast.error('画像を選択してください。')
          return
        }
        this.item.campaign_id = this.campaign_id
        const formData = new FormData()
        const keys = Object.keys(this.item)
        keys.forEach(key => {
          formData.append(key, this.item[key])
        })
        if(this.image) {
          formData.append('image', this.image, this.image.name)
        }
        axios.post(`/admin/campaign/line-account/save`, formData, {
          headers: {'Content-Type': 'multipart/form-data'}
        })
        .then(res => {
          this.item = res.data.account
        })
        .catch(e => {
          vuetifyToast.error('ラインアカウントを保存できません。')
        })
      },
      imgSelect() {
        console.log(this.image)
        this.item.image_url = URL.createObjectURL(this.image)
      }
    }
  }
</script>

<style scoped>
  .img-select {
    display: inline-flex;
    width: 300px;
  }
  ._preview {
    border: 1px solid #aaa;
    border-radius: 7px;
    display: inline-flex;
    margin-right: 20px;
  }
</style>