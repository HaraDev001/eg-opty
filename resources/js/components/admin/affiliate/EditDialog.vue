<template>
  <section>
    <v-dialog
      v-model="dialog"
      persistent
      max-width="600"
    >
      <v-card>
        <v-card-title class="text-center justify-center">アフィリエイト編集</v-card-title>
        <v-divider/>
        <v-card-text class="py-0">
          <v-container fluid class="py-0">
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>名前</v-label>
              </v-col>
              <v-col cols="4" class="pb-0">
                <v-text-field
                  label="姓"
                  outlined dense
                  v-model="value.name_last"
                />
              </v-col>
              <v-col cols="4" class="pb-0">
                <v-text-field
                  label="名"
                  outlined dense
                  v-model="value.name_first"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>フリガナ</v-label>
              </v-col>
              <v-col cols="4" class="pb-0">
                <v-text-field
                  outlined dense
                  label="姓"
                  v-model="value.name_furi_last"
                />
              </v-col>
              <v-col cols="4" class="pb-0">
                <v-text-field
                  label="名"
                  outlined dense
                  v-model="value.name_furi_first"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>Mail Address</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  v-model="value.mail"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>Password</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  v-model="value.password"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>Password(再入力)</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  v-model="value.password_confirm"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>ランク</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  v-model="value.rank"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>ニックネーム</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  v-model="value.nickname"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>備考</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  v-model="value.note"
                />
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-divider/>
        <v-card-actions class="d-flex justify-center">
          <v-btn color="alert" dark @click="$emit('onEditDlgClose')">キャンセル</v-btn>
          <v-btn color="#5367FD" dark @click="save(1)">下書き</v-btn>
          <v-btn color="#C694F9" dark @click="save(2)">登録する</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </section>
</template>

<script>
  export default {
    props: {
      dialog: false,
      item: {
        type: Object,
        default: () => null
      }
    },
    data() {
      return {
        value: {
          id: 0,
          name_last: '',
          name_first: '',
          name_furi_last: '',
          name_furi_first: '',
          mail: '',
          password: '',
          password_confirm: '',
          rank: '',
          company: '',
          company_furi: '',
          zip: '',
          address: '',
          phone: ''
        }
      }
    },
    watch: {
      item(val) {
        if(val !== null) this.value = val
      }
    },
    methods: {
      save(flag) {
        this.$emit('onEdited', this.item, flag)
      }
    }
  }
</script>

<style scoped>
</style>