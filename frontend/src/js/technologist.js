import "./config";

import HeaderPanel from "./components/header-panel";

import Library from "./components/library-details/library";
import Overlay from "./components/overlay";
import Report from "./components/report";
import Format from "./format";

// function resizeWindow() {
//   BX24.resizeWindow(BX24.getScrollSize().scrollWidth, BX24.getScrollSize().scrollHeight);
// }
if (BX24) BX24.resizeWindow(BX24.getScrollSize().scrollWidth, 800);

let store = new Vuex.Store({
  state: {
    projectDir: "/projects",
    projectName: "",
    format: "",
    fields: {},
    detailList: []
  },
  mutations: {
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
        refusal = float(refusal);
        weightAll = float(weightAll);
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
      fetchADV("/technologist/project/get", {}, data => {
        context.state.detailList = data;
      });
      // console.log("get project");
      // fetch("/technologist/project/get")
      //   .then(res => res.json())
      //   .then(data => {
      //     console.log(data);
      //     context.state.detailList = data;
      //   })
      //   .catch(err => {
      //     console.log(err);
      //   });
    },
    getFields(context) {
      fetch("/technologist/config/fields")
        .then(res => res.json())
        .then(data => {
          context.state.fields = data;
          Util.init(data);
        })
        .catch(err => {
          console.log(err);
        });
    }
  }
});

new Vue({
  el: "#app",
  store,
  components: {
    Library,
    Overlay,
    HeaderPanel,
    Report
  },
  async created() {
    this.initFormat();
    await this.getFields();
    this.getProject();
  },
  methods: {
    ...Vuex.mapMutations(["initFormat"]),
    ...Vuex.mapActions(["getProject", "getFields"])
  },
  data: {}
});
