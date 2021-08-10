<template>
  <section>
    <v-dialog
      v-model="dialog"
      persistent
      max-width="600"
    >
      <v-card>
        <v-card-title class="text-center justify-center">アカウント管理</v-card-title>
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
                  v-model="item.name_last"
                />
              </v-col>
              <v-col cols="4" class="pb-0">
                <v-text-field
                  label="名"
                  outlined dense
                  v-model="item.name_first"
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
                  v-model="item.mail"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="4" class="pb-0">
                <v-label>新しいPassword</v-label>
              </v-col>
              <v-col cols="8" class="pb-0">
                <v-text-field
                  outlined dense
                  v-model="item.password"
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
                  v-model="item.password_confirm"
                />
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-divider/>
        <v-card-actions class="d-flex justify-center">
          <v-btn color="alert" dark @click="$emit('onAccountClose')">キャンセル</v-btn>
          <v-btn color="#C694F9" dark @click="save">登録する</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </section>
</template>

<script>
  export default {
    props: {
      dialog: false,
    },
    data() {
      return {
        item: {
          name_last: '',
          name_first: '',
          mail: '',
          password: '',
          password_confirm: '',
        }
      }
    },
    methods: {
      save() {
        this.$emit('onNewAccount', this.item)
      }
    }
  }
</script>

<style scoped>
</style>