<template>
  <v-card class="campaign-item">
    <v-img
      :src="item.image"
      class="white--text align-end campaign-item_img"
      gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
    />

    <v-card-text class="campaign-item_title">
      {{item.title}}
    </v-card-text>
    <v-card-text class="campaign-item_subtitle" v-if="ended">
      <strong>開催終了</strong>
    </v-card-text>
    <v-card-text class="campaign-item_subtitle" v-else>
      {{item.date_start}} - {{item.date_end}}
    </v-card-text>
    <v-card-text class="campaign-item_text">
      登録数 {{format(item.register_number)}}
    </v-card-text>
    <v-card-text class="campaign-item_text">
      経費 {{format(item.expense)}}
    </v-card-text>
    <v-card-text class="campaign-item_text">
      ブロック数 {{format(item.block_number)}}({{format(item.block_rate)}}%)
    </v-card-text>
    <v-card-text class="campaign-item_text">
      平均LP登録率 {{item.average_lp_register_rate}}%
    </v-card-text>

    <v-card-actions class="d-flex justify-center mt-2">
      <v-btn
        outlined
        :to="{name:'admin.campaign.detail'}"
      >詳細</v-btn>
    </v-card-actions>

    <v-card-actions class="d-flex justify-center pb-4">
      <v-btn rounded dark color="#FF7777">実績</v-btn>
      <v-btn
        rounded dark color="#5367FD"
        :to="`/admin/campaign/setting/${item.id}`"
      >
        設定
      </v-btn>
      <v-btn
        rounded dark color="#1DE9B6"
        :to="`/admin/campaign/edit/${item.id}`"
      >
        編集
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
  export default {
    props: {
      item: {
        type: Object,
        id: {type: Number, default: 0},
        title: {type: String, default: ''},
        image: {type: String, default: ''},
        date_start: {type: String, default: ''},
        date_end: {type: String, default: ''},
        register_number: {type: Number, default: 0},
        expense: {type: Number, default: 0},
        block_number: {type: Number, default: 0},
        block_rate: {type: Number, default: 0},
        average_lprr: {type: Number, default: 0},
      }
    },
    computed: {
      ended() {
        return this.$date(this.item.date_end).isBefore(this.$date())
      }
    },
    methods: {
      format(val,digs=0) {
        return val.toFixed(digs).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
      },
      edit() {
        this.$router.push()
      }
    }
  }
</script>

<style scoped lang="scss">
  .campaign-item {
    /*height: 500px;*/

    &_title, &_subtitle, &_text {
      text-align: center;
      padding: 10px 16px 0 !important;
    }

    &_text {
      text-align: center;
      padding: 7px 16px 0 !important;
    }

    &_title {
      font-size: 1.1rem !important;
      font-weight: 600;
    }
  }
</style>