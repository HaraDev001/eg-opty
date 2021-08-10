<template>
  <v-row justify="center">
    <v-dialog
      class="_bulk-edit-reward-dlg"
      v-model="show"
      max-width="600px"
    >
      <v-card>
        <v-card-title class="_title">報酬削除</v-card-title>
        <v-divider/>
        <v-card-text class="_content">
          <v-row>
            <v-col cols="12">
              <h3 class="text-center">報酬を削除しんか？</h3>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions class="_action d-flex justify-center">
          <v-btn @click="$emit('onDeleteClose')">キャンセル</v-btn>
          <v-btn dark color="warning" @click="$emit('onDeleteYes', item)">削除</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </v-row>
</template>

<script>
  import vuetifyToast from "vuetify-toast";

  export default {
    props: {
      show: Boolean,
      item: {
        type: Object,
        id: {type: Number, default: 0},
        start: {type: String, default: ''},
        end: {type: String, default: ''},
        is_show: {type: Number, default: 1}
      }
    },
    data: vm => ({
    }),
    methods: {
      deleteReward() {{

      }}
    }
  }
</script>

<style scoped lang="scss">

</style>