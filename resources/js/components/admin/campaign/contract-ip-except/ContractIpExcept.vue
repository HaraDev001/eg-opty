<template>
  <v-card class="contract-ip-except">
    <v-container fluid>
      <v-card-title>
        <v-row>
          <v-col cols="12">
            <h3>成約除外IP設定</h3>
          </v-col>
        </v-row>
      </v-card-title>
      <v-divider/>
      <v-card-text>
        <v-row>
          <v-col class="d-flex justify-center">
            <v-form v-model="valid">
              <v-text-field
                v-model="ip"
                outlined dense hide-details
                class="_ip mr-2"
                :rules="ipRule"
                placeholder="IPアドレスを入力してください、"
              />
            </v-form>
            <v-btn
              dark color="primary"
              :disabled="!valid"
              @click="addIp"
            >
              登録
            </v-btn>
          </v-col>
        </v-row>
        <v-divider/>
        <v-row class="_ip-container">
          <IpItem v-for="(ip, i) in items" :key="i" :item="ip" @onDelete="showDelete"/>
        </v-row>
      </v-card-text>
    </v-container>

    <delete-dlg :show="show_delete" :item="selected" @onDeleteClose="show_delete = false" @onDeleteIP="deleteIp"/>
  </v-card>
</template>

<script>
  import DeleteDlg from "./DeleteDlg";
  import IpItem from "./IpItem";
  import vuetifyToast from 'vuetify-toast'

  export default {
    components: {IpItem, DeleteDlg},
    props: {
      campaign_id: {type: Number, default: 0}
    },
    data: vm => ({
      show_delete: false,
      valid: false,
      ip: '',
      items: [],
      selected: {id: 0, campaign_id: 0, ip: ''},
      ipRule: [
        v => !!v || '必須フィールド',
        v => /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(v) || '間違ったIPアドレス'
      ],
    }),
    mounted() {
      axios.get(`/admin/campaign/contract-ip-except/list/${this.campaign_id}`)
      .then(res => {
        this.items = res.data.ips
      })
      .catch(e => {
        vuetifyToast.error('サーバーからIPリストを取得できません。')
      })
    },
    methods: {
      addIp() {
        const data = {ip: this.ip, campaign_id: this.campaign_id}
        axios.post(`/admin/campaign/contract-ip-except/new`, data)
          .then(res => {
            this.items = res.data.ips
          })
          .catch(e => {
            vuetifyToast.error('IPを保存できません。')
          })
      },
      showDelete(item) {
        this.selected = item
        this.show_delete = true
      },
      deleteIp(item) {
        axios.get(`/admin/campaign/contract-ip-except/delete/${item.id}`)
          .then(res => {
            this.items = res.data.ips
            this.show_delete = false
          })
          .catch(e => {
            vuetifyToast.error('IPを削除できません。')
          })
      }
    }
  }
</script>

<style scoped>
  ._ip {
    width: 200px;
    flex: none;
  }
</style>