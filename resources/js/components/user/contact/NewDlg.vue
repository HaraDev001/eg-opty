<template>
  <section>
    <v-dialog
      v-model="show"
      persistent
      max-width="600"
      class="qa-new-dlg"
    >
      <v-card>
        <v-card-title class="headline">新規お問い合わせ</v-card-title>
        <v-divider/>
        <v-card-text class="py-0">
          <v-container fluid class="py-0">
            <v-row>
              <v-col cols="3">
                <v-label>アフィリエイターID</v-label>
              </v-col>
              <v-col cols="9">
                <v-select
                  outlined dense hide-details
                  :items="affiliates"
                  item-value="id" item-text="name"
                  v-model="val.affiliate_id"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">
                <v-label>件名</v-label>
              </v-col>
              <v-col cols="9">
                <v-text-field
                  outlined
                  v-model="val.subject"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">
                <v-label>内容</v-label>
              </v-col>
              <v-col cols="9">
                <v-textarea
                  outlined
                  v-model="val.content"
                />
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-divider/>
        <v-card-actions class="d-flex justify-center">
          <v-btn color="error" dark @click="$emit('onNewClose')">キャンセル</v-btn>
          <v-btn color="success" dark @click="save">登録する</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </section>
</template>

<script>
  export default {
    props: {
      show: false,
      affiliates: {type: Array, default: []}
    },
    data() {
      return {
        val: {affiliate_id: 0, affiliate_name: '', subject: '', content: '',}
      }
    },
    methods: {
      hide() {
        this.$emit('onNewDlgClose')
      },
      save() {
        this.val.affiliate_name = this.affiliates.find(aff => aff.id === this.val.affiliate_id).name
        this.$emit('onCreated', this.val)
      }
    }
  }
</script>

<style scoped>
  .headline {
    font-size: 1.25rem;
  }
  .select-wrap {
    padding-right: 60px;
    position: relative;
  }
</style>