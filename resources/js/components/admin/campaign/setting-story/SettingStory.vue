<template>
  <v-card>
    <v-card-title>
      <h3>ストーリー</h3>
    </v-card-title>
    <v-card-text v-if="items.length === 0">
      <h3 class="text-center">登録されたストーリーはありません。</h3>
    </v-card-text>
    <v-card-text v-else>
      <StoryItem
        v-for="(item, index) in items"
        :item="item"
        :key="index"
        @StorySaved="storySaved"
      />
    </v-card-text>
    <v-card-actions class="d-flex justify-center">
      <v-btn
        dark color="purple darken-3"
        @click="addItem"
      >
        新規
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
  import StoryItem from "./StoryItem";
  export default {
    name: "SettingStory",
    components: {StoryItem},
    props: {
      campaign_id: 0,
    },
    data() {
      return {
        items: []
      }
    },
    mounted() {
      this.loadStories()
    },
    methods: {
      loadStories() {
        if(this.campaign_id === 0) return
        axios.get(`/admin/campaign/story/list/${this.campaign_id}`)
        .then(res => {
          this.items = res.data.stories.map((s, i) => {s.order= i + 1; return s})
        })
        .catch(e => {
          console.log(e)
        })
      },
      addItem() {
        this.items.push({id: 0, campaign_id: this.campaign_id, order: this.items.length + 1, link: ''})
      },
      storySaved() {
        this.loadStories()
      }
    },
    watch: {
      campaign_id(val) {
        this.loadStories()
      }
    }
  }
</script>

<style scoped>

</style>