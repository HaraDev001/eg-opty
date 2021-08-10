<template>
  <div class="page_wrap_vue pa-3 manager-account-page">
    <v-card class="mx-auto">
      <v-card-title class="_header">
        <v-container fluid>
          <v-row>
            <v-col cols="12" class="d-flex justify-space-between">
              <h3 class="d-inline mr-1">振込口座情報</h3>
            </v-col>
            <v-col cols="12" class="d-flex justify-end">
              <v-btn
                dense dark rounded color="info"
                to="/admin/manager-account"
              >
                管理アカウント
              </v-btn>
            </v-col>
          </v-row>
        </v-container>
      </v-card-title>
    </v-card>

    <v-card>
      <v-container>
        <v-row>
          <v-col cols="3" class="text-right py-0">国内外口座選択</v-col>
          <v-col cols="9" class="py-0">
            <v-radio-group v-model="bank_type" row class="mt-0">
              <v-radio label="国内" :value="1" />
              <v-radio label="国外" :value="0"/>
            </v-radio-group>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="3" class="text-right py-0">銀行名</v-col>
          <v-col cols="3" class="py-0">
            <v-text-field outlined dense v-model="bank_name"/>
          </v-col>
          <v-col class="py-0">例）三菱東京UFJ銀行</v-col>
        </v-row>
        <v-row>
          <v-col cols="3" class="text-right py-0">銀行番号</v-col>
          <v-col cols="3" class="py-0">
            <v-text-field outlined dense v-model="bank_code"/>
          </v-col>
          <v-col class="py-0">例）0005  ご不明の場合はこちらの金融機関コード・銀行コード検索から検索をお願い致します。</v-col>
        </v-row>
        <v-row>
          <v-col cols="3" class="text-right py-0">支店名</v-col>
          <v-col cols="3" class="py-0">
            <v-text-field outlined dense v-model="branch_name"/>
          </v-col>
          <v-col class="py-0">例）浅草橋支店</v-col>
        </v-row>
        <v-row>
          <v-col cols="3" class="text-right py-0">支店番号</v-col>
          <v-col cols="3" class="py-0">
            <v-text-field outlined dense v-model="branch_code"/>
          </v-col>
          <v-col class="py-0">
            例）069  ご不明の場合はこちらの金融機関コード・銀行コード検索から検索をお願い致します。
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="3" class="text-right py-0">口座種別</v-col>
          <v-col cols="3" class="py-0">
            <v-text-field outlined dense v-model="account_type"/>
          </v-col>
          <v-col> </v-col>
        </v-row>
        <v-row>
          <v-col cols="3" class="text-right py-0">口座番号</v-col>
          <v-col cols="5" class="py-0">
            <v-text-field outlined dense v-model="account_number"/>
          </v-col>
          <v-col class="py-0">例）1234567</v-col>
        </v-row>
        <v-row>
          <v-col cols="3" class="text-right py-0">口座名義</v-col>
          <v-col cols="5" class="py-0">
            <v-text-field outlined dense v-model="account_holder"/>
          </v-col>
          <v-col class="py-0">
            例)<br/>
            【個人名義の場合】ﾔﾏﾀﾞ ﾀﾛｳ<br/>
            【会社名義の場合】<br/>
            株式会社 ループ→ｶ)ﾙｰﾌﾟ<br/>
            株式会社 LOOP→ｶ)LOOP<br/>
          </v-col>
        </v-row>
        <v-row>
          <v-col class="d-flex justify-center">
            <v-btn color="#C694F9" dark @click="save">登録</v-btn>
          </v-col>
        </v-row>
      </v-container>
    </v-card>

  </div>
</template>

<script>
  import vuetifyToast from 'vuetify-toast'
  export default {
    data() {
      return {
        bank_type: 1,
        bank_name: '',
        bank_code: '',
        branch_name: '',
        branch_code: '',
        account_type: '',
        account_number: '',
        account_holder: 0,
      }
    },
    mounted() {
      // load categories and QAs
    },
    computed: {
    },
    methods: {
      save() {
        const invalid = this.bank_name === '' || this.bank_code === '' ||
          this.branch_name === '' || this.branch_code === '' ||
          this.account_type === '' || this.account_number === '' || this.account_holder === ''

        if(invalid) {
          vuetifyToast.error('すべてのフィールドに入力してください。')
          return
        }

        const user_id = this.$store.getters.getAccountId
        console.log(user_id)
        if(!user_id) {
          vuetifyToast.error('保存されたユーザーはありません。')
          return
        }

        const data = {
          user_id: user_id,
          bank_type: this.bank_type,
          bank_name: this.bank_name,
          bank_code: this.bank_code,
          branch_name: this.branch_name,
          branch_code: this.branch_code,
          account_type: this.account_type,
          account_number: this.account_number,
          account_holder: this.account_holder
        }
        console.log(data)
        axios.post('/admin/account/bank/save', data)
          .then(res => {
            vuetifyToast.success('アカウントは正常に保存されました。')
          })
          .catch(e => {
            vuetifyToast.error('アカウントを保存できませんでした。')
            console.log(e)
          })
      }
    }
  }
</script>

<style scoped>
  .v-card {
    margin-bottom: 10px;
    box-shadow: 0 3px 3px #ddd;
  }
</style>