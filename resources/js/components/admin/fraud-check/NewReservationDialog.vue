<template>
  <section>
    <v-dialog
      v-model="dialog"
      persistent
      max-width="600"
    >
      <v-card>
        <v-card-title class="text-center justify-center">レポート予約</v-card-title>
        <v-divider/>
        <v-card-text class="py-0">
          <v-container fluid class="py-0">
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>レポートの種類</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  v-model="item.report_type"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>キャンペーンID</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-select
                  outlined dense
                  :items="campaigns"
                  item-value="id"
                  item-text="name"
                  v-model="item.campaign_id"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>チェック対象月</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  hint="例）2020/08"
                  persistent-hint
                  v-model="item.reserve_month"
                />
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-divider/>
        <v-card-actions class="d-flex justify-center">
          <v-container>
            <v-row>
              <v-col cols="12" class="text-center pa-0">
                <small>レポートは予約後10分以内に作成開始します</small>
              </v-col>
              <v-col cols="12" class="d-flex justify-center">
                <v-btn color="alert" dark @click="$emit('onNewReserveDlgClose')">
                  キャンセル
                </v-btn>
                <v-btn color="#5367FD" dark
                   class="mx-2" @click="save(1)">
                  下書き
                </v-btn>
                <v-btn color="#C694F9" dark @click="save(2)">登録する</v-btn>
              </v-col>
            </v-row>
          </v-container>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </section>
</template>

<script>
  export default {
    props: {
      dialog: false,
      campaigns: {
        type: Array,
        default: () => []
      }
    },
    data() {
      return {
        item: {
          report_type: '',
          campaign_id: '',
          reserve_month: '',
        }
      }
    },
    methods: {
      save(flag) {
        this.$emit('onNewReservation', this.item, flag)
      }
    }
  }
</script>

<style scoped>
  ._amount {
    max-width: 200px;
  }

</style>