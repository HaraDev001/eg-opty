<template>
  <div class="page_wrap_vue pa-3 campaign-page">
    <v-card class="mx-auto">
      <v-container
        class="asp-page_header"
        fuild
      >
        <v-row>
          <v-col cols="12" class="text-center">
            <h2>全体ASPキャンペーン一覧</h2>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" class="d-flex justify-end">
            <v-select
              outlined hide-details dense
              class="_toolbar_sort d-inline-flex"
              :items="sort_orders"
              item-text="label" item-value="value"
              label="表示順"
            />
          </v-col>
        </v-row>
        <v-icon
          class="_calendar" large
          @click="show_calendar=true"
        >
          mdi-calendar-month
        </v-icon>

      </v-container>

      <v-container class="asp-page_container" fluid>
        <v-row dense>
          <v-col
            v-for="card in cards"
            :key="card.id"
            cols="4"
          >
            <CampaignItem :item="card"/>
          </v-col>
        </v-row>
      </v-container>
    </v-card>

    <CalendarDlg :show="show_calendar"/>
  </div>
</template>

<script>
  import CampaignItem from "../../components/user/campaign/CampaignItem";
  import CalendarDlg from "../../components/user/calendar/CalendarDlg";

  export default {
    components: {CampaignItem, CalendarDlg},
    props: {
      // aspId: {type: String, default: ''}
    },
    data() {
      return {
        show_calendar: false,
        sort_orders: [
          {value: 'latest', label: '最新順'},
          {value: 'price_high', label: '単価高い順'},
          {value: 'reward', label: '報酬予定額順'},
          {value: 'list', label: 'リスト取得数順'},
          {value: 'register_rate', label: '登録率順'},
        ],
        cards: [
          {
            id: 1,
            title: 'campaign1',
            image: '/img/sample/buzz-andersen.png',
            date_start: '2020/01/01',
            date_end: '2020/01/07',
            asp_id: 1,
            asp_title: 'asp1',
            reward_estimate: 10000,
            register_number: 3000,
            reward_unit_min: 2000,
            reward_unit_max: 3000,
            average_lp_register_rate: 13,
            lp_number: 3,
          },
          {
            id: 2,
            title: 'campaign2',
            image: '/img/sample/daniel-monteiro.png',
            date_start: '2020/02/01',
            date_end: '2020/02/07',
            asp_id: 1,
            asp_title: 'asp1',
            reward_estimate: 10000,
            register_number: 3000,
            reward_unit_min: 2000,
            reward_unit_max: 3000,
            average_lp_register_rate: 13,
            lp_number: 3,
          },
          {
            id: 3,
            title: 'campaign3',
            image: '/img/sample/icons8-team.png',
            date_start: '2020/03/01',
            date_end: '2020/03/07',
            asp_id: 2,
            asp_title: 'asp2',
            reward_estimate: 10000,
            register_number: 3000,
            reward_unit_min: 2000,
            reward_unit_max: 3000,
            average_lp_register_rate: 13,
            lp_number: 3,
          },
          {
            id: 4,
            title: 'campaign4',
            image: '/img/sample/patrick-hendry.png',
            date_start: '2020/04/01',
            date_end: '2020/04/07',
            asp_id: 3,
            asp_title: 'asp3',
            reward_estimate: 10000,
            register_number: 3000,
            reward_unit_min: 2000,
            reward_unit_max: 3000,
            average_lp_register_rate: 13,
            lp_number: 3,
          },
          {
            id: 5,
            title: 'campaign5',
            image: '/img/sample/trust-tru-katsande.png',
            date_start: '2020/05/01',
            date_end: '2020/05/07',
            asp_id: 4,
            asp_title: 'asp4',
            reward_estimate: 10000,
            register_number: 3000,
            reward_unit_min: 2000,
            reward_unit_max: 3000,
            average_lp_register_rate: 13,
            lp_number: 3,
          },
        ]
      }
    },
    mounted() {
    }
  }
</script>

<style scoped lang="scss">
  ._toolbar_sort {
    flex:none;
  }
  ._calendar {
    position: absolute;
    top: 15px;
    right: 15px;
  }
</style>