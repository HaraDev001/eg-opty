<template>
  <v-card>
    <v-card-title>
      <v-row>
        <v-col class="d-flex justify-center">
          <label>キャンペーン名</label>
          <v-select
            v-model="campaign"
            :items="campaigns"
            item-text="name" item-value="id"
            outlined dense hide-details
            class="_campaigns ml-3"
            @change="changeCampaign"
          />
        </v-col>
      </v-row>
    </v-card-title>
    <v-card-text>
      <v-row>
        <v-col cols="6" md="3">
          <v-card class="_top-card">
            <v-card-title>申し込み件数</v-card-title>
            <v-card-text class="d-flex justify-center align-center">
              <label class="headline font-weight-bold">
                {{format(data.application_number)}}
              </label>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="6" md="3">
          <v-card class="_top-card">
            <v-card-title>成約金額</v-card-title>
            <v-card-text class="d-flex justify-center align-center">
              <label class="headline font-weight-bold">
                {{format(data.contract_amount)}}
              </label>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="6" md="3">
          <v-card class="_top-card">
            <v-card-title>申し込み単価</v-card-title>
            <v-card-text class="d-flex justify-center align-center">
              <label class="headline font-weight-bold">
                {{format(data.application_unit_price)}}
              </label>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="6" md="3">
          <v-card class="_top-card">
            <v-card-title>目標達成率</v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="12" class="py-0 text-center">
                  <label class="headline font-weight-bold">
                    {{format(data.target_archive_rate, 2)}}%
                  </label>
                </v-col>
                <v-col cols="12" class="pb-0 text-center">
                  <label class="font-weight-bold">
                    ¥{{format(data.target_amount)}} -目標
                  </label>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>

<script>
  export default {
    props: {
      campaigns: {type: Array, default: []},
      camp_id: {type: Number, default: 0},
      data: {
        type: Object,
        application_number: {type: Number, default: 0},
        contract_amount: {type: Number, default: 0},
        application_unit_price: {type: Number, default: 0},
        target_archive_rate: {type: Number, default: 0},
        target_amount: {type: Number, default: 0},
      }
    },
    data() {
      return {
        campaign: this.camp_id,
      }
    },
    methods: {
      format(val, digs=0) {
        return val.toFixed(digs).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
      },
      changeCampaign() {
        this.$emit('changeCampaign', this.campaign)
      }
    }
  }
</script>

<style scoped>
._campaigns {
  display: inline-flex;
  flex: none;
}
  ._top-card {
    height: 150px;
  }
</style>