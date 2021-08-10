<template>
  <v-row justify="center">
    <v-dialog
      class="new-except-dialog"
      v-model="show"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-card-title class="_title">
          ランキング対象外者
        </v-card-title>
        <v-divider/>
        <v-card-text class="_content">
          <v-radio-group v-model="item.search_type">
            <v-row>
              <v-col cols="6">
                <v-row>
                  <v-col cols="12">
                    <v-radio dense label="個人ID 検索" value="member"/>
                  </v-col>
                  <v-col cols="12">
                    <v-autocomplete
                      dense outlined hide-details="auto"
                      :disabled="item.search_type !== 'member'"
                      :items="affiliates"
                      :filter="id_filter"
                      item-text="id_name" item-value="id"
                      v-model="item.member_id"/>
                  </v-col>
                </v-row>
              </v-col>
              <v-col cols="6">
                <v-row>
                  <v-col cols="12">
                    <v-radio dense label="チームID 検索" value="team"/>
                  </v-col>
                  <v-col cols="12">
                    <v-autocomplete
                      :disabled="item.search_type!=='team'"
                      dense outlined hide-details="auto"
                      :items="teams"
                      item-text="id_name" item-value="id"
                      :filter="id_filter"
                      v-model="item.team_id"/>
                  </v-col>
                </v-row>
              </v-col>
              <v-col cols="12">
                <v-row>
                  <v-col cols="12">
                    <v-radio dense label="キーワード 検索" value="keyword"/>
                  </v-col>
                  <v-col cols="12">
                    <v-autocomplete
                      dense outlined hide-details="auto"
                      :disabled="item.search_type !== 'keyword'"
                      :items="affiliates"
                      item-value="id" item-text="id_name"
                      :filter="keyword_filter"
                      v-model="item.member_id"/>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
          </v-radio-group>
        </v-card-text>
        <v-card-actions class="_action justify-center">
          <v-btn @click="$emit('onNewClose')">キャンセル</v-btn>
          <v-btn dark color="success"
                 @click="$emit('onNewExcept', item)">保存</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
  export default {
    props: {
      show: {type:Boolean, default: false},
      affiliates: {type: Array, default: () => []},
      teams: {type: Array, default: () => []},
    },
    data: vm => ({
      item: {
        id: 0,
        search_type: 'member',
        member_id: '',
        team_id: '',
      },
    }),
    methods: {
      id_filter(item, query, itemText) {
        if(isNaN(parseInt(query))) return
        const idString = item.id + ''
        return idString.indexOf(query) > -1
      },
      keyword_filter(item, query, itemText) {
        query = query.toLowerCase()
        const target = item.name_full.toLowerCase()
        return target.indexOf(query) > -1
      },
    }
  }
</script>

<style scoped lang="scss">
</style>