<template>
  <v-col
    cols="12" sm="6" md="4" lg="3"
    class="d-flex justify-center align-center"
  >
    <label class="mr-3">{{item.ip}}</label>
    <v-btn
      dark color="error"
      @click="$emit('onDelete', item)"
    >
      削除
    </v-btn>
  </v-col>
</template>

<script>
  export default {
    props: {
      item: {
        type: Object,
        id: {type: Number, default: 0},
        campaign_id: {type: Number, default: 0},
        ip: {type: String, default: ''}
      }
    }
  }
</script>

<style scoped>

</style>