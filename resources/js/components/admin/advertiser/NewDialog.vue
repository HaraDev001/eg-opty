<template>
  <section>
    <v-dialog
      v-model="dialog"
      persistent
      max-width="600"
    >
      <v-card>
        <v-card-title class="text-center justify-center">広告主 新規登録</v-card-title>
        <v-divider/>
        <v-card-text class="py-0">
          <v-container fluid class="py-0">
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>名前</v-label>
              </v-col>
              <v-col cols="4" class="pb-0">
                <v-text-field
                  label="姓"
                  outlined dense
                  v-model="item.name_last"
                />
              </v-col>
              <v-col cols="4" class="pb-0">
                <v-text-field
                  label="名"
                  outlined dense
                  v-model="item.name_first"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>フリガナ</v-label>
              </v-col>
              <v-col cols="4" class="pb-0">
                <v-text-field
                  outlined dense
                  label="姓"
                  v-model="item.furi_last"
                />
              </v-col>
              <v-col cols="4" class="pb-0">
                <v-text-field
                  label="名"
                  outlined dense
                  v-model="item.furi_first"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>Mail Address</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  v-model="item.email"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>Password</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  v-model="item.password"
                  hint="8文字以上"
                  persistent-hint
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>Password(再入力)</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  hint="8文字以上。パスワードと一致"
                  persistent-hint
                  v-model="item.password_confirmation"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>ランク</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-select
                  outlined dense
                  :items="ranks"
                  item-text="name" item-value="id"
                  v-model="item.rank_id"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>企業名</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  v-model="item.company"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>企業名(フリガナ)</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  v-model="item.company_furi"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>郵便番号</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  v-model="item.zipcode"
                  hint="000-0000"
                  persistent-hint
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>住所</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  v-model="item.address"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row class="pb-0">
              <v-col cols="4" class="pb-0">
                <v-label>電話番号</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  v-model="item.phone"
                  hint="000-0000-0000"
                  persistent-hint
                />
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-divider/>
        <v-card-actions class="d-flex justify-center">
          <v-btn color="alert" dark @click="$emit('onNewDlgClose')">キャンセル</v-btn>
          <v-btn color="#5367FD" dark @click="save(0)">下書き</v-btn>
          <v-btn color="#C694F9" dark @click="save(1)">登録する</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </section>
</template>

<script>
  import vuetifyToast from "vuetify-toast"

  export default {
    props: {
      dialog: false,
      ranks: {type: Array, default: []}
    },
    data() {
      return {
        item: {
          name_last: '',
          name_first: '',
          furi_last: '',
          furi_first: '',
          email: '',
          password: '',
          password_confirmation: '',
          rank_id: '',
          company: '',
          company_furi: '',
          zipcode: '',
          address: '',
          phone: ''
        }
      }
    },
    methods: {
      save(flag) {
        this.item.status = flag

        axios.post('/admin/advertiser/new', this.item)
        .then(res => {
          this.$emit('onCreated', res.data.advertisers)
        })
        .catch(e => {
          if(e.response.status === 400) {
            const errors = e.response.data.errors
            if(errors.hasOwnProperty('name_last')) vuetifyToast.error('名前を入力してください。')
            if(errors.hasOwnProperty('name_first')) vuetifyToast.error('名前を入力してください。')
            if(errors.hasOwnProperty('furi_last')) vuetifyToast.error('名前を入力してください。')
            if(errors.hasOwnProperty('furi_first')) vuetifyToast.error('名前を入力してください。')
            if(errors.hasOwnProperty('email')) vuetifyToast.error('メールアドレスを入力してください。')
            if(errors.hasOwnProperty('password')) vuetifyToast.error('パスワードを入力してください。')
            if(errors.hasOwnProperty('rank_id')) vuetifyToast.error('ランクを選択してください。')
            if(errors.hasOwnProperty('company')) vuetifyToast.error('会社名を入力してください。')
            if(errors.hasOwnProperty('company_furi')) vuetifyToast.error('会社名を入力してください。')
            if(errors.hasOwnProperty('zipcode')) vuetifyToast.error('郵便番号を入力してください。')
            if(errors.hasOwnProperty('address')) vuetifyToast.error('住所を入力してください。')
            if(errors.hasOwnProperty('phone')) vuetifyToast.error('電話番号を入力してください。')
          } else {
            vuetifyToast.error('サーバーエラー。 マネージャーに連絡するか、後で試してください。')
          }
        })
      }
    }
  }
</script>

<style scoped>
</style>