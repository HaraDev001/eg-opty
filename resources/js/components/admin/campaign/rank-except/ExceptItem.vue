<template>
  <v-row class="_rank-except-item">
    <v-col cols="8" class="d-flex align-center">{{item.affiliate_name}}</v-col>
    <v-col cols="2" class="d-flex align-center">{{item.rank_name}}</v-col>
    <v-col cols="2" class="d-flex align-center">
      <v-btn dark color="error"
             @click="$emit('onExceptDelete', item)"
      >
        削除
      </v-btn>
    </v-col>
  </v-row>
</template>

<script>
  export default {
    props: {
      item: {
        type: Object,
        id: {type: Number, default: 0},
        name: {type: String, default: ''},
        rank: {type: Number, default: 1},
      }
    },
    data: vm => ({
      ranks: ['VIP','S VIP','SS VIP','QUEEN','KING']
    }),
  }
</script>

<style scoped lang="scss">
  ._rank-except-item {

  }
</style>