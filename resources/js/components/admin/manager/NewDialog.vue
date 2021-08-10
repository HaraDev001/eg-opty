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
                  type="password"
                  outlined dense
                  hint="8文字以上。"
                  persistent-hint
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
                  hint="8文字以上。 パスワードと同じ。"
                  persistent-hint
                  type="password"
                  v-model="item.password_confirmation"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>権限</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-select
                  outlined dense
                  :items="permissions"
                  item-value="permission" item-text="name"
                  v-model="item.permission"
                />
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-divider/>
        <v-card-actions class="d-flex justify-center">
          <v-btn color="alert" dark @click="$emit('onNewDlgClose')">キャンセル</v-btn>
<!--          <v-btn color="#5367FD" dark @click="save(1)">下書き</v-btn>-->
          <v-btn color="#C694F9" dark @click="save">登録する</v-btn>
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
    },
    data() {
      return {
        permissions: [{permission:0, name: '管理者'}, {permission:1, name: 'super管理者'}],
        item: {
          name_last: '',
          name_first: '',
          email: '',
          password: '',
          password_confirmation: '',
          permission: '',
        }
      }
    },
    methods: {
      save() {
        axios.post('/admin/manager/new', this.item)
        .then(res => {
          this.$emit('onCreated', res.data.managers)
        })
        .catch(e => {
          if(e.response.status === 500) {
            vuetifyToast.error('マネージャーを保存できません。 後で試してください。')
          } else {
            const errors = e.response.data.errors

            if(errors.hasOwnProperty('name_last')) vuetifyToast.error('名前を入力してください。')
            if(errors.hasOwnProperty('name_first')) vuetifyToast.error('名前を入力してください。')
            if(errors.hasOwnProperty('email')) vuetifyToast.error('正しいメールアドレスを入力してください。')
            if(errors.hasOwnProperty('password')) vuetifyToast.error('パスワードを正しく入力してください。')
            if(errors.hasOwnProperty('permission')) vuetifyToast.error('権限を選択してください。')
          }
        })
      }
    }
  }
</script>

<style scoped>
</style>