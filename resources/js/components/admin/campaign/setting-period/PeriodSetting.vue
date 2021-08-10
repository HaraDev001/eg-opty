<template>
  <v-card class="_setting-period">
    <v-container fluid>
      <v-card-title>
        <h3 class="_title">期間設定</h3>
      </v-card-title>

      <v-card-text>
        <v-row>
          <v-col cols="6">
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
                  v-model="item.date_start"
                  dense outlined hide-details readonly prepend-inner-icon="mdi-calendar"
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
                  v-model="item.time_start"
                  prepend-inner-icon="mdi-clock-outline"
                  readonly hide-details dense outlined
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
          <v-col cols="6">
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
                  v-model="item.date_end"
                  dense outlined hide-details readonly prepend-inner-icon="mdi-calendar"
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
                  readonly hide-details dense outlined
                  class="_time-picker"
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
          <v-col cols="12" class="d-flex justify-center">
            <v-btn dark color="info" @click="savePeriod">保存する</v-btn>
          </v-col>
        </v-row>
      </v-card-text>
    </v-container>
  </v-card>
</template>

<script>
  import vuetifyToast from "vuetify-toast"

  export default {
    props: {
      campaign_id: {type: Number, default: 0}
    },
    data() {
      return {
        menu_start_date: false,
        menu_start_time: false,
        menu_end_date: false,
        menu_end_time: false,
        item: {
          date_start: '',
          time_start: '',
          date_end: '',
          time_end: '',
        }
      }
    },
    mounted() {
      axios.get(`/admin/campaign/get/${this.campaign_id}`)
      .then(res => {
        this.item = res.data.campaign
      })
      .catch(e => {
        vuetifyToast.error('サーバーからキャンペーンデータを取得できません。 後で試してください。')
      })
    },
    methods: {
      savePeriod() {
        // check date validity
        const dts = this.$date(this.item.date_start + ' ' + this.item.time_start)
        const dte = this.$date(this.item.date_end + ' ' + this.item.time_end)

        if(dte.isBefore(dts)) {
          vuetifyToast.error('終了日が開始日より前です。 日付を修正してください。')
          return
        }

        const data = {
          date_start: dts.format('YYYY-MM-DD'),
          time_start: dts.format('HH:mm:ss'),
          date_end: dte.format('YYYY-MM-DD'),
          time_end: dte.format('HH:mm:ss'),
        }
        axios.post(`/admin/campaign/period/set/${this.campaign_id}`, data)
        .then(res => {
          vuetifyToast.success('キャンペーン期間が変更になりました。')
        })
        .catch(e => {
          vuetifyToast.error('キャンペーン期間を変更できません。')
        })
        // this.$emit('onPeriodSave', this.item)
      }
    }
  }
</script>

<style scoped>
._date-picker {
  display: inline-flex;
  margin-right: 10px;
}
  ._time-picker {
    display: inline-flex;
  }
</style>