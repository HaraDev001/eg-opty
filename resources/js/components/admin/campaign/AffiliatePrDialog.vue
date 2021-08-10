<template>
  <v-row justify="center">
    <v-dialog
      class="affiliate-pr-dialog"
      v-model="dialog"
      persistent
      scrollable
      max-width="600px"
    >
      <v-card>
        <v-card-title class="affiliate-pr-dialog_title headline">
          アフィリエイター向け PR文
        </v-card-title>
        <hr/>
        <v-card-text class="affiliate-pr-dialog_content">
          <v-container class="px-0">
            <v-row>
              <v-col class="text-center">
                <v-tabs
                  v-model="tab"
                  background-color="primary"
                  dark
                >
                  <v-tab href="#text">
                    本文編集
                  </v-tab>
                  <v-tab href="#html">
                    HTML表示
                  </v-tab>
                </v-tabs>

                <v-tabs-items v-model="tab">
                  <v-tab-item value="text">
                    <v-card flat>
                      <v-card-text>
                        <v-textarea v-model="content"/>
                      </v-card-text>
                    </v-card>
                  </v-tab-item>
                  <v-tab-item value="html">
                    <v-card flat>
                      <v-card-text>
                        <div v-html="content"></div>
                      </v-card-text>
                    </v-card>
                  </v-tab-item>
                </v-tabs-items>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions class="affiliate-pr-dialog_action">
          <v-btn @click="dialog = false">保存</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
  export default {
    props: {
      dialog: Boolean,
      content: String
    },
    data: vm => ({
      tab: 'text',
    }),
    methods: {
    }
  }
</script>

<style scoped lang="scss">
  .affiliate-pr-dialog {

    &_title {
      text-align: center;
      display:block !important;
    }

    &_block {
      padding-right: 20px;
      padding-left: 20px;
      border-bottom: 1px solid #777;
    }

    &_block_preview, &_block_edit {
      width: 100%;
      min-height: 400px;
      max-height: 600px;
    }

    &_action {
      justify-content: center;
      padding: 10px 0 20px !important;
    }
  }
</style>