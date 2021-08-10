<template>
  <section>
    <v-dialog
      v-model="show"
      persistent
      max-width="600"
      class="qa-new-dlg"
    >
      <v-card>
        <v-card-title class="headline">お問い合わせ編集</v-card-title>
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
                  item-text="name" item-value="id"
                  v-model="contact.affiliate_id"
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
                  outlined dense hide-details
                  v-model="contact.subject"
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
                  outlined dense hide-details
                  v-model="contact.content"
                />
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-divider/>
        <v-card-actions class="d-flex justify-center">
          <v-btn color="error" dark @click="$emit('onEditClose')">キャンセル</v-btn>
          <v-btn color="success" dark @click="save">保存する</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </section>
</template>

<script>
  export default {
    props: {
      show: false,
      item: {
        type: Object,
        id:{type: Number, default: 0},
        affiliate_id:{type: Number, default: 0},
        affiliate_name:{type: String, default: ''},
        subject:{type: String, default: ''},
        content:{type: String, default: ''},
      },
      affiliates: {type: Array, default: []}
    },
    data() {
      return {
        contact: {id: 0, affiliate_id: 0, affiliate_name: '', subject: '', content: '',}
      }
    },
    watch: {
      item(val) {
        this.contact = val
      }
    },
    methods: {
      save() {
        const val = this.contact
        val.affiliate_name = this.affiliates.find(aff => aff.id === val.affiliate_id).name
        this.$emit('onEdited', val)
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