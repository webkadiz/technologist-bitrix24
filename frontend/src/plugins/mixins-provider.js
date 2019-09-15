import Vuex from 'vuex'
import Util from '@/util/util'

export default {
  install(Vue) {
    Vue.mixin({
      computed: {
        ...Vuex.mapGetters(['getDetailById']),
        ...Vuex.mapGetters(['getDetailField'])
      },
      methods: {
        isErrorTree(id) {
          let detail = this.$store.getters.getDetailById(id)

          if (detail.type === 'hardware') return false

          return !Util.checkTree(detail)
        },
        sumId(...mapId) {
          let res = ''
          mapId.forEach(id => {
            id = id ? id : ''
            res += res ? '.' + id : id
          })
          return res
        }
      }
    })
  }
}
