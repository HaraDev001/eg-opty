<template>
  <v-row justify="center">
    <v-dialog
      class="delete-lp-reward-dialog"
      v-model="show"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-card-title class="_title">
          LPの削除
        </v-card-title>
        <v-divider/>
        <v-card-text class="_content">
          <strong>
            このアイテムを削除してもよろしいですか？
          </strong>
        </v-card-text>
        <v-card-actions class="_action justify-center">
          <v-btn @click="$emit('onDeleteCancel')">キャンセル</v-btn>
          <v-btn dark color="error"
                 @click="$emit('onDeleteConfirm', item)">削除</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
  export default {
    props: {
      show: {type:Boolean, default: false},
      item: {
        type: Object,
        id: {type: Number, default: 0},
        campaign_id: {type: Number, default: 0},
        title: {type:String, default: ''},
        url: {type:String, default:''},
        banner: {type:String, default: ''},
        is_public: {type: Number, default: 1},
        redirect_pc: {type: String, default: ''},
        redirect_mobile: {type: String, default: ''},
        show_type: {type: String, default: 'banner'},
      },
    },
    data: vm => ({
    }),
    methods: {
    }
  }
</script>

<style scoped lang="scss">
</style>