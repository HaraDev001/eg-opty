<template>
  <v-row justify="center">
    <v-dialog
      class="edit-lp-reward-dialog"
      v-model="show"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-card-title class="_title">
          LP別報酬編集
        </v-card-title>
        <v-divider/>
        <v-card-text class="_content">
          <v-form v-model="valid">
            <v-row>
              <v-col cols="3">報酬額</v-col>
              <v-col cols="9">
                <v-text-field
                  hide-details="auto" dense outlined
                  v-model="item.amount"
                  :rules="[required, mustNumber]"
                  class="d-inline-flex"
                />
                円
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="3">Rank</v-col>
              <v-col cols="9">
                <v-select
                  outlined dense hide-details="auto"
                  v-model="item.rank_id"
                  :items="ranks"
                  :rules="[required]"
                  item-value="id" item-text="label"
                />
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="3">期間設定</v-col>
              <v-col cols="9">
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      type="date"
                      outlined dense hide-details="auto"
                      class="d-inline-flex"
                      :rules="[required]"
                      v-model="item.date_start"/>
                    <v-text-field
                      type="time"
                      outlined dense hide-details="auto"
                      class="d-inline-flex"
                      :rules="[required]"
                      v-model="item.time_start"/>
                    から
                  </v-col>
                  <v-col cols="12">
                    <v-text-field type="date"
                                  outlined dense hide-details="auto"
                                  class="d-inline-flex"
                                  :rules="[required]"
                                  v-model="item.date_end"/>
                    <v-text-field type="time"
                                  outlined dense hide-details="auto"
                                  class="d-inline-flex"
                                  :rules="[required]"
                                  v-model="item.time_end"/>
                    まで
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>
        <v-card-actions class="_action justify-center py-3">
          <v-btn @click="$emit('onEditClose')">キャンセル</v-btn>
          <v-btn color="primary" :disabled="!valid"
            @click="save">保存</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
  import vuetifyToast from "vuetify-toast";

  export default {
    props: {
      show: {type:Boolean, default: false},
      item: {
        type: Object,
        id: {type: Number, default: 0},
        lp_id: {type: Number, default: 0},
        amount: {type: Number, default: 0},
        rank_id: {type: Number, default: 0},
        date_start: {type: String, default: ''},
        time_start: {type: String, default: ''},
        date_end: {type: String, default: ''},
        time_end: {type: String, default: ''}
      },
    },
    data: vm => ({
      ranks: [
        {id: 1, label: 'VIP'},
        {id: 2, label: 'S VIP'},
        {id: 3, label: 'SS VIP'},
        {id: 4, label: 'QUEEN'},
        {id: 5, label: 'KING'},
      ],
      required: v => !!v || '必須フィールド',
      mustNumber: v => !isNaN(parseInt(v)) || '数ではない',
      valid: false
    }),
    watch: {
    },
    methods: {
      save() {
        const dts = this.$date(this.item.date_start + '' + this.item.time_start)
        const dte = this.$date(this.item.date_end + '' + this.item.time_end)

        if(dte.isBefore(dts)) {
          vuetifyToast.error('開始日は終了日より前にしてください。')
          return
        }
        this.$emit('onEditSave', this.item)
      }
    }
  }
</script>

<style scoped lang="scss">
</style>