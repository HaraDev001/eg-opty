import Vue from 'vue';
import Router from 'vue-router';
import store from './common/Store';

Vue.use(Router);

const router = new Router({
  routes: [
      /** ADMIN Routes **/
    {name: 'admin.campaign.index', path: '/admin/campaign', component: require('./admin/campaign/index')},
    {name: 'admin.campaign.edit', path: '/admin/campaign/edit/:id', component: require('./admin/campaign/edit')},
    {name: 'admin.campaign.new', path: '/admin/campaign/new', component: require('./admin/campaign/new')},
    {name: 'admin.campaign.detail', path: '/admin/campaign/detail', component: require('./admin/campaign/detail')},
    {name: 'admin.campaign.setting', path: '/admin/campaign/setting/:id', component: require('./admin/campaign/setting')},
    {name: 'admin.affiliate.index', path: '/admin/affiliate', component: require('./admin/affiliate/index')},
    {
      name: 'admin.affiliate-team.index',
      path: '/admin/affiliate-team',
      component: require('./admin/affiliate-team/index')
    },
    {name: 'admin.advertiser.index', path: '/admin/advertiser', component: require('./admin/advertiser/index')},
    {name: 'admin.manager.index', path: '/admin/manager', component: require('./admin/manager/index')},
    {name: 'admin.transfer.index', path: '/admin/transfer', component: require('./admin/transfer/index')},
    {name: 'admin.fraud-check.index', path: '/admin/fraud-check', component: require('./admin/fraud-check/index')},
    {name: 'admin.contract.index', path: '/admin/contract', component: require('./admin/contract/index')},
    {
      name: 'admin.contract.reservation',
      path: '/admin/contract/reservation',
      component: require('./admin/contract/reservation')
    },
    {
      name: 'admin.manager-account.index',
      path: '/admin/manager-account',
      component: require('./admin/manager-account/index')
    },
    {
      name: 'admin.manager-account.bank-account',
      path: '/admin/manager-account/bank-account',
      component: require('./admin/manager-account/bank_account'),
    },
    {name: 'admin.support.notify', path: '/admin/support/notify', component: require('./admin/support/notify/index')},
    {name: 'admin.support.qa.index', path: '/admin/support/qa', component: require('./admin/support/qa/index')},
    {
      name: 'admin.support.contact',
      path: '/admin/support/contact',
      component: require('./admin/support/contact/index')
    },

    /** USER Routes **/
    {name: 'user.asp.index', path: '/user/asp/index', component: require('./user/asp/index')},
    {
      name: 'user.asp.campaign',
      path: '/user/asp/campaigns/:id',
      component: require('./user/asp/campaigns'),
      props: (route) => ({aspId: route.params.id})
    },

    {name: 'user.dashboard.index', path: '/user/dashboard/index', component: require('./user/dashboard/index')},
    {name: 'user.campaign.index', path: '/user/campaign/index', component: require('./user/campaign/index')},
    {name: 'user.contract.index', path: '/user/contract/index', component: require('./user/contract/index')},
    {name: 'user.contract.show', path: '/user/contract/show', component: require('./user/contract/detail')},
    {name: 'user.transfer.index', path: '/user/transfer/index', component: require('./user/transfer/index')},
    {name: 'user.transfer.show', path: '/user/transfer/show', component: require('./user/transfer/detail')},
    {name: 'user.contact.index', path: '/user/contact/index', component: require('./user/contact/index')},
    {name: 'user.qa.index', path: '/user/qa/index', component: require('./user/qa/index')},
    {name: 'user.account.index', path: '/user/account/index', component: require('./user/account/index')},
    {name: 'user.account.bank', path: '/user/account/bank', component: require('./user/account/bank_account')},
  ],
});

router.beforeEach((to, from, next) => {
  store.commit('showLoader');
  next();
});

router.afterEach((to, from) => {
  setTimeout(() => {
    store.commit('hideLoader');
  }, 1000);
});

export default router;