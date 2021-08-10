<template>
  <v-card class="_prize-item">
    <v-card-title class="_prize-item_header">
      <h4>{{item.contract_rank}}位 {{item.prize_name}}</h4>
      <v-icon color="warning" class="_prize-item_delete" @click="$emit('onDeleteItem', item)">mdi-close-circle</v-icon>
    </v-card-title>
    <v-card-text class="_prize-item_body">
      <v-img height="200" width="200" contain :src="item.image"/>
    </v-card-text>
  </v-card>
</template>

<script>
  export default {
    props: {
      item: {
        type: Object,
        id: {type:Number, default: 0},
        campaign_id: {type: Number, default: 0},
        contract_rank: {type:Number, default: 0},
        prize_name: {type:String, default: ''},
        image: {type:String, default: ''}
      }
    }
  }
</script>

<style scoped>
  ._prize-item {
    width: 200px !important;
    display: inline-block;
  }
  ._prize-item_header {
    position: relative;
  }
  ._prize-item_header h4 {
    width: 100%;
    text-align: center;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
  }
  ._prize-item_delete {
    position: absolute;
    top: 0;
    right: 0;
  }
</style>