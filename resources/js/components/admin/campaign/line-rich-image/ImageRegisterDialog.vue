<template>
  <v-row justify="center">
    <v-dialog
      class="image-register-dialog"
      v-model="show"
      persistent
      width="400px"
    >
      <v-card>
        <v-card-title class="_title">
          画像登録
        </v-card-title>
        <v-divider/>
        <v-card-text class="_content">
          <v-row>
            <v-col cols="12">
              <v-img :src="preview_url" contain width="300" height="300"/>
            </v-col>
            <v-col cols="12">
              <v-file-input accept="image/jpeg, image/png" v-model="image" @change="imageSelect"/>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions class="_action justify-center">
          <v-btn @click="$emit('onRegisterDlgCancel')">キャンセル</v-btn>
          <v-btn dark color="success" @click="save">登録</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
  import vuetifyToast from "vuetify-toast";

  export default {
    props: {
      show: {type:Boolean, default: false},
      lp_id: {type: Number, default: 0},
    },
    data: vm => ({
      preview_url: '',
      image: null,
      item: null
    }),
    methods: {
      imageSelect() {
        this.preview_url = URL.createObjectURL(this.image)
      },
      save() {
        let formData = new FormData()

        if(this.image){
          formData.append("image", this.image, this.image.name)

          axios.post(`/admin/campaign/line-rich-image/add-image/${this.lp_id}`, formData)
            .then( res => {
              console.log(res.data)
              this.$emit('onRegisterImage', res.data.line_rich_image)
            })
            .catch(error => {
              console.log({error})
              vuetifyToast.error('画像をアップロードできません。')
            })
        }
      }
    }
  }
</script>

<style scoped lang="scss">
</style>