<template>
  <div class="page_wrap_vue pa-3">
    <v-container class="_head">
      <v-row>
        <v-col>
          <v-card class="mx-auto">
            <v-row class="campaign-page_header_title">
              <v-col cols="12" class="justify-center d-flex">
                <h2>{{campaign.title}} / 設定</h2>
              </v-col>
              <v-col cols="12" class="d-flex justify-center">
                <v-btn
                  @click="selectCampaign"
                >
                  キャンペーン選択
                </v-btn>
              </v-col>
              <v-col cols="12" class="d-flex justify-center">
                <v-img
                  :src="campaign.image"
                  max-width="300"
                  max-height="300"
                />
              </v-col>
            </v-row>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
    <v-container class="_body">
      <v-row>
        <v-col>
          <v-tabs-items v-model="tab">
            <v-tab-item value="story">
              <SettingStory :campaign_id="campaign_id"/>
            </v-tab-item>
            <v-tab-item value="lp-reg">
              <LpRegister :campaign_id="campaign_id"/>
            </v-tab-item>
            <v-tab-item value="period-set">
              <PeriodSetting :campaign_id="campaign_id"/>
            </v-tab-item>
            <v-tab-item value="line-rich-img">
              <LineRichImages :campaign_id="campaign_id"/>
            </v-tab-item>
            <v-tab-item value="mail-line-intro">
              <MailLineIntroduction :campaign_id="campaign_id"/>
            </v-tab-item>
            <v-tab-item value="line-register">
              <LineRegister :campaign_id="campaign_id"/>
            </v-tab-item>
            <v-tab-item value="reward-set">
              <RewardSetting :campaign_id="campaign_id"/>
            </v-tab-item>
            <v-tab-item value="lp-reward">
              <LpReward :campaign_id="campaign_id"/>
            </v-tab-item>
            <v-tab-item value="lead-extend">
              <LeadExtend :campaign_id="campaign_id"/>
            </v-tab-item>
            <v-tab-item value="ip-except">
              <ContractIpExcept :campaign_id="campaign_id"/>
            </v-tab-item>
            <v-tab-item value="prize-setting">
              <PrizeSetting :campaign_id="campaign_id"/>
            </v-tab-item>
            <v-tab-item value="rank-except">
              <RankExcept :campaign_id="campaign_id"/>
            </v-tab-item>
            <v-tab-item value="rank-summary">
              <RankingSummary :campaign_id="campaign_id"/>
            </v-tab-item>
          </v-tabs-items>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="4" class="pr-0">
          <v-card>
            <v-card-title>
              <h4>キャンペーン編集</h4>
            </v-card-title>
            <v-card-text>
              <v-list>
                <v-list-item-group v-model="tab">
                  <v-list-item
                    v-for="(item, i) in campaignSettingItems"
                    :key="i" :value="item.target"
                  >
                    <v-list-item-content v-html="item.text"/>
                  </v-list-item>
                </v-list-item-group>
              </v-list>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="4" class="">
          <v-card class="align-self-start">
            <v-card-title>
              <h4>報酬設定</h4>
            </v-card-title>
            <v-card-text>
              <v-list>
                <v-list-item-group v-model="tab">
                  <v-list-item
                    v-for="(item, i) in transferSettingItems"
                    :key="i" :value="item.target"
                  >
                    <v-list-item-content v-text="item.text"/>
                  </v-list-item>
                </v-list-item-group>
              </v-list>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="4" class="pl-0">
          <v-card class="align-self-start">
            <v-card-title>
              <h4>その他</h4>
            </v-card-title>
            <v-card-text>
              <v-list>
                <v-list-item-group v-model="tab">
                  <v-list-item
                    v-for="(item, i) in otherSettingItems"
                    :key="i" :value="item.target"
                  >
                    <v-list-item-content v-text="item.text"/>
                  </v-list-item>
                </v-list-item-group>
              </v-list>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
  import SettingStory from "../../components/admin/campaign/setting-story/SettingStory";
  import LpRegister from "../../components/admin/campaign/lp-register/LpRegister";
  import MailLineIntroduction from "../../components/admin/campaign/mail-line-introduction/MailLineIntroduction";
  import PeriodSetting from "../../components/admin/campaign/setting-period/PeriodSetting";
  import RewardSetting from "../../components/admin/campaign/setting-reward/RewardSetting";
  import LineRichImages from "../../components/admin/campaign/line-rich-image/LineRichImages";
  import RankExcept from "../../components/admin/campaign/rank-except/RankExcept";
  import LeadExtend from "../../components/admin/campaign/lead-extend/LeadExtend";
  import LpReward from "../../components/admin/campaign/lp-reward/LpReward";
  import LineRegister from "../../components/admin/campaign/line-register/LineRegister";
  import ContractIpExcept from "../../components/admin/campaign/contract-ip-except/ContractIpExcept";
  import RankingSummary from "../../components/admin/campaign/ranking-summary/RankingSummary";
  import PrizeSetting from "../../components/admin/campaign/prize-setting/PrizeSetting";

  export default {
    components: {
      PrizeSetting, RankingSummary, ContractIpExcept, LpReward, LineRegister, RankExcept, LineRichImages,
      RewardSetting, MailLineIntroduction, SettingStory, LpRegister, PeriodSetting, LeadExtend
    },
    data() {
      const campaign_id = parseInt(this.$route.params.id)
      return {
        campaign_id: isNaN(campaign_id)? 0 : campaign_id,
        tab: '',
        campaignSettingItems: [
          {text: 'ストーリー', target: 'story'},
          {text: 'LP登録', target: 'lp-reg'},
          {text: '期間設定', target: 'period-set'},
          {text: 'LINE用リッチ画像', target: 'line-rich-img'},
          {text: 'メール/LINE紹介文', target: 'mail-line-intro'},
          {text: 'LINE連携', target: 'line-register'},
        ],
        transferSettingItems: [
          {text: '報酬額設定', target: 'reward-set'},
          {text: 'LP別報酬', target: 'lp-reward'},
          {text: '先行 / 延長設定', target: 'lead-extend'},
          {text: '限定設定', target: ''},
          {text: '賞品登録', target: 'prize-setting'},
        ],
        otherSettingItems: [
          {text: 'ランキング対象外者', target: 'rank-except'},
          {text: '成約除外IP設定', target: 'ip-except'},
          {text: 'コンバージョン', target: ''},
          {text: 'ランキング集計', target: 'rank-summary'},
        ],
        campaign: {id: 0, title: '', image: ''},
      }
    },
    mounted() {
      axios.get(`/admin/campaign/get/${this.campaign_id}`)
      .then(res => {
        this.campaign = res.data.campaign
      })
      .catch(e => {
        console.log(e.response)
      })
    },
    computed: {
      editStory: () => (this.tab === 'story'),
      editLpReg: () => (this.tab === 'lp-reg'),
      editLineRichImg: () => (this.tab === 'line-rich-img'),
      editMailLineIntro: () => (this.tab === 'mail-line-intro'),
      editPeriod: () => (this.tab === 'period-set'),
      editSettingReward: () => (this.tab === 'reward-set'),
    },
    methods: {
      selectCampaign() {},
    },
    watch: {
      tab: (val, old) => {console.log(val)}
    }
  }
</script>

<style scoped>
  .v-list-item {
    margin: 5px !important;
    box-shadow: 1px 2px 3px #bbb;
  }
</style>