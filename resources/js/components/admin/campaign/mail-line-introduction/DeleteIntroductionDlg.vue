<template>
  <v-row justify="center">
    <v-dialog
      class="_delete-intro-dialog"
      v-model="show"
      max-width="600px"
    >
      <v-card>
        <v-card-title class="_title">
          紹介の削除
        </v-card-title>
        <v-divider/>
        <v-card-text class="_content">
          {{item.title}}を削除しますか？
        </v-card-text>
        <v-card-actions class="_action d-flex justify-center">
          <v-btn @click="$emit('onDeleteClose')">キャンセル</v-btn>
          <v-btn dark color="error" @click="$emit('onDeleteConfirm', item)">削除</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
  export default {
    props: {
      show: Boolean,
      item: {
        type: Object,
        id: {type: Number, default: 0},
        title: {type:String, default: ''}
      }
    },
    data: vm => ({
    }),
    methods: {
    }
  }
</script>

<style scoped lang="scss">

</style>