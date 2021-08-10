<template>
  <v-row justify="center">
    <v-dialog
      class="_detail-intro-dialog"
      v-model="show"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-card-title class="_title">
          詳細
        </v-card-title>
        <v-divider/>
        <v-card-text class="_content">
          <v-row>
            <v-col cols="3">タイトル</v-col>
            <v-col cols="9">{{item.title}}</v-col>
          </v-row>
          <v-row>
            <v-col cols="3">内容</v-col>
            <v-col cols="9">
              <div v-html="item.content"></div>
            </v-col>
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
        title: {type:String, default: ''},
        content: {type: String, default: ''},
      }
    },
    data: vm => ({
    }),
    methods: {
    }
  }
</script>

<style scoped lang="scss">
._detail-intro-dialog {
  ._title {}
  ._content {}
  ._action {
    display: flex;
    justify-content: center;
  }
}
</style>