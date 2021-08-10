<template>
  <section>
    <v-dialog
      v-model="dialog"
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
                  v-model="category"
                  :items="items"
                  item-text="name"
                  item-value="id"
                  class="qa-category"
                />
                <v-btn
                  fab dark small color="primary"
                  @click="show_category_dlg = true"
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
          <v-btn color="error" dark @click="hide">キャンセル</v-btn>
          <v-btn color="success" dark @click="save">保存する</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <CategoryNewDialog
      :dialog="show_category_dlg"
      @onNewCategoryClose="hideCatDlg"
      @onNewCategory="onNewCategory"
    />
  </section>
</template>

<script>
  import CategoryNewDialog from "./CategoryNewDialog";
  import vuetifyToast from 'vuetify-toast'

  export default {
    components: {CategoryNewDialog},
    props: {
      dialog: false,
      categories: {
        type: Array,
        default: () => []
      }
    },
    data() {
      return {
        show: false,
        show_category_dlg: false,
        category: '',
        question: '',
        answer: '',
        items: []
      }
    },
    watch: {
      categories(val) {
        this.items = val.map(e => e)
      }
    },
    methods: {
      hide() {
        this.$emit('onNewDlgClose')
      },
      hideCatDlg() {
        this.show_category_dlg = false
      },
      onNewCategory(val) {
        /**
         * save new category to server
         */
        axios.post('/admin/category/new', {name: val})
        .then(res => {
          this.items = res.data.categories
        })
        .catch(e => {
          vuetifyToast.error('新しいカテゴリを保存できません。')
        })
        this.hideCatDlg()
      },
      save() {
        this.hide()
        const val = {
          category_id: this.category,
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