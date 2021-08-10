<template>
  <div>
    <v-card class="_line-rich-image-item">
      <v-card-title>
        <v-row>
          <v-col cols="6">
            <h3 class="_title">{{item.title}}</h3>
            <small class="_url">{{item.url}}</small>
          </v-col>
          <v-col cols="6" class="d-flex justify-end">
            <v-btn
              dark color="primary"
              @click="show_register=true"
            >
              登録
            </v-btn>
          </v-col>
        </v-row>
      </v-card-title>
      <v-card-text class="_content">
        <v-row>
          <v-col cols="12" v-if="hasImages">
            <LineRichImageItem v-for="(image, i) in item.line_rich_images" :key="i" :item="image" @onDeleteImage="deleteImage"/>
          </v-col>
          <v-col v-else>
            <h3 class="text-center">登録されているラインリッチ画像はありません。</h3>
          </v-col>
        </v-row>
      </v-card-text>
      <scale-loader color="orange darken--1" loading="loading" height="70" width="7"/>
    </v-card>

    <ImageRegisterDialog :show="show_register" :lp_id="item.id" @onRegisterImage="onRegisterImage" @onRegisterDlgCancel="show_register=false"/>
  </div>
</template>

<script>
  import vuetifyToast from 'vuetify-toast'
  import LineRichImageItem from "./LineRichImageItem"
  import ImageRegisterDialog from "./ImageRegisterDialog"

  export default {
    components: {LineRichImageItem, ImageRegisterDialog},
    props: {
      item: {
        type: Object,
        id: { type: Number, default: 0},
        title: {type: String, default: ''},
        url: {type: String, default: ''},
        line_rich_images: {type: Array, default: []}
      }
    },
    data: () => ({
      show_register: false,
      loading: false,
      new_image: null,
    }),
    computed: {
      hasImages() { return this.item !== undefined && this.item.hasOwnProperty('line_rich_images') && this.item.line_rich_images.length > 0}
    },
    methods: {
      onRegisterImage(val) {
        this.item.line_rich_images.push(val)
        this.show_register = false
      },
      deleteImage(img) {
        axios.get(`/admin/campaign/line-rich-image/delete/${img.id}`)
        .then(res => {
          this.item.line_rich_images = res.data.images
        })
        .catch(e => {
          vuetifyToast.error('画像を削除できません。')
        })
      },
    }
  }
</script>

<style scoped lang="scss">
  ._line-rich-image-item {
    /*height: 300px !important;*/
    ._title {
      font-size: 1.2rem !important;
    }
    ._url {
      font-size: 0.8rem !important;
    }
    ._content {
      /*width: 100% !important;*/
      overflow-x: scroll;
      display: flex;
    }
  }
</style>