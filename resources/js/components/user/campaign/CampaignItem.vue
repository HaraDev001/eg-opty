<template>
  <v-card class="campaign-item">
    <v-img
      :src="item.image"
      class="white--text align-end _item-img"
      gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
      height="200px"
    >
    </v-img>

    <v-card-text class="">
      <v-row>
        <v-col cols="12" class="_item-title">{{item.title}}</v-col>
        <v-col cols="12" class="_item-subtitle" v-if="ended">
          終了
        </v-col>
        <v-col cols="12" class="_item-subtitle" v-else>
          {{item.date_start}} - {{item.date_end}}
        </v-col>
        <v-col cols="12" class="_item-title" v-if="!ended">{{item.asp_title}}開催</v-col>
        <v-col cols="12" class="_item-text">
          <label>報酬予定額</label> <label>{{format(item.reward_estimate)}}円</label>
        </v-col>
        <v-col cols="12" class="_item-text">
          <label>目標登録数</label> <label>{{format(item.register_number)}}</label>
        </v-col>
        <v-col cols="12" class="_item-text">
          <label>報酬単価</label> <label>{{format(item.reward_unit_min)}}~{{format(item.reward_unit_max)}}円</label>
        </v-col>
        <v-col cols="12" class="_item-text">
          <label>平均LP登録率</label> <label>{{item.average_lp_register_rate}}%</label>
        </v-col>
        <v-col cols="12" class="_item-text">
          <label>LP枚数</label> <label>{{item.lp_number}}</label>
        </v-col>
      </v-row>
    </v-card-text>

    <v-card-actions class="d-flex justify-center pt-0 pb-4">
      <v-btn
        outlined
        :to="`/user/campaign/${item.id}`"
      >詳細</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
  export default {
    props: {
      item: {
        type: Object,
        id: {type: Number, default: 0},
        asp_id: {type: Number, default: 0},
        title: {type: String, default: ''},
        image: {type: String, default: ''},
        date_start: {type: String, default: ''},
        date_end: {type: String, default: ''},
        reward_estimate: {type: Number, default: 0},
        register_number: {type: Number, default: 0},
        reward_unit_min: {type: Number, default: 0},
        reward_unit_max: {type: Number, default: 0},
        average_lp_register_rate: {type: Number, default: 0},
        lp_number: {type: Number, default: 0},
      }
    },
    computed:{
      ended() {
        const val = this.$date(this.item.date_end).isBefore(this.$date())
        console.log(val)
        return val
      }
    },
    methods: {
      format(val,digs=0) {
        return val.toFixed(digs).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
      },
      edit() {
        this.$router.push(`/admin/campaign/edit/${this.item.id}`)
      }
    }
  }
</script>

<style scoped lang="scss">
  .campaign-item {
    height: 525px;
    ._item-img {
      height: 200px;
    }
    ._item-title, ._item-subtitle {
      text-align: center;
      padding: 10px 16px 0 !important;
    }

    ._item-text {
      display: flex;
      justify-content: space-around;
      padding: 7px 16px 0 !important;
    }

    ._item-title {
      font-size: 1.1rem !important;
      font-weight: 600;
    }
  }
</style>