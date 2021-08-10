<template>
  <section>
    <v-dialog
      v-model="dialog"
      persistent
      max-width="600"
    >
      <v-card>
        <v-card-title class="headline">広告主退会</v-card-title>
        <v-divider/>
        <v-card-text class="py-10 text-center">
          <h3>広告主「{{name}}」を退会しますか？</h3>
        </v-card-text>
        <v-divider/>
        <v-card-actions class="qa-actions">
          <v-btn color="primary" dark @click="hide">閉じる</v-btn>
          <v-btn color="error" dark @click="deleted">退会じる</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </section>
</template>

<script>
  export default {
    props: {
      dialog: false,
      item: {
        type: Object,
        default() {
          return {
            id: 0,
            name_first: '',
            name_last: '',
          }
        }
      },
    },
    data() {
      return {
        name: '',
      }
    },
    watch: {
      item(val) {
        if(val === null) return
        this.name = val.name_last + ' ' + val.name_first
      } ,
    },
    methods: {
      hide() {
        this.$emit('onDeleteDlgClose')
      },
      deleted() {
        this.$emit('onDeleted', this.item)
      }
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