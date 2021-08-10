<template>
  <v-card>
    <v-card-title>
      <v-row>
        <v-col cols="3">
          <v-select
            outlined dense hide-details
            v-model="select1"
            label="全体選択"
          />
        </v-col>
        <v-col cols="3">
          <v-select
            label="ASP選択"
            v-model="asp"
            outlined dense hide-details
          />
        </v-col>
        <v-col cols="3">
          <v-select
            label="キャンペーン選択"
            v-model="campaign"
            :items="campaigns"
            item-text="name" item-value="id"
            outlined dense hide-details
            class="_campaigns ml-3"
            @change="changeCampaign"
          />
        </v-col>
        <v-col cols="3">
          <v-sheet style="background-color:#FF7272;text-align: center">
            <label class="subtitle-1 font-weight-bold">あなたのランク</label><br/>
            <label class="headline font-weight-bold">{{data.rank}}</label>
          </v-sheet>
        </v-col>
      </v-row>
    </v-card-title>
    <v-card-text>
      <v-row>
        <v-col cols="6" md="3">
          <v-card class="_top-card">
            <v-card-title>クリック件数</v-card-title>
            <v-card-text class="d-flex justify-center align-center">
              <label class="headline font-weight-bold">
                {{format(data.clicks)}}
              </label>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="6" md="3">
          <v-card class="_top-card">
            <v-card-title>成約件数</v-card-title>
            <v-card-text class="d-flex justify-center align-center">
              <label class="headline font-weight-bold">
                {{format(data.contract_number)}}/{{format(data.contract_rate,2)}}%
              </label>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="6" md="3">
          <v-card class="_top-card">
            <v-card-title>成約金額/承認金額</v-card-title>
            <v-card-text class="align-center">
              <p class="text-center title font-weight-bold mb-1">
                {{format(data.contract_amount)}}
              </p>
              <p class="text-center title font-weight-bold mb-0">
                {{format(data.accept_amount)}}
              </p>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="6" md="3">
          <v-card class="_top-card">
            <v-card-title>あなたの報酬単価</v-card-title>
            <v-card-text class="d-flex justify-center align-center">
              <label class="headline font-weight-bold">
                {{format(data.reward_unit)}}
              </label>
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
        select1: -1,
        asp: -1,
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