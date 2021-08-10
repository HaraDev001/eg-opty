<template>
  <v-dialog v-model="dialog" persistent max-width="600">
    <v-card>
      <v-card-title>下書き報酬額一覧</v-card-title>
      <v-divider/>
      <v-card-text class="pb-0">
        <v-simple-table>
          <template v-slot:default>
            <thead>
            <tr>
              <th class="text-left" id="_th1">ID</th>
              <th class="text-left" id="_th2">アフィリエイター名</th>
              <th class="text-left" id="_th3">報酬発生日</th>
              <th class="text-left" id="_th4">報酬支払日</th>
              <th class="text-left" id="_th5">報酬金額</th>
              <th class="text-left" id="_th6">備考</th>
              <th class="text-left" id="_th7"> </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in drafts" :key="item.id">
              <td>{{ item.id }}</td>
              <td>{{ affiliate_name(item.affiliate_id) }}</td>
              <td>{{ $date(item.made_at).format('YYYY/MM/DD HH:mm') }}</td>
              <td>{{ $date(item.pay_at).format('YYYY/MM/DD HH:mm') }}</td>
              <td>{{ item.amount }}円</td>
              <td>{{ item.note === '' ? item.note : 'なし' }}</td>
              <td>
                <v-btn color="#C694F9" dark @click="editDraft(item)">
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
        default: () => []
      },
      affiliates: {
        type: Array,
        default: () => []
      },
    },
    data() {
      return {
      }
    },
    methods: {
      affiliate_name(aid) {
        const aff = this.affiliates.find(aff => aff.id ===aid)
        return aff === undefined ? '' : aff.name_last + aff.name_first
      },
      hide() {
        this.$emit('onDraftDlgClose')
      },
      editDraft(val) {
        this.$emit('onEditDraft', val)
      }
    }
  }
</script>
