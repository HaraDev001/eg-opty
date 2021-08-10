<template>
  <v-card>
    <v-card-title>
      <h4 class="mr-5">WP別分析</h4>
      <v-btn outlined @click="$emit('onShrink', 2)">縮小</v-btn>
    </v-card-title>
    <v-card-text class="">
      <v-slide-group center-active>
        <v-slide-item v-for="(item, i) in items" :key="i">
          <WpItem :data="item"/>
        </v-slide-item>
      </v-slide-group>
    </v-card-text>
  </v-card>
</template>

<script>
  import WpItem from "./WpItem";
  export default {
    components: {WpItem},
    props: {
      items: {type: Array, default: []}
    }
  }
</script>

<style scoped>
.v-slide-group__wrapper {
  width: 100%;
  overflow-x: scroll !important;
}
</style>