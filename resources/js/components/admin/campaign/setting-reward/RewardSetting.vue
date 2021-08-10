<template>
  <v-card>
    <v-container fluid>
      <v-card-title>
        <v-row>
          <v-col cols="12">
            <h3>報酬額設定</h3>
          </v-col>
          <v-col cols="12">
            <v-chip-group
              column
              v-model="rewardType"
              active-class="success white-text"
            >
              <v-chip v-for="(tag, i) in rewardTypes"
                      :key="i" :value="tag.value">
                {{ tag.label }}
              </v-chip>
            </v-chip-group>
          </v-col>
        </v-row>
      </v-card-title>

      <v-card-text>
        <table-main-reward
          v-if="rewardType==='main'"
          :campaign_id="campaign_id"
        />
        <table-special-reward
          v-if="rewardType==='special'"
          :campaign_id="campaign_id"
        />
        <table-first-come-reward
          v-if="rewardType==='first-come'"
          :campaign_id="campaign_id"
        />
        <table-increased-reward
          v-if="rewardType==='increased'"
          :campaign_id="campaign_id"
        />
      </v-card-text>
    </v-container>
  </v-card>
</template>

<script>
  import TableMainReward from "./main/TableMainReward";
  import TableSpecialReward from "./special/TableSpecialReward";
  import TableFirstComeReward from "./first-come/TableFirstComeReward";
  import TableIncreasedReward from "./increased-reward/TableIncreasedReward";

  export default {
    components: {TableMainReward, TableSpecialReward, TableFirstComeReward, TableIncreasedReward},
    props: {
      campaign_id: {type:Number, default: 0},
    },
    data() {
      return {
        rewardType: 'main',
        rewardTypes: [
          {value: 'main', label: '基本報酬'},
          {value: 'special', label: '特別報酬'},
          {value: 'first-come', label: '先着報酬'},
          {value: 'increased', label: '増加報酬'},
        ],
      }
    },
    methods: {
      addItem() {

      }
    }
  }
</script>

<style scoped>

</style>