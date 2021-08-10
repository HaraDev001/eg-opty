<template>
  <section>
    <v-dialog
      v-model="show"
      persistent
      max-width="600"
      class="qa-detail-dlg"
    >
      <v-card>
        <v-card-title class="headline">質問詳細</v-card-title>
        <v-divider/>
        <v-card-text class="py-0">
          <v-container fluid class="py-0">
            <v-row>
              <v-col cols="3">
                <v-label>カテゴリ</v-label>
              </v-col>
              <v-col cols="9" class="select-wrap">
                <v-select
                  outlined dense hide-details readonly
                  v-model="qa.category.id"
                  :items="categories"
                  item-text="name" item-value="id"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">
                <v-label>質問</v-label>
              </v-col>
              <v-col cols="9">
                <v-textarea
                  outlined dense hide-details readonly
                  v-model="qa.question"
                  class="qa-question"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">
                <v-label>回答</v-label>
              </v-col>
              <v-col cols="9">
                <v-textarea
                  outlined dense hide-details readonly
                  v-model="qa.answer"
                  class="qa-answer"
                />
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-divider/>
        <v-card-actions class="qa-actions">
          <v-btn color="error" dark @click="$emit('onDetailClose')">閉じる</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </section>
</template>

<script>
  export default {
    props: {
      show: false,
      item: {
        type: Object,
        id: {type: Number, default: 0},
        title: {type: String, default: ''},
        category: {type: Object, default: null},
        question: {type: String, default: ''},
        answer: {type: String, default: ''},
      },
      categories: {type: Array, default: []}
    },
    data:() => ({
      qa: {id: 0, title: '', category: {id: 0, name: ''}, question: '', answer: ''}
    }),
    watch: {
      item(val) { this.qa = val },
    },
    methods: {}
  }
</script>

<style scoped>
  .headline {
    font-size: 1.25rem;
  }
  .qa-category {
    margin-right: 15px;
  }
  .qa-question, .qa-answer {
    padding-top: 0;
    margin-top: 0;
  }
  .add-category {
    position: absolute;
    top: 20px;
    right: 15px;
  }
  .select-wrap {
    padding-right: 60px;
    position: relative;
  }
  .qa-actions {
    padding: 20px 15px;
    display: flex;
    justify-content: center;
  }
</style>