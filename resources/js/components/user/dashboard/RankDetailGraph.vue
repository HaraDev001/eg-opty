<template>
  <v-card>
    <v-card-title>
      <h4 class="mr-5">ランク別分析</h4>
      <v-btn outlined @click="$emit('onShrink', 1)">縮小</v-btn>
    </v-card-title>
    <v-card-text>
      <v-simple-table>
        <thead>
          <tr>
            <th> </th>
            <th>アクセス数</th>
            <th>登録数/率</th>
            <th>経費</th>
            <th>稼働人数</th>
            <th>成約単価</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(d, i) in data" :key="i">
            <td>{{ranks[d.rank]}}</td>
            <td>{{format(d.access)}}</td>
            <td>{{format(d.register)}}/{{format(d.register_rate, 2)}}%</td>
            <td>{{format(d.expense)}}</td>
            <td>{{format(d.workings)}}</td>
            <td>{{format(d.contract_unit)}}</td>
          </tr>
        </tbody>
      </v-simple-table>
    </v-card-text>
  </v-card>
</template>

<script>
  export default {
    props: {
      data: {type: Array, default: []}
    },
    data: vm => ({
      ranks: ['', 'VIP', 'S VIP', 'SS VIP', 'QUEEN', 'KING']
    }),
    methods: {
      format(val, digs=0) {
        return val.toFixed(digs).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
      }
    }
  }
</script>

<style scoped>

</style>