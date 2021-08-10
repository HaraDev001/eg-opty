<template>
  <v-row justify="center">
    <v-dialog
      class="delete-lead-dialog"
      v-model="show"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-card-title class="_title">
          削除
        </v-card-title>
        <v-divider/>
        <v-card-text class="_content">
          <strong>
            このアイテムを削除してもよろしいですか？
          </strong>
        </v-card-text>
        <v-card-actions class="_action justify-center">
          <v-btn @click="$emit('onDeleteClose')">キャンセル</v-btn>
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
        search_type: {type: String, default: 'member'},
        keyword: {type: String, default: ''},
        member_id: {type: String, default: ''},
        team_id: {type: String, default: ''},
        start_date: {type: String, default: ''},
        start_time: {type: String, default: ''}
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