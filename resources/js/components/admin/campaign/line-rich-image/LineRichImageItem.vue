<template>
  <v-card class="_line-rich-image mr-2">
    <v-card-text>
      <v-img width="320" height="180" contain :src="item.url"/>
    </v-card-text>
    <v-card-actions class="d-flex justify-center">
      <v-btn dark color="error" @click="$emit('onDeleteImage', item)">
        削除
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
        lp_id: {type: Number, default: 0},
        url: {type: String, default: ''},
      }
    }
  }
</script>

<style scoped>
._line-rich-image {
  width: 340px;
  /*height: 240px;*/
  display: inline-block;
}
</style>