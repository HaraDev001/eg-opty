<template>
  <section>
    <v-dialog
      v-model="dialog"
      max-width="600"
      persistent
      class="advertiser-new-dlg"
    >
      <v-card>
        <v-card-title class="text-center justify-center">
          {{ val.name_last }} {{ val.name_first }}
        </v-card-title>
        <v-card-subtitle class="text-center">{{ val.id }}</v-card-subtitle>
        <v-divider/>
        <v-card-text class="py-0">
          <v-container fluid class="py-0">
            <v-row>
              <v-col cols="3">Mail Address</v-col>
              <v-col cols="9">{{ val.mail }}</v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">RANK</v-col>
              <v-col cols="9">{{ val.rank }}</v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">登録状況</v-col>
              <v-col cols="9">{{ val.status }}</v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">登録日時</v-col>
              <v-col cols="9">{{ $date(val.created_at).format('YYYY/MM/DD') }}</v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">最終更新日時</v-col>
              <v-col cols="9">{{ $date(val.updated_at).format('YYYY/MM/DD') }}</v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">メルマガ配信</v-col>
              <v-col cols="9">{{ val.mailmaga }}</v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">成約発生時通知</v-col>
              <v-col cols="9">{{ val.contract_alert }}</v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">振込口座</v-col>
              <v-col cols="9">{{ val.bank_account }}</v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">ブラックリスト</v-col>
              <v-col cols="9">{{ val.blacklist }}</v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">ペナルティ</v-col>
              <v-col cols="9">{{ val.penalty }}</v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">お問い合わせ履歴</v-col>
              <v-col cols="9">{{val.contact_history}} </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">不正情報履歴</v-col>
              <v-col cols="9">{{val.fraud_history}} </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-divider/>
        <v-card-actions class="d-flex justify-center">
          <v-btn color="error" dark @click="hide">キャンセル</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </section>
</template>

<script>
  export default {
    props: {
      dialog: false,
      item: {
        type: Object,
        default:() => null
      }
    },
    data() {
      console.log(this.item)
      return {
        ranks: ['VIP', 'S VIP', 'SS VIP', 'QUEEN', 'KING'],
        show: false,
        val: {
          id: 0, name_first: '', name_last: '', mail: '', rank: 0,
          status: '', created_at: '', updated_at: '', mailmaga: '',
          contract_alert: '', bank_account: '', blacklist: '', penalty: '',
          contact_history: '', fraud_history: ''
        }
      }
    },
    watch: {
      item(val) {
        if(val !== null) {
          this.val = val
          this.val.fraud_history = ''
          this.val.contact_history = ''
        }
      }
    },
    methods: {
      hide() {
        this.$emit('onDetailDlgClose')
      },
    }
  }
</script>

<style scoped>
</style>