<template>
  <v-row justify="center">
    <v-dialog
      class="new-lead-dialog"
      v-model="show"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-card-title class="_title">
          {{['先行','延長'][kind]}}アフィリエイター編集
        </v-card-title>
        <v-divider/>
        <v-card-text class="_content">
          <v-radio-group v-model="search_type">
            <v-row>
              <v-col cols="6">
                <v-row>
                  <v-col cols="12">
                    <v-radio dense label="個人ID 検索" value="member"/>
                  </v-col>
                  <v-col cols="12">
                    <v-autocomplete
                      dense outlined hide-details="auto"
                      :disabled="search_type !== 'member'"
                      :items="affiliates"
                      :filter="id_filter"
                      item-text="id_name" item-value="id"
                      v-model="item.affiliate_id"/>
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
                      :disabled="search_type!=='team'"
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
                      :disabled="search_type !== 'keyword'"
                      :items="affiliates"
                      item-value="id" item-text="id_name"
                      :filter="keyword_filter"
                      v-model="item.affiliate_id"/>
                  </v-col>
                </v-row>
              </v-col>
              <v-col cols="12">
                <v-row v-if="kind === 0">
                  <v-col cols="12">開始日時</v-col>
                  <v-col cols="12">
                    <v-text-field
                      type="date" outlined dense hide-details="auto"
                      v-model="item.date_start"
                      class="mr-2 d-inline-flex"/>
                    <v-text-field
                      type="time" outlined dense hide-details="auto"
                      v-model="item.time_start"
                      class="d-inline-flex"/>
                  </v-col>
                </v-row>
                <v-row v-else>
                  <v-col cols="12">終了日時</v-col>
                  <v-col cols="12">
                    <v-text-field
                      type="date" outlined dense hide-details="auto"
                      v-model="item.date_end"
                      class="mr-2 d-inline-flex"/>
                    <v-text-field
                      type="time" outlined dense hide-details="auto"
                      v-model="item.time_end"
                      class="d-inline-flex"/>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
          </v-radio-group>
        </v-card-text>
        <v-card-actions class="_action justify-center">
          <v-btn @click="$emit('onEditClose')">キャンセル</v-btn>
          <v-btn color="success" @click="$emit('onEditSave', item, search_type)">保存</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
  export default {
    props: {
      kind: {type:Number, default: 0},
      show: {type:Boolean, default: false},
      affiliates: {type: Array, default: () => []},
      teams: {type: Array, default: () => []},
      item: {
        type:Object,
        id: {type:Number, default: 0},
        campaign_id: {type:Number, default: 0},
        affiliate_id: {type:Number, default: 0},
        kind: {type:String, default: 'lead'},
        date_start: {type:String, default: ''},
        time_start: {type:String, default: ''},
        date_end: {type:String, default: ''},
        time_end: {type:String, default: ''},
      }
    },
    data: vm => ({
      search_type: 'member',
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