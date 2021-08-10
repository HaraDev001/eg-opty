<template>
  <section>
    <v-dialog
      v-model="show"
      persistent
      max-width="600"
      class="qa-new-dlg"
    >
      <v-card>
        <v-card-title class="headline">新規質問登録</v-card-title>
        <v-divider/>
        <v-card-text class="py-0">
          <v-container fluid class="py-0">
            <v-row>
              <v-col cols="3">
                <v-label>カテゴリ</v-label>
              </v-col>
              <v-col cols="9" class="select-wrap">
                <v-select
                  v-model="category_id"
                  :items="categories"
                  item-value="id" item-text="name"
                  outlined dense hide-details
                />
                <v-btn
                  fab dark small color="primary"
                  @click="show_category = true"
                  class="add-category"
                >
                  <v-icon>mdi-plus</v-icon>
                </v-btn>
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">
                <v-label>質問</v-label>
              </v-col>
              <v-col cols="9">
                <v-textarea
                  outlined dense hide-details
                  v-model="question"
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
                  outlined dense hide-details
                  v-model="answer"
                />
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-divider/>
        <v-card-actions class="qa-actions">
          <v-btn color="error" dark @click="$emit('onNewClose')">キャンセル</v-btn>
          <v-btn color="success" dark @click="save">保存する</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <CategoryNewDialog
      :show="show_category"
      @onNewCategoryClose="show_category=false"
      @onNewCategory="onNewCategory"
    />
  </section>
</template>

<script>
  import CategoryNewDialog from "./CategoryNewDialog";
  export default {
    components: {CategoryNewDialog},
    props: {
      show: false,
      categories: {type: Array, default: []}
    },
    data() {
      return {
        show_category: false,
        category_id: '',
        question: '',
        answer: ''
      }
    },
    methods: {
      onNewCategory(val) {
        /**
         * save new category to server
         */
        this.categories.push({id:9999, name:val})
        this.show_category = false
      },
      save() {
        const val = {
          category: this.categories.findIndex(cat => cat.id === this.category_id),
          question: this.question,
          answer: this.answer
        }
        this.$emit('onCreated', val, this.categories)
      }
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
    top: 10px;
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