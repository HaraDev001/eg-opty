<template>
  <section>
    <v-dialog
      v-model="dialog"
      max-width="600"
      persistent
      class="advertiser-new-dlg"
    >
      <v-card>
        <v-card-title class="text-center justify-center">
          {{ val.name_full }}
        </v-card-title>
        <v-card-subtitle class="text-center">{{ val.id }}</v-card-subtitle>
        <v-divider/>
        <v-card-text class="py-0">
          <v-container fluid class="py-0">
            <v-row>
              <v-col cols="3">Mail Address</v-col>
              <v-col cols="9">{{ val.email }}</v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">RANK</v-col>
              <v-col cols="9">{{ val.rank_name }}</v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">登録状況</v-col>
              <v-col cols="9">{{ val.status_label }}</v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">登録日時</v-col>
              <v-col cols="9">{{ $date(val.created_at).format('YYYY/MM/DD') }}</v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">最終更新日時</v-col>
              <v-col cols="9">{{ $date(val.updated_at).format('YYYY/MM/DD') }}</v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">企業名</v-col>
              <v-col cols="9">{{ val.company }}</v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">企業名フリガナ</v-col>
              <v-col cols="9">{{ val.company_furi }}</v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">郵便番号</v-col>
              <v-col cols="9">{{ val.zipcode }}</v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">住所</v-col>
              <v-col cols="9">{{ val.address }}</v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">電話番号</v-col>
              <v-col cols="9">{{ val.phone }}</v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">登録キャンペーン情報</v-col>
              <v-col cols="9"></v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-divider/>
        <v-card-actions class="d-flex justify-center">
          <v-btn color="error" dark @click="hide">キャンセル</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </section>
</template>

<script>
  export default {
    props: {
      dialog: false,
      item: {type: Object, default: null}
    },
    data() {
      console.log(this.item)
      return {
        show: false,
        val: {
          id: 0, name_full: '', furi_full: '', email: '', rank_name: '',
          company: '', company_furi: '', phone: '', address: '',
          zipcode: '', status_label: '', created_at: '', updated_at: ''
        }
      }
    },
    watch: {
      item(val) {
        if(val !== null) this.val = val
      }
    },
    methods: {
      hide() {
        this.$emit('onDetailDlgClose')
      },
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