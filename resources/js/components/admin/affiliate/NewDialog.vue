<template>
  <section>
    <v-dialog
      v-model="dialog"
      persistent
      max-width="600"
    >
      <v-card>
        <v-card-title class="text-center justify-center">新規登録</v-card-title>
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
                  :rules="[rule_required]"
                  v-model="item.name_last"
                />
              </v-col>
              <v-col cols="4" class="pb-0">
                <v-text-field
                  label="名"
                  outlined dense
                  :rules="[rule_required]"
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
                  :rules="[rule_required]"
                  v-model="item.furi_last"
                />
              </v-col>
              <v-col cols="4" class="pb-0">
                <v-text-field
                  label="名"
                  outlined dense
                  :rules="[rule_required]"
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
                  :rules="[rule_required, rule_email]"
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
                  type="password"
                  :rules="[rule_required, rule_min]"
                  v-model="item.password"
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
                  type="password"
                  :rules="[rule_required, rule_min]"
                  v-model="item.password_confirmation"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>ニックネーム</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  :rules="[rule_required]"
                  v-model="item.nickname"
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
                  :rules="[rule_required]"
                  v-model="item.rank_id"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>備考</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  v-model="item.note"
                />
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-divider/>
        <v-card-actions class="d-flex justify-center">
          <v-btn color="alert" dark @click="$emit('onNewDlgClose')">キャンセル</v-btn>
          <v-btn color="#C694F9" dark @click="save">登録する</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </section>
</template>

<script>
  import vuetifyToast from 'vuetify-toast'

  export default {
    props: {
      dialog: false,
      ranks: {type:Array, default: []}
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
          nickname: '',
          rank_id: '',
          note: '',
        }
      }
    },
    methods: {
      rule_required: v => !!v || '必須フィールド',
      rule_min: v => v.length >= 8 || '8文字以上',
      rule_email: v => /^\w+[\w-\.]*\@\w+((-\w+)|(\w*))\.[a-z]{2,3}$/.test(v) || '無効なメールアドレス',

      save() {
        axios.post('/admin/affiliate/new', this.item)
          .then(res => {
            this.$emit('onCreated', res.data.affiliates)
          })
          .catch(e => {
            console.log(e.response)
            if(e.response.status === 400) {
              const errors = e.response.data.errors
              if(errors.hasOwnProperty('name_last')) vuetifyToast.error('姓を入力してください。')
              if(errors.hasOwnProperty('name_first')) vuetifyToast.error('名を入力してください。')
              if(errors.hasOwnProperty('furi_last')) vuetifyToast.error('姓を入力してください。')
              if(errors.hasOwnProperty('furi_first')) vuetifyToast.error('名を入力してください。')
              if(errors.hasOwnProperty('nickname')) vuetifyToast.error('ニックネームを入力してください。')
              if(errors.hasOwnProperty('rank_id')) vuetifyToast.error('ランクを入力してください。')
              if(errors.hasOwnProperty('email')) vuetifyToast.error('有効なメールアドレスを入力してください。')
              if(errors.hasOwnProperty('password')) vuetifyToast.error('パスワードを入力してください。')
            } else {
              vuetifyToast.error('サーバーエラーが発生します。')
            }
          })
      }
    }
  }
</script>

<style scoped>
</style>