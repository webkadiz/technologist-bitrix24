import axios from 'axios'

export default async function() {
  if (DEVELOPMENT) axios.defaults.baseURL = 'https://localhost:3100'

  if (BX24) BX24.resizeWindow(BX24.getScrollSize().scrollWidth, 800)

  this.$store.commit('initFormat')
  await this.$store.dispatch('getFields')
  await this.$store.dispatch('getProject')
  console.log(this.$store.state.detailList)
}
