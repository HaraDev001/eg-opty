<template>
  <v-dialog v-model="dialog" persistent max-width="600">
    <v-card>
      <v-card-title>下書き 新規お問い合わせ</v-card-title>
      <v-divider/>
      <v-card-text class="pb-0">
        <v-simple-table>
          <template v-slot:default>
            <thead>
              <tr>
                <th>名前</th>
                <th>(フリガナ)</th>
                <th>ランク</th>
                <th>ステータス</th>
                <th>保存日</th>
<!--                <th> </th>-->
              </tr>
            </thead>
            <tbody>
            <tr v-for="item in drafts" :key="item.id">
              <td>{{item.name_full}}</td>
              <td>{{item.furi_full}}</td>
              <td>{{item.rank_name}}</td>
              <td>{{item.status_label}}</td>
              <td>{{$date(item.created_at).format('YYYY/MM/DD')}}</td>
<!--              <td>-->
<!--                <v-btn color="primary" dark @click="editDraft(item)">-->
<!--                  編集-->
<!--                </v-btn>-->
<!--              </td>-->
            </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-card-text>
      <v-divider/>
      <v-card-actions class="d-flex justify-center">
        <v-btn color="danger" dark @click="hide">キャンセル</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<style scoped>
</style>

<script>
  export default {
    props: {
      dialog: false,
      drafts: {
        type: Array,
        default() {
          return []
        }
      },
    },
    data() {
      return {
      }
    },
    methods: {
      hide() {
        this.$emit('onDraftDlgClose')
      },
      editDraft(val) {
        this.$emit('onEditDraft', val)
      }
    }
  }
</script>
