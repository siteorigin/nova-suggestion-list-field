Nova.booting((Vue, router, store) => {
  Vue.component('index-nova-suggestion-list', require('./components/IndexField'))
  Vue.component('detail-nova-suggestion-list', require('./components/DetailField'))
  Vue.component('form-nova-suggestion-list', require('./components/FormField'))
})
