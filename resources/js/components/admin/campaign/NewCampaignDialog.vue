<template>
  <v-row justify="center">
    <v-dialog
      class="campaign-dialog"
      v-model="dialog"
      persistent
      scrollable
      max-width="600px"
    >
      <v-card>
        <v-card-title class="campaign-dialog_title headline">
          キャンペーン新規登録
        </v-card-title>
        <hr/>
        <v-card-text class="campaign-dialog_content">
          <v-container class="px-0">
            <!-- 出稿広告主 -->
            <v-row class="campaign-dialog_block">
              <v-col cols="4" class="campaign-dialog_block_label">
                <v-label>
                  出稿広告主
                </v-label>
              </v-col>
              <v-col cols="8" class="campaign-dialog_block_control">
                <v-select
                  placeholder="選択してください"
                  :items="['man1', 'man2', 'man3']"
                />
              </v-col>
            </v-row>
            <!-- アイキャッチ画像 -->
            <v-row class="campaign-dialog_block">
              <v-col cols="4" class="campaign-dialog_block_label">
                <v-label>アイキャッチ画像</v-label>
              </v-col>
              <v-col cols="8" class="campaign-dialog_block_control">
                <v-row>
                  <v-col>
                    <v-img class="campaign-dialog_img_preview"/>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col>
                    <v-file-input
                      label="ファイルを選択"
                      hint="横800px, 縦200pxの画像をアップロードしてください。"
                      persistent-hint
                    />
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
            <!-- キャンペーン名 -->
            <v-row class="campaign-dialog_block">
              <v-col cols="4" class="campaign-dialog_block_label">
                <v-label>キャンペーン名</v-label>
              </v-col>
              <v-col cols="8" class="campaign-dialog_block_control">
                <v-text-field placeholder="キャンペーン名"/>
              </v-col>
            </v-row>
            <!-- Youtube予告URL -->
            <v-row class="campaign-dialog_block">
              <v-col cols="4" class="campaign-dialog_block_label">
                <v-label>Youtube予告URL</v-label>
              </v-col>
              <v-col cols="8" class="campaign-dialog_block_control">
                <v-text-field placeholder="Youtube予告URL"/>
              </v-col>
            </v-row>
            <!-- アフィリエイター向け PR文 -->
            <v-row class="campaign-dialog_block">
              <v-col cols="4"  class="campaign-dialog_block_label">
                <v-label>
                  アフィリエイター向け PR文
                </v-label>
              </v-col>
              <v-col cols="8" class="campaign-dialog_block_control">
                <v-row>
                  <v-col>
                    <v-textarea outlined placeholder="アフィリエイター向け PR文"/>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col>
                    <v-btn
                      @click="prDlgShow = true"
                    >
                      詳細編集画面
                    </v-btn>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
            <!-- 成約除外メアドリダイレクトURL -->
            <v-row class="campaign-dialog_block">
              <v-col cols="4"  class="campaign-dialog_block_label">
                <v-label>
                  成約除外メアドリダイレクトURL
                </v-label>
              </v-col>
              <v-col cols="8" class="campaign-dialog_block_control">
                <v-text-field
                  placeholder="成約除外メアドリダイレクトURL"
                  hint="www.example.com/page"
                  persistent-hint
                />
              </v-col>
            </v-row>
            <!-- キャンペーン期間 -->
            <v-row class="campaign-dialog_block">
              <v-col cols="4"  class="campaign-dialog_block_label">
                <v-label>
                  キャンペーン期間
                </v-label>
              </v-col>
              <v-col cols="8" class="campaign-dialog_block_control">
                <v-row>
                  <v-col>
                    <v-menu
                      ref="menuFrom"
                      v-model="menuFrom"
                      :close-on-content-click="false"
                      transition="scale-transition"
                      offset-y
                      max-width="290px"
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="dateFromFormatted"
                          label="Date"
                          hint="MM/DD/YYYY format"
                          persistent-hint
                          prepend-icon="event"
                          suffix="から"
                          @blur="dateFrom = parseDate(dateFrom)"
                          v-on="on"
                        />
                      </template>
                      <v-date-picker v-model="dateFrom" no-title @input="menuFrom = false"/>
                    </v-menu>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col>
                    <v-menu
                      ref="menuFrom"
                      v-model="menuTo"
                      :close-on-content-click="false"
                      transition="scale-transition"
                      offset-y
                      max-width="290px"
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="dateToFormatted"
                          label="Date"
                          hint="期間が確定していない場合は未入力にしてください。"
                          persistent-hint
                          prepend-icon="event"
                          suffix="まで"
                          @blur="dateTo = parseDate(dateTo)"
                          v-on="on"
                        />
                      </template>
                      <v-date-picker v-model="dateTo" no-title @input="menuTo = false"/>
                    </v-menu>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
            <!-- 詳細PDF -->
            <v-row class="campaign-dialog_block">
              <v-col cols="4"  class="campaign-dialog_block_label">
                <v-label>詳細PDF</v-label>
              </v-col>
              <v-col cols="8" class="campaign-dialog_block_control">
                <v-text-field/>
              </v-col>
            </v-row>
            <v-row class="campaign-dialog_block">
              <v-col>
                <h3>オプトイン方式</h3>
              </v-col>
            </v-row>
            <!-- 注意事項 -->
            <v-row class="campaign-dialog_block">
              <v-col cols="4"  class="campaign-dialog_block_label">
                <v-label>注意事項</v-label>
              </v-col>
              <v-col cols="8" class="campaign-dialog_block_control">
                <v-textarea outlined/>
              </v-col>
            </v-row>
            <!-- コンテンツタイプ -->
            <v-row class="campaign-dialog_block">
              <v-col cols="4"  class="campaign-dialog_block_label">
                <v-label>コンテンツタイプ</v-label>
              </v-col>
              <v-col cols="8" class="campaign-dialog_block_control">
                <v-switch v-model="content_show" inset/>
              </v-col>
            </v-row>
            <!-- 会社名表示 -->
            <v-row class="campaign-dialog_block">
              <v-col cols="4"  class="campaign-dialog_block_label">
                <v-label>会社名表示</v-label>
              </v-col>
              <v-col cols="8" class="campaign-dialog_block_control">
                <v-switch v-model="company_show" inset/>
              </v-col>
            </v-row>
            <!-- 表示設定 -->
            <v-row class="campaign-dialog_block">
              <v-col cols="4"  class="campaign-dialog_block_label">
                <v-label>表示設定</v-label>
              </v-col>
              <v-col cols="8" class="campaign-dialog_block_control">
                <v-switch v-model="set_show" inset/>
              </v-col>
            </v-row>
            <!-- 常時掲載案件化 -->
            <v-row class="campaign-dialog_block">
              <v-col cols="4"  class="campaign-dialog_block_label">
                <v-label>常時掲載案件化</v-label>
              </v-col>
              <v-col cols="8" class="campaign-dialog_block_control">
                <v-switch v-model="always_show" inset/>
                <small>
                  "はい"を選択した場合、毎月月初のアフィリエイターランク自動昇格時の対象キャンペーンに入らなくなります。ご注意ください。
                </small>
              </v-col>
            </v-row>
            <v-row class="campaign-dialog_block">
              <v-col>
                <h3>キャンペーン申請に関して</h3>
              </v-col>
            </v-row>
            <!-- キャンペーン概要 -->
            <v-row class="campaign-dialog_block">
              <v-col cols="4"  class="campaign-dialog_block_label">
                <v-label>キャンペーン概要</v-label>
              </v-col>
              <v-col cols="8" class="campaign-dialog_block_control">
                <v-textarea
                  outlined
                  hint="キャンペーンの大まかな概要と、販売する商材の内容を入力してください。"
                  persistent-hint
                />
              </v-col>
            </v-row>
            <!-- デポジット金額 -->
            <v-row class="campaign-dialog_block">
              <v-col cols="4"  class="campaign-dialog_block_label">
                <v-label>デポジット金額</v-label>
              </v-col>
              <v-col cols="8" class="campaign-dialog_block_control">
                <v-text-field
                  hint="※デポジット金額の振込は別途、行なってください"
                  persistent-hint
                  suffix="円"
                />
              </v-col>
            </v-row>
            <!-- 成約上限数  -->
            <v-row class="campaign-dialog_block">
              <v-col cols="4"  class="campaign-dialog_block_label">
                <v-label>成約上限数</v-label>
              </v-col>
              <v-col cols="8" class="campaign-dialog_block_control">
                <v-text-field
                  hint="登録いただいた場合、成約上限数に達したらチャットワークグループへ一度だけ通知が届きます"
                  persistent-hint
                  suffix="件"
                />
              </v-col>
            </v-row>
            <!-- 備考 -->
            <v-row class="campaign-dialog_block">
              <v-col cols="4" class="campaign-dialog_block_label">
                <v-label>備考</v-label>
              </v-col>
              <v-col cols="8" class="campaign-dialog_block_control">
                <v-textarea outlined/>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions class="campaign-dialog_action">
          <v-btn color="indigo" @click="dialog = false">下書き</v-btn>
          <v-btn color="purple" @click="dialog = false">登録</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <affiliate-pr-dialog :dialog="prDlgShow" @content="prContent"/>
  </v-row>
</template>

<script>
  import AffiliatePrDialog from "./AffiliatePrDialog";
  export default {
    components: {AffiliatePrDialog},
    props: {
      dialog: false,
    },
    data: vm => ({
      prDlgShow: false,
      dateFrom: new Date().toISOString().substr(0, 10),
      dateTo: new Date().toISOString().substr(0, 10),
      dateFromFormatted: vm.formatDate(new Date().toISOString().substr(0, 10)),
      dateToFormatted: vm.formatDate(new Date().toISOString().substr(0, 10)),
      menuFrom: false,
      menuTo: false,
      content_show: true,
      company_show: true,
      set_show: true,
      always_show: true,
      prContent: `<h3>Hello</h3><p>world</p>`
    }),

    watch: {
      dateFrom (val) {
        this.dateFromFormatted = this.formatDate(this.dateFrom)
      },
      dateTo (val) {
        this.dateToFormatted = this.formatDate(this.dateTo)
      },
    },

    methods: {
      formatDate (date) {
        if (!date) return null

        const [year, month, day] = date.split('-')
        return `${month}/${day}/${year}`
      },
      parseDate (date) {
        if (!date) return null

        const [month, day, year] = date.split('/')
        return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
      },
    },
  }
</script>
<style scoped lang="scss">
  .campaign-dialog {

    &_title {
      text-align: center;
      display:block !important;
    }

    &_block {
      padding-right: 20px;
      padding-left: 20px;
      border-bottom: 1px solid #777;
    }

    &_block_label {
      display: flex;
      align-items: center;
    }

    &_content {
      padding-left: 0;
      padding-right: 0;
    }

    &_action {
      justify-content: center;
      padding: 10px 0 20px !important;

      .v-btn__content {
        color: white;
      }
    }
  }
</style>