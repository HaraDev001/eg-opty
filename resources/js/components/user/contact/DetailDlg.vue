<template>
  <section>
    <v-dialog
      v-model="show"
      persistent
      max-width="600"
      class="qa-new-dlg"
    >
      <v-card>
        <v-card-title class="headline">お問い合わせ詳細</v-card-title>
        <v-divider/>
        <v-card-text class="py-0">
          <v-container fluid class="py-0">
            <v-row>
              <v-col cols="3">
                <v-label>アフィリエイターID</v-label>
              </v-col>
              <v-col cols="9">
                <v-text-field
                  outlined dense hide-details readonly
                  v-model="data.affiliate_name"
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
                  outlined dense hide-details readonly
                  v-model="data.subject"
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
                  outlined dense hide-details readonly
                  v-model="data.content"
                />
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-divider/>
        <v-card-actions class="d-flex justify-center">
          <v-btn color="error" dark @click="$emit('onDetailClose')">キャンセル</v-btn>
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
        id: {type: Number, default: 0},
        affiliate_id: {type:Number, default: 0},
        affiliate_name: {type:String, default:''},
        subject: {type:String, default:''},
        content: {type:String, default:''},
      }
    },
    data() {
      return {
        data: {id: 0, affiliate_id: 0, affiliate_name: '', subject: '', content: '',}
      }
    },
    watch: {
      item(val) {
        this.data = val
      }
    },
    methods: {
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