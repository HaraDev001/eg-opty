<template>
  <v-container fluid>
    <v-dialog
      v-model="show"
      persistent
      width="500"
    >
      <v-card>
        <v-card-title
          class="headline text-center"
          primary-title
        >
          基本報酬追加
        </v-card-title>

        <v-form v-model="valid">
          <v-card-text class="pb-0">
            <v-row>
              <v-col cols="3">RANK</v-col>
              <v-col>
                <v-select
                  outlined dense hide-details
                  :items="ranks" item-value="id" item-text="name"
                  v-model="item.rank_id"/>
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">期間</v-col>
              <v-col cols="9" class="pa-0">
                <v-col cols="12">
                  <v-menu
                    ref="menu_start_date"
                    v-model="menu_start_date"
                    :close-on-content-click="false"
                    :return-value.sync="item.date_start"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        :rules="[required]"
                        v-model="item.date_start"
                        dense outlined hide-details="auto" readonly prepend-inner-icon="mdi-calendar"
                        class="_date-picker" v-on="on"/>
                    </template>
                    <v-date-picker v-model="item.date_start" no-title>
                      <v-spacer/>
                      <v-btn text color="primary" @click="menu_start_date = false">Cancel</v-btn>
                      <v-btn text color="primary" @click="$refs.menu_start_date.save(item.date_start)">OK</v-btn>
                    </v-date-picker>
                  </v-menu>
                  <v-menu
                    ref="menu_start_time"
                    v-model="menu_start_time"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    :return-value.sync="item.time_start"
                    transition="scale-transition" offset-y
                    max-width="290px" min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        :rules="[required]"
                        v-model="item.time_start"
                        prepend-inner-icon="mdi-clock-outline"
                        readonly hide-details="auto" dense outlined
                        class="_time-picker"
                        v-on="on"
                      />
                    </template>
                    <v-time-picker
                      v-if="menu_start_time"
                      v-model="item.time_start"
                      format="24hr" full-width no-title
                    >
                      <v-spacer/>
                      <v-btn text color="primary" @click="menu_start_time = false">Cancel</v-btn>
                      <v-btn text color="primary" @click="$refs.menu_start_time.save(item.time_start)">OK</v-btn>
                    </v-time-picker>
                  </v-menu>&nbsp;から
                </v-col>

                <v-col cols="12" class="pt-0">
                  <v-menu
                    ref="menu_end_date"
                    v-model="menu_end_date"
                    :close-on-content-click="false"
                    :return-value.sync="item.date_end"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        :rules="[required]"
                        v-model="item.date_end"
                        dense outlined hide-details="auto" readonly prepend-inner-icon="mdi-calendar"
                        class="_date-picker" v-on="on"/>
                    </template>
                    <v-date-picker v-model="item.date_end" no-title>
                      <v-spacer/>
                      <v-btn text color="primary" @click="menu_end_date = false">Cancel</v-btn>
                      <v-btn text color="primary" @click="$refs.menu_end_date.save(item.date_end)">OK</v-btn>
                    </v-date-picker>
                  </v-menu>
                  <v-menu
                    ref="menu_end_time"
                    v-model="menu_end_time"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    :return-value.sync="item.time_end"
                    transition="scale-transition" offset-y
                    max-width="290px" min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="item.time_end"
                        prepend-inner-icon="mdi-clock-outline"
                        readonly hide-details="auto" dense outlined
                        class="_time-picker"
                        :rules="[required]"
                        v-on="on"
                      />
                    </template>
                    <v-time-picker
                      v-if="menu_end_time"
                      v-model="item.time_end"
                      format="24hr" full-width no-title
                    >
                      <v-spacer/>
                      <v-btn text color="primary" @click="menu_end_time = false">Cancel</v-btn>
                      <v-btn text color="primary" @click="$refs.menu_end_time.save(item.time_end)">OK</v-btn>
                    </v-time-picker>
                  </v-menu>&nbsp;まで
                </v-col>
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">報酬金額</v-col>
              <v-col>
                <v-text-field
                  outlined dense hide-details="auto"
                  :rules="[required, numberRule]"
                  v-model="item.amount" class="d-inline-flex"/> 円
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">表示の有無</v-col>
              <v-col>
                <v-switch
                  v-model="item.is_show"
                  :true-value="1" :false-value="0"
                  hide-details class="mt-0"/>
              </v-col>
            </v-row>
            <v-divider/>
          </v-card-text>
        </v-form>

        <v-divider/>

        <v-card-actions class="d-flex justify-center">
          <v-btn @click="$emit('onNewClose')">キャンセル</v-btn>
          <v-btn dark color="pink darken-3" :disabled="!valid"
            @click="save"
          >
            登録
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
  import vuetifyToast from 'vuetify-toast'

  export default {
    props: {
      show: {type: Boolean, default: false},
      campaign_id: {type: Number, default: 0},
      ranks: {type: Array, default: () => ([])},
    },
    data: vm => ({
      item: {
        id: 0,
        campaign_id: 0,
        rank_id: 1,
        date_start: '',
        time_start: '',
        date_end: '',
        time_end: '',
        amount: '',
        is_show: 1,
      },
      menu_start_date: false,
      menu_start_time: false,
      menu_end_date: false,
      menu_end_time: false,
      valid: false,
      required: v => !!v || '必須フィールド',
      numberRule: v => !isNaN(parseInt(v)) || '数でなければなりません',
    }),
    methods: {
      save() {
        const dts = this.$date(this.item.date_start + ' ' + this.item.time_start)
        const dte = this.$date(this.item.date_end + ' ' + this.item.time_end)

        if(dte.isBefore(dts)) {
          vuetifyToast.error('開始日には終了日より前の日付を指定してください。')
          return
        }
        this.$emit('onNewReward', this.item)
      }
    }
  }
</script>

<style scoped>
  ._date-picker {
    width: 150px !important;
    display: inline-flex;
    margin-right: 10px;
  }
  ._time-picker {
    width: 100px;
    display: inline-flex;
    margin-right: 10px;
  }

</style>