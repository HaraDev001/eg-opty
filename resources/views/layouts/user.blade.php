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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- app.css here -->
  <link href="{{ asset('css/user.css') }}" rel="stylesheet">

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
          <v-list-item :to="{name:'user.campaign.index'}">
            <v-list-item-content>
              <img class="logo" src="{{  url('/img/logo.png') }}"/>
            </v-list-item-content>
          </v-list-item>
          <v-list-item :to="{name: 'user.dashboard.index'}" :exact="true">
            <v-list-item-avatar left tile>
              <v-img class="_icon" contain src="/img/svg-icons/home.svg"/>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title>Home</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item :to="{name:'user.asp.index'}" :exact="false">
            <v-list-item-avatar left tile>
              <v-img class="_icon" contain src="/img/svg-icons/asp.svg"/>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title>ASP一覧</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item :to="{name:'user.campaign.index'}" :exact="false">
            <v-list-item-avatar left tile>
              <v-img class="_icon" contain src="/img/svg-icons/campain.svg"/>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title>掲載案件一覧</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item :to="{name:'user.contract.index'}" :exact="false">
            <v-list-item-avatar left tile>
              <v-img class="_icon" contain src="/img/svg-icons/contract.svg"/>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title>成約管理</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item :to="{name:'user.transfer.index'}" :exact="false">
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

            <v-list-item to="" :exact="false">
              <v-list-item-avatar left tile>
                <v-img class="_icon" contain src="/img/svg-icons/data.svg"/>
              </v-list-item-avatar>
              <v-list-item-title>データ推移</v-list-item-title>
            </v-list-item>
            <v-list-item to="" :exact="false">
              <v-list-item-avatar left tile>
                <v-img class="_icon" contain src="/img/svg-icons/lp.svg"/>
              </v-list-item-avatar>
              <v-list-item-title>LP分析</v-list-item-title>
            </v-list-item>
            <v-list-item to="" :exact="false">
              <v-list-item-avatar left tile>
                <v-img class="_icon" contain src="/img/svg-icons/wp.svg"/>
              </v-list-item-avatar>
              <v-list-item-title>WP分析</v-list-item-title>
            </v-list-item>
            <v-list-item to="" :exact="false">
              <v-list-item-avatar left tile>
                <v-img class="_icon" contain src="/img/svg-icons/vcard.svg"/>
              </v-list-item-avatar>
              <v-list-item-title>アフィリエイター分析</v-list-item-title>
            </v-list-item>
          </v-list-group>
          <v-list-item :to="{name:'user.contact.index'}" :exact="false">
            <v-list-item-avatar left tile>
              <v-img class="_icon" contain src="/img/svg-icons/speak.svg"/>
            </v-list-item-avatar>
            <v-list-item-title>お問い合わせ</v-list-item-title>
          </v-list-item>
          <v-list-item :to="{name:'user.qa.index'}" :exact="false">
            <v-list-item-avatar left tile>
              <v-img class="_icon" contain src="/img/svg-icons/question.svg"/>
            </v-list-item-avatar>
            <v-list-item-title>よくある質問</v-list-item-title>
          </v-list-item>
          <v-list-item :to="{name:'user.account.index'}" :exact="false">
            <v-list-item-avatar left tile>
              <v-img class="_icon" contain src="/img/svg-icons/account.svg"/>
            </v-list-item-avatar>
            <v-list-item-title>管理アカウント</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>

      <v-app-bar app clipped-left>
        <v-toolbar-title>
          {{config('app.name')}}
        </v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn icon>
          <v-icon>mdi-bell</v-icon>
        </v-btn>
        <v-btn icon class="mr-4">
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
            <v-list-item @click="clickLogout('{{route('logout')}}','{{url('/login')}}')">
              <v-list-item-icon left tile>
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
