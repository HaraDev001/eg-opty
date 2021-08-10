<template>
  <v-row justify="center">
    <v-dialog
      class="_new-intro-dialog"
      v-model="show"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-card-title class="_title">
          新規紹介文登録
        </v-card-title>
        <v-divider/>
        <v-card-text class="_content">
          <v-row>
            <v-col cols="3">タイトル</v-col>
            <v-col cols="9">
              <v-text-field
                dense outlined
                v-model="item.title"
                :rules="[v=>!!v || 'タイトルが必要です。']"
              />
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="3">本文</v-col>
            <v-col cols="9">
              <v-textarea
                :rules="[v=>!!v || '本文が必要です。']"
                dense outlined
                v-model="item.content"
              />
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions class="_action d-flex justify-center">
          <v-btn @click="$emit('onNewClose')">キャンセル</v-btn>
          <v-btn dark color="success" @click="$emit('onNew', item)">保存</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
  export default {
    props: {
      show: Boolean,
    },
    data: vm => ({
      item: {
        id: 0,
        title: '',
        content: '',
        target: ''
      }
    }),
    methods: {
    }
  }
</script>

<style scoped lang="scss">

</style>