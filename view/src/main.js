// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import Resource from 'vue-resource'

require('../node_modules/bootstrap/less/bootstrap.less')

Vue.config.productionTip = false
Vue.use(Resource)
Vue.http.options.root = 'http://comments.qineddiehong.info/api'
Vue.http.headers.common['Authorization'] = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MDA3OTQ0NDcsImlzcyI6IkNvbW1lbnRzIEFwcCIsIm5iZiI6MTUwMDc5NDQ0NywiZGF0YSI6eyJnZXQiOnRydWUsInB1dCI6dHJ1ZSwicG9zdCI6dHJ1ZSwiZGVsZXRlIjp0cnVlfX0.n9JqZQXeR1YbYg6TsXuQg-cfNLqakLJDs4pSxT1-ytg'
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
})
