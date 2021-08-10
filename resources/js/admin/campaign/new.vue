<template>
  <div class="page_wrap_vue pa-3 campaign-edit-page">
    <v-card class="mx-auto">
      <v-card-title class="_header">
        <v-btn
          text
          to="/admin/campaign"
          class="_btn_back"
        >
          <v-icon left>mdi-chevron-left</v-icon>
          もどる
        </v-btn>
        <h2 class="_header_title">
          キャンペーン新規登録
        </h2>
      </v-card-title>

      <v-card-text class="_contents">
        <v-form
          ref="form"
          v-model="valid"
          :lazy-validation="false"
        >
          <v-container fluid>
            <v-row class="_block">
              <v-col cols="2" class="_label">
                <v-label>キャンペーン名</v-label>
              </v-col>
              <v-col cols="10" class="_control">
                <v-text-field
                  v-model="item.title"
                  :rules="textRule" required
                />
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="6">
                <v-row class="_block">
                  <v-col cols="4" class="_label">
                    <v-label>出稿広告主</v-label>
                  </v-col>
                  <v-col cols="8" class="_control">
                    <v-select
                      placeholder="選択してください"
                      :items="advertisers"
                      item-text="name_full" item-value="id"
                      v-model="item.advertiser_id"
                      :rules="textRule" required
                    />
                  </v-col>
                </v-row>
                <v-row class="_block">
                  <v-col cols="4" class="_label">
                    <v-label>アイキャッチ画像</v-label>
                  </v-col>
                  <v-col cols="8" class="_control">
                    <v-row>
                      <v-col>
                        <v-img
                          class="_img_preview"
                          :src="preview_url"
                          aspect-ratio="4" contain
                          max-width="400" max-height="400"
                        />
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col>
                        <v-file-input
                          label="ファイルを選択"
                          hint="横800px, 縦200pxの画像をアップロードしてください。"
                          persistent-hint
                          ref="avatar"
                          @change="imgSelect"
                          v-model="file"
                        />
                      </v-col>
                    </v-row>
                  </v-col>
                </v-row>
              </v-col>
              <v-col cols="6">
                <v-row class="_block">
                  <v-col cols="4" class="_label">
                    <v-label>キャンペーン期間</v-label>
                  </v-col>
                  <v-col cols="8" class="_control">
                    <v-row>
                      <v-col class="py-0">
                        <v-text-field
                          v-mask="maskDate"
                          class="_date_start"
                          placeholder="YYYY/MM/DD"
                          v-model="item.date_start"
                          :rules="textRule" required
                        />
                        &nbsp;
                        <v-text-field
                          v-mask="maskTime"
                          class="_time_start"
                          placeholder="00:00"
                          v-model="item.time_start"
                          :rules="textRule" required
                        />
                        &nbsp;
                        <span>から</span>
                      </v-col>
                    </v-row>
                    <v-row>
                      <v-col class="py-0">
                        <v-text-field
                          v-mask="maskDate"
                          class="_date_end"
                          placeholder="YYYY/MM/DD"
                          v-model="item.date_end"
                          :rules="textRule" required
                        />
                        &nbsp;
                        <v-text-field
                          v-mask="maskTime"
                          class="_time_end"
                          placeholder="00:00"
                          v-model="item.time_end"
                          :rules="textRule" required
                        />
                        &nbsp;
                        <span>まで</span>
                        <p><small>期間が確定していない場合は未入力にしてください。</small></p>
                      </v-col>
                    </v-row>
                  </v-col>
                </v-row>
                <v-row class="_block">
                  <v-col cols="4" class="_label">
                    <v-label>Youtube予告URL</v-label>
                  </v-col>
                  <v-col cols="8" class="_control">
                    <v-text-field
                      v-model="item.youtube_url"
                      :rules="textRule" required
                    />
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
            <v-row class="_block">
              <v-col cols="2" class="_label">
                <v-label>アフィリエイター向け PR文</v-label>
              </v-col>
              <v-col class="_control">
                <quill-editor
                  class="quill-editor"
                  ref="editor"
                  v-model="item.affiliate_pr"
                  :options="editorOption"
                  @focus="toggleFocus($event)"
                  @blur="toggleFocus($event, false)"
                  :rules="textRule" required
                />
<!--                <input-->
<!--                  type="file"-->
<!--                  id="getFile"-->
<!--                  @change="uploadFunction($event)"-->
<!--                  hidden-->
<!--                />-->
              </v-col>
              <v-col cols="4" class="_control">
                <v-label>記載注意事項</v-label>
                <v-textarea
                  outlined dense
                  rows="12"
                  :rules="textRule" required
                  v-model="item.notes"
                />
              </v-col>
            </v-row>
            <v-row class="_block">
              <v-col cols="2" class="_label">
                <v-label>リダイレクトURL</v-label>
              </v-col>
              <v-col cols="4" class="_control">
                <v-text-field
                  v-model="item.mail_redirect_url"
                  :rules="textRule" required
                />
              </v-col>
              <v-col cols="2" class="_label">
                <v-label>オプトイン方式</v-label>
              </v-col>
              <v-col cols="4" class="_control">
                <v-select
                  :items="[{id:1, label:'メール'}, {id:2, label:'Line'}]"
                  item-value="id" item-text="label"
                  :rules="textRule" required
                  v-model="item.opt_in_method"
                />
              </v-col>
            </v-row>
            <v-row class="_block">
              <v-col cols="6" style="align-self: start">
                <v-row>
                  <v-col cols="4" class="_label">
                    <v-label>常時掲載案件化</v-label>
                  </v-col>
                  <v-col cols="8" class="_control">
                    <v-btn-toggle
                      v-model="item.always_posting"
                      mandatory
                      :rules="textRule" required
                      color="primary"
                    >
                      <v-btn value="1">する</v-btn>
                      <v-btn value="0">しない</v-btn>
                    </v-btn-toggle>
                  </v-col>
                </v-row>
              </v-col>
              <v-col cols="6">
                <v-row>
                  <v-col cols="4" class="_label">
                    <v-label>会社名表示設定</v-label>
                  </v-col>
                  <v-col cols="8" class="_control">
                    <v-btn-toggle
                      v-model="item.company_show"
                      mandatory
                      color="primary"
                      hint="&quote;はい&quote;を選択した場合、毎月月初のアフィリエイターランク自動昇格時の対象キャンペーンに入らなくなります。ご注意ください。`"
                      persistent-hint
                    >
                      <v-btn value="1">はい</v-btn>
                      <v-btn value="0">いいえ</v-btn>
                    </v-btn-toggle>
                    <p class="_red">
                      <small>
                        "はい"を選択した場合、毎月月初のアフィリエイターランク自動昇格時の対象キャンペーンに入らなくなります。ご注意ください。
                      </small>
                    </p>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
            <v-divider/>
            <h2 class="py-4 text-center">キャンペーン申請に関して</h2>
            <v-divider/>
            <v-row class="_block">
              <v-col cols="2" class="_label">
                <v-label>キャンペーン概要</v-label>
              </v-col>
              <v-col class="_control">
                <v-textarea
                  outlined
                  hint="キャンペーンの大まかな概要と、販売する商材の内容を入力してください。"
                  persistent-hint
                  :rules="textRule" required
                  v-model="item.campaign_summary"
                />
              </v-col>
            </v-row>
            <v-row class="_block">
              <v-col cols="2" class="_label">
                <v-label>備考</v-label>
              </v-col>
              <v-col class="_control">
                <v-textarea
                  outlined
                  :rules="textRule" required
                  v-model="item.remarks"
                />
              </v-col>
            </v-row>
          </v-container>
        </v-form>
      </v-card-text>

      <v-card-actions class="_action">
        <v-btn color="indigo" @click="save(0)" :disabled="!valid">下書き</v-btn>
        <v-btn color="purple" @click="save(1)" :disabled="!valid">登録</v-btn>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script>
  import { mask } from 'vue-the-mask'
  import 'quill/dist/quill.core.css'
  import 'quill/dist/quill.snow.css'
  import 'quill/dist/quill.bubble.css'
  import vuetifyToast from 'vuetify-toast'

  import { quillEditor } from 'vue-quill-editor'
  export default {
    components: {quillEditor},
    directives: {
      mask,
    },
    data(){
      const toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'], // toggled buttons
        ['blockquote', 'code-block'],
        [{ header: 1 }, { header: 2 }], // custom button values
        [{ list: 'ordered' }, { list: 'bullet' }],
        [{ script: 'sub' }, { script: 'super' }], // superscript/subscript
        // [{ indent: '-1' }, { indent: '+1' }], // outdent/indent
        // [{ direction: 'rtl' }], // text direction
        [{ size: ['small', false, 'large', 'huge'] }], // custom dropdown
        [{ header: [1, 2, 3, 4, 5, 6, false] }],
        [{ color: [] }, { background: [] }], // dropdown with defaults from theme
        [{ font: [] }],
        [{ align: [] }],
        // ['image'],
        // ['clean'] // remove formatting button
      ]
      return {
        editorOption: {
          modules: {
            toolbar: {
              container: toolbarOptions,
              handlers: {
                // image: function () {
                //   document.getElementById('getFile').click()
                // }
              }
            }
          }
        },
        textRule: [
          v => !!v || '必須フィールド',
        ],
        emailRule: [
          v => !!v || 'メールが必要です',
          v => /.+@.+\..+/.test(v) || 'メールアドレスは有効である必要があります',
        ],
        dateRule: [
          v => !!v || '日付を選択します。',
          v => this.$date(v, 'YYYY/MM/DD').isValid() || '日付が間違っています。'
        ],
        timeRule: [
          v => !!v || '時間を選択します。',
          v => parseInt(v.split(':')[0])<24 && parseInt(v.split(':')[1])<60 || '時間は不正確です。'
        ],
        valid: false,
        content: '',
        maskDate: '####/##/##',
        maskTime: '##:##',
        always: 'no',
        company: 'no',
        advertisers: [],
        // img: null,
        preview_url: '',
        file: null,
        item: {
          advertiser_id: 0, // 出稿広告主
          title: '', // キャンペーン名
          image: '', // アイキャッチ画像
          date_start: '',
          time_start: '',
          date_end: '',     // キャンペーン期間
          time_end: '',
          youtube_url: '',  // Youtube予告URL
          affiliate_pr: '',    // アフィリエイター向け PR文
          notes: '',        // 注意事項
          mail_redirect_url: '',    // 成約除外メアドリダイレクトURL
          detail_pdf: '',   // 詳細PDF
          opt_in_method: 0, // オプトイン方式
          content_type: 0, // コンテンツタイプ
          company_show: 0, // 会社名表示
          always_posting: 0,       // 常時掲載案件化
          show_setting: 0,  // 表示設定
          campaign_summary: '',     // キャンペーン概要
          deposit_amount: 0,     // デポジット金額
          contracts_limit: 0,     // 成約上限数
          remarks: '',      // 備考
        }
      }
    },
    mounted() {
      axios.get('admin/campaign/advertisers')
      .then(res => {
        this.advertisers = res.data.advertisers
      })
      .catch(e => {
        vuetifyToast.error('サーバーから広告主リストを取得できません。 後で試してください。')
      })
    },
    methods: {
      save(flag) {
        // check date validity
        const dts = this.$date(this.item.date_start + ' ' + this.item.time_start)
        const dte = this.$date(this.item.date_end + ' ' + this.item.time_end)

        if(dte.isBefore(dts)) {
          vuetifyToast.error('終了日が開始日より前です。 日付を修正してください。')
          return
        }

        // flag: 0 => draft, 1: save
        if(this.file) {
          let formData = new FormData()

          formData.append('advertiser_id', this.item.advertiser_id)
          formData.append('title', this.item.title)
          formData.append('image', this.file, this.file.name)
          formData.append('date_start', dts.format('YYYY-MM-DD'))
          formData.append('time_start', dts.format('HH:mm:ss'))
          formData.append('date_end', dte.format('YYYY-MM-DD'))
          formData.append('time_end', dte.format('HH:mm:ss'))
          formData.append('youtube_url', this.item.youtube_url)
          formData.append('affiliate_pr', this.item.affiliate_pr)
          formData.append('notes', this.item.notes)
          formData.append('mail_redirect_url', this.item.mail_redirect_url)
          // formData.append('detail_pdf', this.item.detail_pdf)
          formData.append('opt_in_method', this.item.opt_in_method)
          // formData.append('content_type', this.item.content_type)
          formData.append('company_show', this.item.company_show)
          formData.append('always_posting', this.item.always_posting)
          // formData.append('show_setting', this.item.show_setting)
          formData.append('campaign_summary', this.item.campaign_summary)
          formData.append('deposit_amount', this.item.deposit_amount)
          formData.append('contracts_limit', this.item.contracts_limit)
          formData.append('remarks', this.item.remarks)
          console.log(formData)
          axios.post(`/admin/campaign/new/${flag}`, formData, {
            headers: {'Content-Type': 'multipart/form-data'}
          })
            .then( res => {
              vuetifyToast.success('キャンペーンが作成されました。');
            })
            .catch(e => {
              console.log(e.response)
              if(e.response.data.hasOwnProperty('errors')) {
                const errors = e.response.data.errors
                if(errors.hasOwnProperty('advertiser_id')) vuetifyToast.error('広告主を選択してください。');// 出稿広告主
                if(errors.hasOwnProperty('title')) vuetifyToast.error('キャンペーンのタイトルを入力してください。');// キャンペーン名
                if(errors.hasOwnProperty('image')) vuetifyToast.error('バナー画像を選択してください。');// アイキャッチ画像
                if(errors.hasOwnProperty('date_start')) vuetifyToast.error('キャンペーン期間を選択してください。');// キャンペーン期間
                if(errors.hasOwnProperty('time_start')) vuetifyToast.error('キャンペーン期間を選択してください。');
                if(errors.hasOwnProperty('date_end')) vuetifyToast.error('キャンペーン期間を選択してください。');
                if(errors.hasOwnProperty('time_end')) vuetifyToast.error('キャンペーン期間を選択してください。');
                if(errors.hasOwnProperty('youtube_url')) vuetifyToast.error('Youtube予告URLを入力してください。');// Youtube予告URL
                if(errors.hasOwnProperty('affiliate_pr')) vuetifyToast.error('を入力してください。');// アフィリエイター向け PR文
                if(errors.hasOwnProperty('notes')) vuetifyToast.error('アフィリエイター向け PR文を入力してください。');// 注意事項
                if(errors.hasOwnProperty('mail_redirect_url')) vuetifyToast.error('成約除外メアドリダイレクトURLを入力してください。');// 成約除外メアドリダイレクトURL
                if(errors.hasOwnProperty('detail_pdf')) vuetifyToast.error('詳細PDFを入力してください。');// 詳細PDF
                if(errors.hasOwnProperty('opt_in_method')) vuetifyToast.error('オプトイン方式を選択してください。');// オプトイン方式
                if(errors.hasOwnProperty('content_type')) vuetifyToast.error('コンテンツタイプを選択してください。');// コンテンツタイプ
                if(errors.hasOwnProperty('company_show')) vuetifyToast.error('会社名表示を選択してください。');// 会社名表示
                if(errors.hasOwnProperty('always_posting')) vuetifyToast.error('常時掲載案件化を選択してください。');// 常時掲載案件化
                if(errors.hasOwnProperty('show_setting')) vuetifyToast.error('表示設定を選択してください。');// 表示設定
                if(errors.hasOwnProperty('campaign_summary')) vuetifyToast.error('キャンペーン概要を入力してください。');// キャンペーン概要
                if(errors.hasOwnProperty('deposit_amount')) vuetifyToast.error('デポジット金額を入力してください。');// デポジット金額
                if(errors.hasOwnProperty('contracts_limit')) vuetifyToast.error('成約上限数を入力してください。');// 成約上限数
                if(errors.hasOwnProperty('remarks')) vuetifyToast.error('備考を入力してください。');// 備考
              } else {
                vuetifyToast.error('サーバーエラー。 後で試してください。')
              }
            })
        } else {
          vuetifyToast.error('バナー画像を選択してください。');// アイキャッチ画像
        }
      },
      imgSelect() {
        this.preview_url = URL.createObjectURL(this.file)
      },
      toggleFocus(event, id, focused = true) {
        this.cursorLocation = event.getSelection() ? event.getSelection().index : 0
      },
      uploadFunction(e) {
        this.selectedFile = e.target.files[0]
        const form = new FormData()
        form.append('file', this.selectedFile)
        axios.post('/api/faq_img_upload', form, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          })
          .then(res => {
            console.log(this.myQuillEditor)
            this.myQuillEditor.insertEmbed(this.cursorLocation, 'image', `${res.data.url}`)
          })
      },
    }
  }
</script>