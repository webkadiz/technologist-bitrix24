import 'materialize-css/dist/css/materialize'
import 'materialize-css/dist/js/materialize'

import 'regenerator-runtime'

import Vue from 'vue/dist/vue.js'
import Vuex from 'vuex'
import $ from 'jquery'
import Velocity from 'velocity-animate'
import format from './format'
import 'lodash'
import Util from './util'
import ServerError from './ServerError'

window.Vue = Vue
window.Vuex = Vuex
window.$ = $
window.Velocity = Velocity
window.format = format
window.bus = new Vue()
window.Util = Util

window.l = (...params) => params.forEach(param => console.log(param))
window.round = (num, amount) => Math.round(num * 10 ** amount) / 10 ** amount
window.float = num => parseFloat(num) || 0

window.sumId = {
  methods: {
    sumId(...mapId) {
      let res = ''
      mapId.forEach(id => {
        id = id ? id : ''
        res += res ? '.' + id : id
      })
      return res
    }
  }
}

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
    }
  }
})

Object.defineProperty(String.prototype, 'title', {
  value() {
    if (this[0]) return this[0].toUpperCase() + this.slice(1)
    else return this
  }
})

Object.defineProperty(Error.prototype, 'render', {
  value() {
    console.dir(Vue)

    document.body.append('<h1>error</h1>')
  }
})

window.toastSuccess = (message, data) => {
  M.toast({
    html: `${message.title()}<div class="material-icons">check_circle</div>`,
    classes: 'toast-success',
    displayLength: 4000,
    activationPercent: 0.3
  })

  console.log(data)
}

window.toastError = (message, cause) => {
  M.toast({
    html: `${message.title()}<div class="material-icons">error</div>`,
    classes: 'toast-error',
    displayLength: 4000,
    activationPercent: 0.3
  })

  //console.log(cause);
}

window.fetchADV = (source, meta = {}, callback = () => {}) => {
  fetch(source, meta)
    .then(response => {
      return response.text()
    })
    .then(data => {
      try {
        let json = JSON.parse(data)

        if (json.error) {
          throw new ServerError(json)
        }

        if (json.result) {
          toastSuccess(json.result, json)
          callback(json.data)
        } else {
          callback(json)
        }

        console.log(json)
      } catch (err) {
        if (err.name === 'SyntaxError')
          toastError(
            'Был получен неверный формат данных',
            `${err.name}\n${err.message}\n${err.stack}\n${source}\n${data}`
          )
        else if (err.name === 'ServerError')
          toastError(
            err.message,
            `${err.name}\n${err.message}\n${err.stack}\n${source}\n${data}`
          )
        else
          toastError(
            'Неизвестная ошибка, обратитесь к разработчику',
            `${err.name}\n${err.message}\n${err.stack}\n${source}\n${data}`
          )
      }
    })
    .catch(err => {
      toastError(
        'Не удалось совершить операцию из-за проблем с сетью',
        `${err}\n${source}`
      )
    })
}
