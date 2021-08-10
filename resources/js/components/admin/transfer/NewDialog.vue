<template>
  <section>
    <v-dialog
      v-model="dialog"
      persistent
      max-width="600"
    >
      <v-card>
        <v-card-title class="text-center justify-center">報酬登録</v-card-title>
        <v-divider/>
        <v-card-text class="py-0">
          <v-container fluid class="py-0">
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>アフィリエイターID</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  v-model="item.affiliate_id"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>報酬発生日</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  hint="例）2020-05-01 12:00"
                  persistent-hint
                  v-model="item.made_at"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>報酬支払日</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  hint="例）2020-05-01 12:00"
                  persistent-hint
                  v-model="item.pay_at"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>報酬金額</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  v-model="item.amount"
                  class="_amount d-inline-flex mr-2"
                />円
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>キャンペーンID</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  v-model="item.campaign_id"
                  class="_campaign"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>備考</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-textarea
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
          <v-btn color="#5367FD" dark @click="save(1)">下書き</v-btn>
          <v-btn color="#C694F9" dark @click="save(2)">登録する</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </section>
</template>

<script>
  export default {
    props: {
      dialog: false,
    },
    data() {
      return {
        item: {
          affiliate_id: '',
          made_at: '',
          pay_at: '',
          amount: '',
          campaign_id: '',
          note: '',
        }
      }
    },
    methods: {
      save(flag) {
        this.$emit('onCreated', this.item, flag)
      }
    }
  }
</script>

<style scoped>
  ._amount {
    max-width: 200px;
  }

</style>