<template>
  <v-row justify="center">
    <v-dialog
      class="_bulk-edit-reward-dlg"
      v-model="show"
      max-width="600px"
    >
      <v-card>
        <v-card-title class="_title">基本報酬</v-card-title>
        <v-divider/>
        <v-card-text class="_content">
          <v-row>
            <v-col cols="3">RANK</v-col>
            <v-col cols="9">
              {{item.rank.name}}
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="3">期間</v-col>
            <v-col cols="9">
              {{$date(item.date_start +' '+ item.time_start).format('YYYY/MM/DD HH:mm')}}から<br>
              {{$date(item.date_end +' '+ item.time_end).format('YYYY/MM/DD HH:mm')}}まで
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="3">報酬金額</v-col>
            <v-col cols="9">{{item.amount}} 円</v-col>
          </v-row>
          <v-row>
            <v-col cols="3">表示の有無</v-col>
            <v-col cols="9">{{item.is_show? '表示': '非表示'}}</v-col>
          </v-row>
        </v-card-text>
        <v-card-actions class="_action d-flex justify-center">
          <v-btn @click="$emit('onDetailClose')">キャンセル</v-btn>
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
        date_start: {type: String, default: ''},
        time_start: {type: String, default: ''},
        date_end: {type: String, default: ''},
        time_end: {type: String, default: ''},
        is_show: {type: Number, default: 1},
        rank: {type:Object, default: () => ({name: ''})}
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