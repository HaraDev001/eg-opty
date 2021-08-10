<template>
  <section>
    <v-dialog
      v-model="dialog"
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
                  v-model="category"
                  :items="categories"
                  item-value="id"
                  item-text="name"
                  class="qa-category"
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
                  outlined
                  v-model="question"
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
                  outlined
                  v-model="answer"
                  class="qa-answer"
                />
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-divider/>
        <v-card-actions class="qa-actions">
          <v-btn color="error" dark @click="hide">閉じる</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </section>
</template>

<script>
  export default {
    props: {
      dialog: false,
      item: {
        type: Object,
        default() {
          return {
            id: 0,
            title: '',
            category: null,
            question: '',
            answer: ''
          }
        }
      },
      categories: {
        type: Array,
        default: () => []
      }
    },
    data() {
      return {
      }
    },
    computed: {
      category() {
        return this.item === null ? '' : this.item.category
      },
      question() {
        return this.item === null ? '' : this.item.question
      },
      answer() {
        return this.item === null ? '' : this.item.answer
      }
    },
    methods: {
      hide() {
        this.$emit('onDetailDlgClose')
      },
    }
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