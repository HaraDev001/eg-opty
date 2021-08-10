<template>
  <v-dialog v-model="dialog" persistent max-width="600">
    <v-card>
      <v-card-title>下書き 新規お問い合わせ</v-card-title>
      <v-divider/>
      <v-card-text class="pb-0">
        <v-simple-table>
          <template v-slot:default>
            <tbody>
            <tr v-for="item in drafts" :key="item.id">
              <td>{{ item.date }}</td>
              <td>{{ item.subject }}</td>
              <td>
                <v-btn color="primary" dark @click="editDraft(item.id)">
                  編集
                </v-btn>
              </td>
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
        category: ''
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
