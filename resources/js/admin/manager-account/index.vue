<template>
  <div class="page_wrap_vue pa-3 manager-account-page">
    <v-card class="mx-auto">
      <v-card-title class="_header">
        <v-row>
          <v-col cols="12" class="d-flex justify-space-between pa-0">
            <h3 class="d-inline mr-1">管理アカウント</h3>
            <v-btn
              dense dark rounded color="info"
              to="/admin/manager-account/bank-account"
            >
              振込口座情報
            </v-btn>
          </v-col>
        </v-row>
      </v-card-title>
    </v-card>

    <v-card>
      <v-container>
        <v-row>
          <v-col cols="4">
            <v-col cols="12" class="d-flex justify-center">
              <v-img
                max-width="200" max-height="200"
                contain
                alt="Avatar"
                class="_avatar"
                :src="prev_url"
              />
            </v-col>
            <v-col cols="12" class="d-flex justify-center">
              <v-file-input
                prepend-icon="mdi-account-box"
                hint="200px × 200pxの画像をアップロードしてください。"
                persistent-hint
                v-model="avatar"
                ref="avatar"
                @change="imgSelect"
              />
            </v-col>
          </v-col>
          <v-col cols="8">
            <v-row class="pb-2">
              <v-col cols="3" class="text-right py-0">お名前</v-col>
              <v-col cols="4" class="py-0">
                <v-text-field outlined dense hide-details label="姓" v-model="name_last" :rules="name_rule"/>
              </v-col>
              <v-col cols="4" class="py-0">
                <v-text-field outlined dense hide-details label="名" v-model="name_first" :rules="name_rule"/>
              </v-col>
              <v-col cols="1" class="pa-0">
                <v-chip color="#04282C" class="white--text">必須</v-chip>
              </v-col>
            </v-row>
            <v-row class="pb-2">
              <v-col cols="3" class="text-right py-0">フリガナ</v-col>
              <v-col cols="4" class="py-0">
                <v-text-field outlined dense hide-details label="セイ" v-model="furi_last" :rules="name_rule"/>
              </v-col>
              <v-col cols="4" class="py-0">
                <v-text-field outlined dense hide-details label="メイ" v-model="furi_first" :rules="name_rule"/>
              </v-col>
              <v-col cols="1" class="pa-0">
                <v-chip color="#04282C" class="white--text">必須</v-chip>
              </v-col>
            </v-row>
            <v-row class="pb-2">
              <v-col cols="3" class="text-right py-0">ニックネーム</v-col>
              <v-col cols="8"  class="py-0">
                <v-text-field outlined dense hide-details v-model="nickname" :rules="name_rule"/>
              </v-col>
              <v-col cols="1" class="pa-0">
                <v-chip color="#04282C" class="white--text">必須</v-chip>
              </v-col>
            </v-row>
            <v-row class="pb-2">
              <v-col cols="3" class="text-right py-0">性別</v-col>
              <v-col cols="8" class="py-0">
                <v-select
                  dense outlined hide-details
                  placeholder="選択してください。"
                  v-model="gender"
                  :items="[{text:'男性', value: 1}, {text:'女性', value: 2}]"
                  item-text="text" item-value="value"
                />
              </v-col>
              <v-col cols="1" class="pa-0">
                <v-chip color="grey lighten-3">任意</v-chip>
              </v-col>
            </v-row>
            <v-row class="pb-2">
              <v-col cols="3" class="text-right py-0">生年月日</v-col>
              <v-col cols="8" class="py-0">
                <v-select
                  dense outlined hide-details
                  v-model="year"
                  :items="years"
                  class="_years d-inline-block mr-2"
                />
                <v-label>年</v-label>
                <v-select
                  dense outlined hide-details
                  v-model="month"
                  :items="[1,2,3,4,5,6,7,8,9,10,11,12]"
                  class="_months d-inline-block mx-2"
                />
                <v-label>月</v-label>
                <v-select
                  dense outlined hide-details
                  v-model="date"
                  :items="dates"
                  class="_dates d-inline-block ml-2"
                />
                <v-label>日</v-label>
              </v-col>
              <v-col cols="1" class="pa-0">
                <v-chip color="grey lighten-3">任意</v-chip>
              </v-col>
            </v-row>
            <v-row class="pb-2">
              <v-col cols="3" class="text-right py-0">ホームページ等</v-col>
              <v-col cols="8" class="py-0">
                <v-text-field
                  dense outlined hide-details
                  v-model="website"
                />
              </v-col>
              <v-col cols="1" class="pa-0">
                <v-chip color="grey lighten-3">任意</v-chip>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
      </v-container>
    </v-card>

    <v-card>
      <v-container>
        <v-card-title>
          <h3>ログイン情報設定</h3>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="2" class="justify-end py-0 d-flex align-center">メールアドレス</v-col>
            <v-col v-if="!showMailEdit">
              <v-label class="mr-2 py-0">{{ mail || 'なし' }}</v-label>
              <v-btn rounded class="ml-3" @click="showMailEdit=true">
                変更
              </v-btn>
            </v-col>
            <v-col v-else>
              <v-text-field class="mr-2 py-0 d-inline-flex" v-model="mail" outlined dense hide-details/>
              <v-btn rounded class="ml-3" @click="showMailEdit=false">
                保存
              </v-btn>
            </v-col>
          </v-row>
        </v-card-text>
      </v-container>
    </v-card>

    <v-card>
      <v-container>
        <v-card-title>
          <h3>メール受信設定</h3>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="2" class="pb-0 pt-1 text-right">メルマガ配信</v-col>
            <v-col class="py-0">
              <v-radio-group v-model="mailmaga" row class="mt-0">
                <v-radio label="受信する" :value="1" />
                <v-radio label="受信しない" :value="0"/>
              </v-radio-group>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="2" class="text-right pb-0 pt-1">成約発生時通知</v-col>
            <v-col class="py-0">
              <v-radio-group v-model="contract_alert" row class="mt-0">
                <v-radio label="受信する" :value="1" />
                <v-radio label="受信しない" :value="0"/>
              </v-radio-group>
            </v-col>
          </v-row>
        </v-card-text>
      </v-container>
      <v-card-actions class="d-flex justify-center pb-3">
        <v-btn color="success" @click="save">
          登録
        </v-btn>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script>
  import vuetifyToast from 'vuetify-toast'
  export default {
    data() {
      const years = []
      for(let i=1950; i < 2020;i++) years.push(i)
      return {
        name_rule: [
          (v) => !!v || '必須項目です。',
        ],
        showMailEdit: false,
        name_last: '',
        name_first: '',
        furi_last: '',
        furi_first: '',
        avatar: '',
        nickname: '',
        gender: '',
        year: 0,
        years: years,
        months: [1,2,3,4,5,6,7,8,9,10,11,12],
        month: 1,
        date: 1,
        website: '',
        mail: '',
        mailmaga: 0,
        contract_alert: 0,
        prev_url: '',
        file: ''
      }
    },
    mounted() {
      // load categories and QAs
    },
    computed: {
      dates() {
        const dates0 = [31,28,31,30,31,30,31,31,30,31,30,31]
        let dateInMonth = dates0[this.month-1]

        if(this.month === 2 && this.year % 4 === 0 && this.year % 100 > 0) {
          dateInMonth = 29
        }

        const tmp = []
        for(let i = 1; i <= dateInMonth; i++) tmp.push(i)
        return tmp
      }
    },
    methods: {
      imgSelect() {
        // check image dimension
        // var img = newImage
        this.prev_url = URL.createObjectURL(this.avatar)
      },
      save() {
        const invalid = this.name_last === '' || this.name_first === '' || this.furi_last === '' || this.furi_first === '' || this.nickname === ''
        if(invalid) {
          vuetifyToast.error('必須項目を入力してください。')
          return
        }

        if(this.avatar) {
          let formData = new FormData()

          // for(let file of this.avatar) {
            formData.append('avatar', this.avatar, this.avatar.name)
          // }
          formData.append('name_last', this.name_last)
          formData.append('name_first', this.name_first)
          formData.append('furi_last', this.furi_last)
          formData.append('furi_first', this.furi_first)
          formData.append('nick_name', this.nickname)
          formData.append('gender', this.gender)
          formData.append('dob', this.year + '-' + this.month + '-' + this.date)
          formData.append('website', this.website)
          formData.append('email', this.mail)
          formData.append('mailmaga', this.mailmaga)
          formData.append('contract_alert', this.contract_alert)

          axios.post('/admin/account/save', formData, {
            headers: {'Content-Type': 'multipart/form-data'}
          })
            .then(res => {
              console.log(res)
              vuetifyToast.success('アカウントは正常に保存されました。')
              this.$store.commit('setAccountId', res.data.uid)
            })
            .catch(e => {
              vuetifyToast.error('アカウントを保存できませんでした。')
              console.log(e)
            })
        }
      }
    }
  }
</script>

<style scoped>
  .v-card {
    margin-bottom: 10px;
    box-shadow: 0 3px 3px #ddd;
  }
  ._years, ._months, ._dates {
    width: 100px !important;
  }
</style>