import axios from 'axios'

export default async function() {
  if (DEVELOPMENT) axios.defaults.baseURL = 'http://127.0.0.2'

  if (BX24) BX24.resizeWindow(BX24.getScrollSize().scrollWidth, 800)
  
  this.$router.replace('/')

  this.$store.commit('initFormat')
  await this.$store.dispatch('getFields')
  await this.$store.dispatch('getProject')
}
