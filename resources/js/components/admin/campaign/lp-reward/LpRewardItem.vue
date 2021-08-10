<template>
  <v-card class="_lp-reward-item">
    <v-card-title>
      <v-row>
        <v-col cols="6">
          <h4>{{item.title}}</h4>
          <small>{{item.url}}</small>
        </v-col>
        <v-col cols="6">
          <small>ステータス</small>
          <h4>{{item.is_public > 0 ? '公開中' : '下書き'}}</h4>
        </v-col>
      </v-row>
    </v-card-title>
    <v-divider/>
    <v-card-text>
      <v-simple-table>
        <thead>
        <tr>
          <th>ランク</th>
          <th>報酬額</th>
          <th>期間</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(r, i) in item.lp_rewards" :key="i">
          <td>{{r.rank_name}}</td>
          <td>{{r.amount}}</td>
          <td>
            {{$date(r.date_start + ' ' + r.time_start).format('YYYY/MM/DD HH:mm')}} -
            {{$date(r.date_end + ' ' + r.time_end).format('YYYY/MM/DD HH:mm')}}
          </td>
          <td>
            <v-btn
              dark color="purple darken--2"
              @click="$emit('onShowEditDlg', r)"
            >
              編集
            </v-btn>
            <v-btn
              dark color="error"
              @click="$emit('onShowDeleteDlg', r)"
            >
              削除
            </v-btn>
          </td>
        </tr>
        </tbody>
      </v-simple-table>
    </v-card-text>
  </v-card>
</template>

<script>
  export default {
    props: {
      item: {
        type: Object,
        default: () => ({
          id: {type: Number, default: 0},
          title: {type: String, default: ''},
          url: {type: String, default: ''},
          is_public: {type: Number, default: 0},
          lp_rewards: {type: Array, default: []},
        })
      }
    },
    data: vm => ({
    }),
  }
</script>

<style scoped lang="scss">
  ._lp-item {
    width: 200px !important;
    &_image {
      width: 100% !important;
      height: 100% !important;
    }
  }
</style>