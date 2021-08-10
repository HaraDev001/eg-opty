<template>
  <section>
    <v-dialog
      v-model="dialog"
      persistent
      max-width="600"
    >
      <v-card>
        <v-card-title class="text-center justify-center">候補者登録</v-card-title>
        <v-divider/>
        <v-card-text class="py-0">
          <v-container fluid class="py-0">
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>アフィリエイターID</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-select
                  outlined dense
                  :items="affiliates"
                  item-text="name"
                  item-value="id"
                  v-model="item.affiliate_id"
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
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>ステータス</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  v-model="item.reserve_month"
                />
                <p>※該当年月で登録済のアフィリエイターを追加すると、既存データもここで指定したステータスで上書きされます。</p>
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>備考</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-textarea
                  outlined
                  v-model="item.note"
                />
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-divider/>
        <v-card-actions class="d-flex justify-center">
          <v-btn color="alert" dark @click="$emit('onNewCandidateDlgClose')">キャンセル</v-btn>
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
      campaigns: {
        type: Array,
        default: () => []
      },
      affiliates: {
        type: Array,
        default: () => []
      },
    },
    data() {
      return {
        item: {
          affiliate_id: '',
          campaign_id: '',
          reserve_month: '',
          status: '',
          note: '',
        }
      }
    },
    methods: {
      save(flag) {
        this.$emit('onNewCandidate', this.item, flag)
      }
    }
  }
</script>

<style scoped>
</style>