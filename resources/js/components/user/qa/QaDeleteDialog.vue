<template>
  <section>
    <v-dialog
      v-model="show"
      persistent
      max-width="600"
    >
      <v-card>
        <v-card-title class="headline">質問棄却</v-card-title>
        <v-divider/>
        <v-card-text class="py-0">
          <p>質問「{{question}}」を棄却しますか？</p>
        </v-card-text>
        <v-divider/>
        <v-card-actions class="qa-actions">
          <v-btn color="primary" dark @click="$emit('onDeleteClose')">閉じる</v-btn>
          <v-btn color="error" dark @click="$emit('onDeleted', item)">棄却じる</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </section>
</template>

<script>
  export default {
    props: {
      show: false,
      item: {
        type: Object,
        id: {type: Number, default: 0},
        title: {type: String, default: ''},
        category: {type: Object, default: null},
        question: {type: String, default: ''},
        answer: {type: String, default: ''},
      },
    },
    data() {
      return { question: '' }
    },
    watch: {
      item(val) {
        return this.question =  val.question
      } ,
    },
    methods: {
    }
  }
</script>

<style scoped>
  .headline {
    font-size: 1.25rem;
  }
  .qa-category {
    margin-right: 15px;
  }
  .qa-question, .qa-answer {
    padding-top: 0;
    margin-top: 0;
  }
  .add-category {
    position: absolute;
    top: 20px;
    right: 15px;
  }
  .select-wrap {
    padding-right: 60px;
    position: relative;
  }
  .qa-actions {
    padding: 20px 15px;
    display: flex;
    justify-content: center;
  }
</style>