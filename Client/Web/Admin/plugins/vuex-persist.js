import VuexPersistence from 'vuex-persist'
export default ({ store }) => {
  new VuexPersistence({
    key: 'userInfo',
    storage: window.localStorage,
  }).plugin(store);
}
