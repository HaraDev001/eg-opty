<template>
  <v-dialog v-model="show" max-width="400">
    <v-card class="prize-setting">
      <v-container fluid>
        <v-card-title>
          <v-row>
            <v-col cols="12">
              <h3>ランキング商品を追加</h3>
            </v-col>
          </v-row>
        </v-card-title>
        <v-divider/>
        <v-card-text>
          <v-form v-model="valid">
            <v-row>
              <v-col cols="3">
                <label>順位</label>
              </v-col>
              <v-col cols="9">
                <v-text-field
                  v-model="item.contract_rank"
                  outlined dense hide-details="auto"
                  class="_rank"
                  :rules="[notEmpty, numberRule]"
                />&emsp;位
              </v-col>
              <v-col cols="3"><label>賞品名</label></v-col>
              <v-col cols="9">
                <v-text-field
                  v-model="item.prize_name"
                  outlined dense hide-details="auto"
                  :rules="[notEmpty]"
                />
              </v-col>
              <v-col cols="3"><label>画像</label></v-col>
              <v-col cols="9">
                <v-img
                  class="_preview mr-2"
                  :src="prev_url"
                  contain
                  width="200" height="200"
                />
                <v-file-input class="img-select" v-model="image" @change="imgSelect"/>
              </v-col>
            </v-row>
          </v-form>
          <v-row>
            <v-col class="d-flex justify-space-around">
              <v-btn @click="$emit('onCancel')">キャンセル</v-btn>
              <v-btn color="success" :disabled="!valid" @click="save">追加する</v-btn>
            </v-col>
          </v-row>
        </v-card-text>
      </v-container>

    </v-card>
  </v-dialog>
</template>

<script>
  import vuetifyToast from "vuetify-toast"

  export default {
    props: {
      show: {type: Boolean, default: false}
    },
    data: vm => ({
      item: {
        contract_rank: '',
        prize_name: '',
        image: ''
      },
      prev_url: '',
      image: null,
      valid: false,
      notEmpty: v => !!v || '必須フィールド',
      numberRule: v => !isNaN(parseInt(v)) || '数値でなければなりません'
    }),
    methods: {
      imgSelect() {
        console.log(this.image)
        this.prev_url = URL.createObjectURL(this.image)
      },
      save() {
        if(this.image) {
          this.item.image = this.image
          this.item.contract_rank = parseInt(this.item.contract_rank)
          this.$emit('onNew', this.item)
          return
        }
        vuetifyToast.error('商品画像を選択してください。')
      }
    }
  }
</script>

<style scoped>
  ._rank {
    width: 100px;
    display: inline-flex;
  }
  .img-select {
    width: 300px;
    flex: none;
  }
  ._preview {
    border: 1px solid #aaa;
    border-radius: 7px;
    flex: none;
    margin-right: 20px;
  }
</style>