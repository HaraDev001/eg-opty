<template>
  <div class="page_wrap_vue pa-3 qa-page">
    <v-card class="mx-auto">
      <v-card-title class="_header">
        <h2>よくある質問</h2>
        <v-btn
          class="_header_button"
          @click="show_new_dlg = true"
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
              <td>{{ item.category.name }}</td>
              <td>{{ item.question }}</td>
              <td>{{ item.answer }}</td>
              <td>
                <v-btn
                  color="#C694F9"
                  dark
                  @click="showDetail(item.id)"
                >
                  詳細
                </v-btn>
                <v-btn
                  color="#F99494"
                  dark
                  @click="showDelete(item.id)"
                >
                  棄却
                </v-btn>
              </td>
            </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-card-text>

      <v-card-actions class="_action">
        <v-btn
          @click="showMore"
          text
        >
          もっと見る
        </v-btn>
      </v-card-actions>
    </v-card>
    <QaNewDialog
      :dialog="show_new_dlg"
      :categories="categories"
      @onNewDlgClose="show_new_dlg = false"
      @onCreated="onNewQa"
    />
    <QaEditDialog
      :dialog="show_edit_dlg"
      :categories="categories"
      :item="selected"
      @onEditDlgClose="show_edit_dlg = false"
      @onEdited="onEditQa"
    />
    <QaDetailDialog
      :dialog="show_detail_dlg"
      :categories="categories"
      :item="selected"
      @onDetailDlgClose="show_detail_dlg = false"
    />
    <QaDeleteDialog
      :dialog="show_delete_dlg"
      :item="selected"
      @onDeleteDlgClose="show_delete_dlg = false"
      @onDeleted="onDeleteQa"
    />
  </div>
</template>

<script>
  import QaNewDialog from "../../../components/admin/qa/QaNewDialog";
  import QaEditDialog from "../../../components/admin/qa/QaEditDialog";
  import QaDetailDialog from "../../../components/admin/qa/QaDetailDialog";
  import QaDeleteDialog from "../../../components/admin/qa/QaDeleteDialog";
  import vuetifyToast from 'vuetify-toast'

  export default {
    components: {QaNewDialog, QaEditDialog, QaDetailDialog, QaDeleteDialog},
    data() {
      return {
        show_new_dlg: false,
        show_edit_dlg: false,
        show_detail_dlg: false,
        show_delete_dlg: false,
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
      axios.get('/admin/qa/list')
      .then(res => {
        console.log(res.data)
        this.all_items = res.data.questions
        this.categories = res.data.categories
        this.loadItem(this.limit)
      })
      .catch(e => {
        vuetifyToast.error('データベースからQ＆Aを読み取ることができません。')
      })
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
      findItem(qid) {
        const item = this.items.find(item => item.id === qid)
        if (item === undefined) return false
        this.selected = item
        return true
      },
      showEdit(qid) {
        if (!this.findItem(qid)) return
        this.show_edit_dlg = true
      },
      showDetail(qid) {
        if (!this.findItem(qid)) return
        this.show_detail_dlg = true
      },
      showDelete(qid) {
        if (!this.findItem(qid)) return
        this.show_delete_dlg = true
      },
      onNewQa(qa, categories) {
        /**
         * save new Qa to server
         */
        console.log(qa)
        console.log(categories)
        this.categories = categories.map(e => e)
        axios.post('/admin/qa/new', qa)
        .then(res => {
          this.all_items = res.data.questions.map(e => e)
          this.loadItem(this.limit)
        })
        .catch(e => {
          vuetifyToast.error('新しい質問を保存できません。')
        })
        // this.all_items.unshift(qa)
        this.show_new_dlg = false
      },
      onDeleteQa(val) {
        /**
        * delete Qa from server
        */
        axios.get(`/admin/qa/delete/${val.id}`)
        .then(res => {
          const id = this.all_items.findIndex(m => m.id === val.id)
          if(id === -1) return
          this.all_items.splice(id, 1)
          this.loadItem(this.limit)
        })
        .catch(e => {
          vuetifyToast.error('質問は削除できません。')
        })
        this.show_delete_dlg = false
      },
    }
  }
</script>