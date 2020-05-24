Nova.booting((Vue, router, store) => {
  Vue.component('index-secure-array-files', require('./components/IndexField'));
  Vue.component('detail-secure-array-files', require('./components/DetailField'));
  Vue.component('form-secure-array-files', require('./components/FormField'));
});