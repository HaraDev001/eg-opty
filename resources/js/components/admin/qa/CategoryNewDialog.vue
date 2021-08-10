<template>
  <v-dialog v-model="dialog" persistent max-width="600">
    <v-card>
      <v-card-text class="pb-0">
        <v-container fluid class="pb-0">
          <v-row>
            <v-col cols="3">
              <v-label>新規カテゴリ</v-label>
            </v-col>
            <v-col cols="9" class="pb-0">
              <v-text-field v-model="category"/>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-btn color="danger" dark @click="hide">キャンセル</v-btn>
        <v-btn color="success" dark @click="save">追加する</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<style scoped>
  .v-card__actions {
    display: flex;
    justify-content: center;
    padding: 0 15px 20px 15px;
  }
</style>

<script>
  export default {
    props: {
      dialog: false,
    },
    data() {
      return {
        category: ''
      }
    },
    methods: {
      hide() {
        this.$emit('onNewCategoryClose')
      },
      save() {
        const val = this.category.trim()
        if(val === '') return
        this.$emit('onNewCategory', val)
      }
    }
  }
</script>
