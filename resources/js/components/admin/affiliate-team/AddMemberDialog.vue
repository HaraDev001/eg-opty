<template>
  <section>
    <v-dialog
      v-model="dialog"
      persistent
      max-width="600"
    >
      <v-card>
        <v-card-title class="text-center justify-center">新規メンバー追加</v-card-title>
        <v-divider/>
        <v-card-text class="py-0">
          <v-container fluid class="py-0">
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>メンバー</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-select
                  outlined dense
                  :items="affiliates"
                  item-text="name_full"
                  item-value="id"
                  v-model="item.affiliate_id"
                />
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-divider/>
        <v-card-actions class="d-flex justify-center">
          <v-btn color="alert" dark @click="$emit('onMemberDlgClose')">キャンセル</v-btn>
          <v-btn color="#C694F9" dark @click="save">追加する</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </section>
</template>

<script>
  export default {
    props: {
      dialog: false,
      affiliates: {type: Array, default: []},
    },
    data() {
      return {
        item: {
          affiliate_id: '',
        }
      }
    },
    methods: {
      save() {
        this.$emit('onNewMember', this.item)
      }
    }
  }
</script>

<style scoped>
</style>