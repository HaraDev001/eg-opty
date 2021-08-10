<template>
  <div class="page_wrap_vue pa-3 qa-page">
    <v-card class="mx-auto">
      <v-card-title class="_header d-flex justify-space-between">
        <h3>よくある質問</h3>
        <v-btn
          class="_header_button"
          @click="show_new=true"
        >
          新規作成
        </v-btn>
      </v-card-title>

      <v-card-text class="_content">
        <v-simple-table>
          <template v-slot:default>
            <thead>
            <tr>
              <th class="text-left" id="_th1">ID</th>
              <th class="text-left" id="_th2">タイトル</th>
              <th class="text-left" id="_th3">カテゴリ</th>
              <th class="text-left" id="_th4">質問</th>
              <th class="text-left" id="_th5">回答</th>
              <th class="text-left" id="_th6"/>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
              <td>{{ item.id }}</td>
              <td>{{ item.title }}</td>
              <td>{{ item.category }}</td>
              <td>{{ item.question }}</td>
              <td>{{ item.answer }}</td>
              <td>
                <v-btn color="purple" dark @click="showDetail(item)">詳細</v-btn>
                <v-btn color="error" dark @click="showDelete(item)">棄却</v-btn>
              </td>
            </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-card-text>

      <v-card-actions class="_action justify-center">
        <v-btn @click="showMore" text>もっと見る</v-btn>
      </v-card-actions>
    </v-card>
    <NewDlg
      :show="show_new"
      :categories="categories"
      @onNewClose="show_new=false"
      @onCreated="onNew"
    />
    <DetailDlg
      :show="show_detail"
      :categories="categories"
      :item="selected"
      @onDetailClose="show_detail=false"
    />
    <DeleteDlg
      :show="show_delete"
      :item="selected"
      @onDeleteClose="show_delete=false"
      @onDeleted="onDelete"
    />
  </div>
</template>

<script>
  import NewDlg from "../../components/user/qa/QaNewDialog";
  import DetailDlg from "../../components/user/qa/QaDetailDialog";
  import DeleteDlg from "../../components/user/qa/QaDeleteDialog";

  export default {
    components: {NewDlg, DetailDlg, DeleteDlg},
    data() {
      return {
        show_new: false,
        show_detail: false,
        show_delete: false,
        selected: null,
        page: 0,
        size: 5,
        categories: [],
        all_items: [],
        items: [],
      }
    },
    mounted() {
      // load categories and QAs
      this.all_items = [
        {id: 1, title: 'title1', category: 'category1', question: 'question1', answer: 'answer1'},
        {id: 2, title: 'title2', category: 'category2', question: 'question2', answer: 'answer2'},
        {id: 3, title: 'title3', category: 'category3', question: 'question3', answer: 'answer3'},
        {id: 4, title: 'title4', category: 'category4', question: 'question4', answer: 'answer4'},
        {id: 5, title: 'title5', category: 'category5', question: 'question5', answer: 'answer5'},
        {id: 6, title: 'title6', category: 'category6', question: 'question6', answer: 'answer6'},
        {id: 7, title: 'title7', category: 'category7', question: 'question7', answer: 'answer7'},
        {id: 8, title: 'title8', category: 'category8', question: 'question8', answer: 'answer8'},
        {id: 9, title: 'title9', category: 'category9', question: 'question9', answer: 'answer9'},
        {id: 10, title: 'title10', category: 'category10', question: 'question10', answer: 'answer10'},
      ]
      this.categories = [{id:1,name:'category1'}, {id:2,name:'category2'}, {id:3,name:'category3'}]
      this.loadItem(this.limit)
    },
    computed: {
      limit() {
        return (this.page + 1) * this.size
      }
    },
    methods: {
      showMore() {
        this.page++
        const start = this.page * this.size
        const end = start + this.size
        const new_items = this.all_items.filter((item, key) => key >= start && key < end)
        this.items = [...this.items, ...new_items]
      },
      loadItem(limit) {
        console.log(limit)
        this.items = this.all_items.slice(0, limit)
      },
      showDetail(qa) {
        this.selected = qa
        this.show_detail = true
      },
      showDelete(qa) {
        this.selected = qa
        this.show_delete = true
      },
      onNew(qa, categories) {
        /**
         * save new Qa to server
         */
        this.all_items.unshift(qa)
        this.categories = categories
        this.loadItem(this.limit)
        this.show_new = false
      },
      onDelete(val) {
        /**
        * delete Qa from server
        */
        const index = this.all_items.findIndex(m => m.id === val.id)
        if(index === -1) return
        this.all_items.splice(index, 1)
        this.loadItem(this.limit)
        this.show_delete = false
      },
    }
  }
</script>