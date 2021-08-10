<template>
  <div class="page_wrap_vue pa-3 asp-page">
    <v-card class="mx-auto">
      <v-container
        class="asp-page_header"
        fuild
      >
        <v-row>
          <v-col cols="12">
            <h2>Opty 登録ASP一覧</h2>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" class="d-flex justify-end">
            <v-select
              outlined hide-details
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
            <AspItem :item="card"/>
          </v-col>
        </v-row>
      </v-container>
    </v-card>

    <CalendarDlg :show="show_calendar"/>
  </div>

</template>

<script>
  import AspItem from "../../components/user/asp/AspItem";
  import CalendarDlg from "../../components/user/calendar/CalendarDlg";

  export default {
    components: {CalendarDlg, AspItem},
    data() {
      return {
        show_calendar: false,
        show_new_campaign_dlg: false,
        show_edit_campaign_dlg: false,
        sort_orders: [
          {value: 'affiliate', label: 'アフィリエイター数順'},
          {value: 'latest', label: '最新順'},
          {value: 'price_high', label: '単価高い順'},
          {value: 'reward', label: '支払総額順'},
          {value: 'low_reject', label: '棄却率低い順'},
          {value: 'project_number', label: '累計案件数順'},
        ],
        cards: [
          {
            id: 1,
            title: '○○ASP',
            image: '/img/sample/buzz-andersen.png',
            date_start: '2020/01/01',
            date_end: '2020/01/07',
            affiliates: 1000,
            registered_projects: 27,
            rewards: 2000000,
            reject_rate: 30,
            average_unit: 2300,
          },
          {
            id: 2,
            title: '○○ASP',
            image: '/img/sample/daniel-monteiro.png',
            date_start: '2020/02/01',
            date_end: '2020/02/07',
            affiliates: 1000,
            registered_projects: 27,
            rewards: 2000000,
            reject_rate: 30,
            average_unit: 2300,
          },
          {
            id: 3,
            title: '○○ASP',
            image: '/img/sample/icons8-team.png',
            date_start: '2020/03/01',
            date_end: '2020/03/07',
            affiliates: 1000,
            registered_projects: 27,
            rewards: 2000000,
            reject_rate: 30,
            average_unit: 2300,
          },
          {
            id: 4,
            title: '○○ASP',
            image: '/img/sample/patrick-hendry.png',
            date_start: '2020/04/01',
            date_end: '2020/04/07',
            affiliates: 1000,
            registered_projects: 27,
            rewards: 2000000,
            reject_rate: 30,
            average_unit: 2300,
          },
          {
            id: 5,
            title: '○○ASP',
            image: '/img/sample/trust-tru-katsande.png',
            date_start: '2020/05/01',
            date_end: '2020/05/07',
            affiliates: 1000,
            registered_projects: 27,
            rewards: 2000000,
            reject_rate: 30,
            average_unit: 2300,
          },
          {
            id: 6,
            title: '○○ASP',
            image: '/img/sample/yolanda-sun.png',
            date_start: '2020/06/01',
            date_end: '2020/06/07',
            affiliates: 1000,
            registered_projects: 27,
            rewards: 2000000,
            reject_rate: 30,
            average_unit: 2300,
          }
        ]
      }
    },
    mounted() {
      const self = this;
      self.$store.commit('setBreadcrumbs', [
        {label: 'Dashboard', name: ''}
      ]);
    },
    methods: {
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