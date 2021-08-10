<template>
  <v-list-item class="story-item">
    <v-list-item-content class="py-0">
      <v-row>
        <v-col cols="2" class="d-flex align-center justify-end">
          <v-label class=" story-item-label">
            第{{item.order}}話
          </v-label>
        </v-col>
        <v-col>
          <v-form ref="form" v-model="valid">
            <v-text-field
              type="url"
              dense outlined hide-details="auto"
              v-model="item.link"
              :rules="urlRule"
              class="story-item_link"
            />
          </v-form>
        </v-col>
        <v-col cols="1">
          <v-btn
            :disabled="!valid"
            dark color="primary"
            class="story-item_btn"
            @click="save"
          >
            登録
          </v-btn>
        </v-col>
      </v-row>
    </v-list-item-content>
  </v-list-item>
</template>

<script>
  import vuetifyToast from "vuetify-toast"

  export default {
    name: "StoryItem",
    props: {
      item: {type: Object, default: () => ({id: 0, campaign_id: 0, order: 0, link: ''}) }
    },
    data() {
      return {
        valid: false,
        urlRule: [
          v => !!v || 'URLは空にできません。',
          v => /^(ftp|http|https):\/\/[^ "]+$/.test(v) || '無効なURL'
        ]
      }
    },
    methods: {
      save() {
        axios.post('/admin/campaign/story/save', this.item)
        .then(res => {
          this.$emit('StorySaved')
        })
        .catch(e => {
          vuetifyToast.error('ストーリーを保存できませんでした。 後で試してください。')
        })
      }
    }
  }
</script>

<style scoped>

</style>