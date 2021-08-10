<template>
  <v-card class="asp-item">
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
        <v-col cols="12" class="_item-subtitle" v-if="$date(item.date_end).isBefore(today)">
          開催終了
        </v-col>
        <v-col cols="12" class="_item-subtitle" v-else>
          {{item.date_start}} - {{item.date_end}}
        </v-col>
        <v-col cols="12" class="_item-text">
          <label>アフィリエイター数</label> <label>{{format(item.affiliates)}}</label>
        </v-col>
        <v-col cols="12" class="_item-text">
          <label>登録案件累計数</label> <label>{{format(item.registered_projects)}}</label>
        </v-col>
        <v-col cols="12" class="_item-text">
          <label>累計支払い報酬額</label> <label>{{format(item.rewards)}}</label>
        </v-col>
        <v-col cols="12" class="_item-text">
          <label>全体平均棄却率</label> <label>{{item.reject_rate}}%</label>
        </v-col>
        <v-col cols="12" class="_item-text">
          <label>平均単価</label> <label>{{item.average_unit}}</label>
        </v-col>
      </v-row>
    </v-card-text>

    <v-card-actions class="d-flex justify-center">
      <v-btn
        outlined
        :to="`/user/asp/campaigns/${item.id}`"
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
        title: {type: String, default: ''},
        image: {type: String, default: ''},
        date_start: {type: String, default: ''},
        date_end: {type: String, default: ''},
        affiliates: {type: Number, default: 0},
        registered_projects: {type: Number, default: 0},
        rewards: {type: Number, default: 0},
        reject_rate: {type: Number, default: 0},
        average_unit: {type: Number, default: 0},
      }
    },
    data: () => ({
      today : this.$date()
    }),
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
  .asp-item {
    height: 500px;
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