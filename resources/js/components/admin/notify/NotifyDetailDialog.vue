<template>
  <section>
    <v-dialog
      v-model="dialog"
      persistent
      max-width="600"
      class="qa-new-dlg"
    >
      <v-card>
        <v-card-title class="headline">お知らせ詳細</v-card-title>
        <v-divider/>
        <v-card-text class="py-0">
          <v-container fluid class="py-0">
            <v-row>
              <v-col cols="3">
                <v-label>タイプ</v-label>
              </v-col>
              <v-col cols="9">
                <v-text-field
                  outlined
                  v-model="ntype"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">
                <v-label>対象者</v-label>
              </v-col>
              <v-col cols="9">
                <v-select
                  :items="users"
                  item-text="name"
                  item-value="id"
                  outlined
                  v-model="user"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">
                <v-label>タイトル</v-label>
              </v-col>
              <v-col cols="9">
                <v-chip-group
                  v-model="title"
                  column
                  active-class="primary white--text"
                >
                  <v-chip
                    v-for="title in titles"
                    :key="title.value"
                    :value="title.value">
                    {{ title.label }}
                  </v-chip>
                </v-chip-group>
                <v-text-field
                  v-if="showTitleInput"
                  v-model="text"
                  label="全体"
                />
              </v-col>
            </v-row>
            <v-divider/>
            <v-row>
              <v-col cols="3">
                <v-label>詳細</v-label>
              </v-col>
              <v-col cols="9">
                <v-textarea
                  outlined
                  v-model="content"
                />
              </v-col>
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
      users: {
        type: Array,
        default() {
          return []
        }
      }
    },
    data() {
      return {
        ntype: '',
        subject: '',
        content: '',
        showTitleInput: false,
        titles: [
          {value: 'affiliate', label: 'アフィリエイター', text: 'アフィリエイター'},
          {value: 'advertiser', label: '広告主', text: '広告主'},
          {value: 'all', label: '全体', text: ''},
        ],
        title: '',
        user: null,
        text: ''
      }
    },
    watch: {
      title(val) {
        console.log(val)
        this.showTitleInput = val === 'all'
      }
    },
    methods: {
      hide() {
        this.$emit('onNewDlgClose')
      },
      save() {
        const val = {
          affiliate: this.affiliate,
          subject: this.subject,
          content: this.content,
        }
        this.$emit('onCreated', val)
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