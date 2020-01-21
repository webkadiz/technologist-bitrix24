import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import { JsonError, ServerError, BaseError } from '@/core/errors'
import Format from "@/util/format"
import Util from '@/util/util'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    projectDir: "/projects",
    projectName: "",
    format: "",
    fields: {},
    errors: [],
    detailList: []
  },
  mutations: {
    makeErrorIsServed(state, errorID) {
      let error = _.find(state.errors, ['id', errorID])
      error.isNonServed = false
    },
    initFormat(state) {
      state.format = new Format(state);
    },
    loadDetailList(state, { project_name, detail_list }) {
      state.projectName = project_name;
      state.detailList = detail_list;
    },

    setDetailField(state, { id, value, field, depend }) {
      let detail = this.getters.getDetailById(id);

      value = Util.neutralizeField(value, field);

      detail[field] = value;
      if (depend) {
        this.commit(`${depend}Depend`, {
          id,
          field
        });
      }
    },
    weightDepend(state, { id, field }) {
      let detail = this.getters.getDetailById(id);
      let weightAll = detail["weightAll"];
      let refusal = detail["refusal"];

      if (Util.checkField(weightAll, "weightAll") && Util.checkField(refusal, "refusal")) {
        refusal = _.toFinite(refusal);
        weightAll = _.toFinite(weightAll);
        detail["weightFinal"] = _.round(weightAll + (weightAll * refusal) / 100, 2);
      } else {
        detail["weightFinal"] = 0;
      }
    }
  },
  getters: {
    getDetailById: state => id => {
      id = id.toString();
      let idPath = id.split(".");
      let el = state.detailList.find(item => item.id == idPath[0]);
      let i = 1;

      while (idPath[i]) {
        el = el.children.find(item => item.id == idPath[i]);
        i++;
      }

      return el;
    },
    getDetailField: (state, getters) => (id, field) => {
      let detail = getters.getDetailById(id);

      return detail[field];
    },
    getDetailFields: (state, getters) => id => {
      let detail = getters.getDetailById(id);

      let detailFilter = Object.keys(detail).filter(key => key.startsWith("field"));

      return detailFilter;
    }
  },
  actions: {
    createProject() {},
    getProject(context) {
      return axios("/technologist/project/get")
        .then(({ data }) => {
          if(typeof data === 'string') throw new JsonError(context, data)
          context.state.detailList = data
        })
        .catch(err => {
          if(err instanceof BaseError) return
          new ServerError(context);
        })
    },
    getFields(context) {
      return axios("/technologist/fields")
        .then(({data}) => {
          if(typeof data === 'string') throw new JsonError(context)
          context.state.fields = data;
          Util.init(data);
        })
        .catch(err => {
          if(err instanceof BaseError) return
          new ServerError(context);
        });
    }
  }
})
