<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Styles -->
  <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">

  <!-- app.css here -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

  <!-- app js values -->
  <script type="application/javascript">
    var LSK_APP = {};
    LSK_APP.APP_URL = '{{env('APP_URL')}}';
  </script>
</head>
<body>
<div id="app">
  <template>
    <v-app id="inspire">
      <v-navigation-drawer
        v-model="drawer"
        app
        clipped
        left
      >
        <v-list dense>
          <v-list-item :to="{name: 'admin.campaign.index'}">
            <v-list-item-content >
              <img class="logo" src="{{  url('/img/logo.png') }}"/>
            </v-list-item-content>
          </v-list-item>
          <v-list-item :to="{name: 'admin.campaign.index'}" :exact="true">
            <v-list-item-avatar left tile>
              <v-img class="_icon" contain src="/img/svg-icons/home.svg"/>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title>Home</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item :to="{name:'admin.campaign.index'}" :exact="false">
            <v-list-item-avatar left tile>
              <v-img class="_icon" contain src="/img/svg-icons/campain.svg"/>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title>キャンペーン一覧</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item :to="{name:'admin.affiliate.index'}" :exact="false">
            <v-list-item-avatar left tile>
              <v-img class="_icon" contain src="/img/svg-icons/profile.svg"/>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title>アフィリエイター</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item :to="{name:'admin.advertiser.index'}" :exact="false">
            <v-list-item-avatar left tile>
              <v-img class="_icon" contain src="/img/svg-icons/profile.svg"/>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title>広告主管理</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item :to="{name:'admin.manager.index'}" :exact="false">
            <v-list-item-avatar left tile>
              <v-img class="_icon" contain src="/img/svg-icons/profile.svg"/>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title>管理者管理</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item :to="{name:'admin.fraud-check.index'}" :exact="false">
            <v-list-item-avatar left tile>
              <v-img class="_icon" contain src="/img/svg-icons/eye.svg"/>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title>不正チェック</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item :to="{name:'admin.contract.index'}" :exact="false">
            <v-list-item-avatar left tile>
              <v-img class="_icon" contain src="/img/svg-icons/contract.svg"/>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title>成約管理</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item :to="{name:'admin.transfer.index'}" :exact="false">
            <v-list-item-avatar left tile>
              <v-img class="_icon" contain src="/img/svg-icons/coins.svg"/>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title>振込管理</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-group value="true">
            <template v-slot:activator>
              <v-list-item-avatar left tile>
                <v-img class="_icon" contain src="/img/svg-icons/graph.svg"/>
              </v-list-item-avatar>
              <v-list-item-content>
                <v-list-item-title>案件分析</v-list-item-title>
              </v-list-item-content>
            </template>

            <v-list-item :to="{name:'admin.analysis.data'}" :exact="false">
              <v-list-item-avatar left tile>
                <v-img class="_icon" contain src="/img/svg-icons/data.svg"/>
              </v-list-item-avatar>
              <v-list-item-title>データ推移</v-list-item-title>
            </v-list-item>
            <v-list-item :to="{name:'admin.analysis.lp'}" :exact="false">
              <v-list-item-avatar left tile>
                <v-img class="_icon" contain src="/img/svg-icons/lp.svg"/>
              </v-list-item-avatar>
              <v-list-item-title>LP分析</v-list-item-title>
            </v-list-item>
            <v-list-item :to="{name:'admin.analysis.wp'}" :exact="false">
              <v-list-item-avatar left tile>
                <v-img class="_icon" contain src="/img/svg-icons/wp.svg"/>
              </v-list-item-avatar>
              <v-list-item-title>WP分析</v-list-item-title>
            </v-list-item>
            <v-list-item :to="{name:'admin.analysis.affiliate'}" :exact="false">
              <v-list-item-avatar left tile>
                <v-img class="_icon" contain src="/img/svg-icons/vcard.svg"/>
              </v-list-item-avatar>
              <v-list-item-title>アフィリエイター分析</v-list-item-title>
            </v-list-item>
          </v-list-group>
          <v-list-group value="true">
            <template v-slot:activator>
              <v-list-item-avatar left tile>
                <v-img class="_icon" contain src="/img/svg-icons/book.svg"/>
              </v-list-item-avatar>
              <v-list-item-content>
                <v-list-item-title>サポート・連絡</v-list-item-title>
              </v-list-item-content>
            </template>

            <v-list-item :to="{name:'admin.support.notify'}" :exact="false">
              <v-list-item-avatar left tile>
                <v-img class="_icon" contain src="/img/svg-icons/alarm.svg"/>
              </v-list-item-avatar>
              <v-list-item-title>お知らせ</v-list-item-title>
            </v-list-item>
            <v-list-item :to="{name:'admin.support.history'}" :exact="false">
              <v-list-item-avatar left tile>
                <v-img class="_icon" contain src="/img/svg-icons/pointer.svg"/>
              </v-list-item-avatar>
              <v-list-item-title>操作履歴</v-list-item-title>
            </v-list-item>
            <v-list-item :to="{name:'admin.support.qa.index'}" :exact="false">
              <v-list-item-avatar left tile>
                <v-img class="_icon" contain src="/img/svg-icons/question.svg"/>
              </v-list-item-avatar>
              <v-list-item-title>よくある質問</v-list-item-title>
            </v-list-item>
            <v-list-item :to="{name:'admin.manager-account.index'}" :exact="false">
              <v-list-item-avatar left tile>
                <v-img class="_icon" contain src="/img/svg-icons/account.svg"/>
              </v-list-item-avatar>
              <v-list-item-title>管理アカウント</v-list-item-title>
            </v-list-item>
            <v-list-item :to="{name:'admin.support.contact'}" :exact="false">
              <v-list-item-avatar left tile>
                <v-img class="_icon" contain src="/img/svg-icons/speak.svg"/>
              </v-list-item-avatar>
              <v-list-item-title>お問い合わせ</v-list-item-title>
            </v-list-item>
          </v-list-group>
        </v-list>
      </v-navigation-drawer>

      <v-app-bar app clipped-left>
        {{--                <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>--}}
        <v-toolbar-title>
          {{config('app.name')}}
        </v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn icon>
          <v-icon>mdi-plus</v-icon>
        </v-btn>

        <v-avatar left>
          @php($user=Auth::user())
          @if ($user->avatar !== '')
            <v-img src="{{$user->avatar}}"></v-img>
          @endif
        </v-avatar>

        <v-btn text>{{$user->name_last}} {{$user->name_first}}</v-btn>

        <v-menu
          bottom
          right
          offset-y
          origin="top right"
          transition="scale-transition"
        >
          <template v-slot:activator="{ on }">
            <v-btn v-on="on" icon>
              <v-icon>mdi-account-cog</v-icon>
            </v-btn>
          </template>
          <v-list :tile="false" nav dense>
            <v-list-item @click="clickLogout('{{url('/logout')}}','{{url('/login')}}')">
              <v-list-item-icon>
                <v-icon>mdi-power</v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>ログアウト</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-menu>

      </v-app-bar>

      <v-content>
        <v-divider></v-divider>
        <transition name="fade">
          <router-view></router-view>
        </transition>
      </v-content>

      <v-footer fixed>
        <span>&copy; {{ date('Y') }}</span>
      </v-footer>
    </v-app>
  </template>

</div>
<style scoped>
  ._icon {
    max-width: 25px;
    max-height: 25px;
  }
</style>

<!-- Scripts -->
<script src="{{ asset('js/manifest.js') }}"></script>
<script src="{{ asset('js/vendor.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
