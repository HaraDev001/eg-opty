<template>
  <section>
    <v-dialog
      v-model="dialog"
      persistent
      max-width="600"
    >
      <v-card>
        <v-card-title class="headline">アフィリエイト削除</v-card-title>
        <v-divider/>
        <v-card-text class="py-10 text-center">
          <h3>アフィリエイトを削除しますか？</h3>
        </v-card-text>
        <v-divider/>
        <v-card-actions class="qa-actions">
          <v-btn color="primary" dark @click="hide">閉じる</v-btn>
          <v-btn color="error" dark @click="deleted">削除じる</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </section>
</template>

<script>
  export default {
    props: {
      dialog: false,
    },
    data() {
      return {
        name: '',
      }
    },
    methods: {
      hide() {
        this.$emit('onDeleteDlgCancel')
      },
      deleted() {
        this.$emit('onDeleteDlgOk')
      }
    }
  }
</script>

<style scoped>
  .headline {
    font-size: 1.25rem;
  }
  .qa-actions {
    padding: 20px 15px;
    display: flex;
    justify-content: center;
  }
</style>