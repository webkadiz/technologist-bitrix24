<template>
  <transition name="report">
    <div class="report" v-if="openedReport">
      <ControlPanel :show="openedReport" :closeFunc="closeReport"></ControlPanel>
      <div class="report__content">
        <div class="report__header">
          <h4 class="report__title">Материалы</h4>
          <ButtonCommon @click="printTable('table-materials')">Распечатать материалы</ButtonCommon>
        </div>
        <div class="divider"></div>
        <table class="striped centered table-materials">
          <thead>
            <tr>
              <th>Тип профиля</th>
              <th>Марка стали(ширина штрипсы), мм</th>
              <th>Толщина,мм</th>
              <th>Масса деталей, кг</th>
              <th>Масса материала с отходами (план), кг</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="(materialRow, index) in materialList" :key="index">
              <td v-for="(materialItem, index2) in materialRow" :key="index2">{{materialItem}}</td>
            </tr>
          </tbody>
        </table>
        <div class="report__header">
          <h4 class="report__title mt-30">Трудозатраты</h4>
          <ButtonCommon @click="printTable('table-labor')">Распечатать трудозатраты</ButtonCommon>
        </div>
        <div class="divider"></div>
        <table class="striped centered table-labor">
          <thead>
            <tr>
              <th>Вид изделия</th>
              <th>Длина, п.м</th>
              <th>Количество шт.</th>
              <th>L швов во всех сборках, м</th>
              <th>Количество круглых отверстий</th>
              <th>Количество овальных отверстий</th>
              <th>Площадь зачистки/покраски, м2</th>
              <th>Трудоемкость прокатки, часов</th>
              <th>Трудоемкость порезки, часов</th>
              <th>Трудоемкость сверления, часов</th>
              <th>Трудоемкость сварки, часов</th>
              <th>Трудоемкость сборки, часов</th>
              <th>Трудоемкость зачистки/покраски, часов</th>
              <th>Трудоемкость, часов, общая</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="(laborRow, index) in laborCosts" :key="index">
              <td v-for="(laborItem, index2) in laborRow" :key="index2">{{laborItem}}</td>
            </tr>
          </tbody>
        </table>
        <FieldInput
          class="mt-30"
          :label="'трудоемкость проекта в часах'"
          :value="laborHours"
          :disabled="true"
        ></FieldInput>
        <FieldInput
          :label="'трудоемкость проекта в рабочих днях'"
          :value="laborDays"
          :disabled="true"
        ></FieldInput>
      </div>
    </div>
  </transition>
</template>

<script>
import ControlPanel from "./control-panel";
import FieldInput from "./library-details/field-input";
import ButtonCommon from "./button-cummon";
import axios from 'axios'
import bus from '@/util/bus'
import { LogicError, JsonError, ServerError, BaseError } from '@/core/errors'

export default {
  components: { FieldInput, ControlPanel, ButtonCommon },
  mounted() {
    bus.$on("openReport", this.openReport);
    bus.$on('removeProject', this.cleanData)
  },
  methods: {
    cleanData() {
      this.materialList = []
      this.laborCosts = []
      this.laborHours = 0
      this.laborDays = 0
    },
    printTable(table) {
      let prtContent = document.querySelector(`.${table}`);
      //prettier-ignore
      let WinPrint = window.open("", "", "left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0");

      WinPrint.document.write(`${prtContent.outerHTML}`);
      //prettier-ignore
      WinPrint.document.write("<script src='/public/js/print.js'><\/script>");
      WinPrint.document.close();
    },
    getMaterialList() {
      return axios("/technologist/project/compute/materials")
        .then(({data}) => {
          if(typeof data === 'string') throw new JsonError(this.$store, 'не удалось получить материалы от сервера')
          if(data.error) throw new LogicError(this.$store, data.error.message)

          this.materialList = data.data
        })
        .catch(err => {
          console.log(err)
          if(err instanceof BaseError) return
          new ServerError(this.$store);
        })
    },

    getLaborCosts() {
      return axios("/technologist/project/compute/labor-costs")
        .then(({ data }) => {
          console.log(data)
          if(typeof data === 'string') throw new JsonError(this.$store, 'не удалось получить трудозатраты от сервера')
          if(data.error) throw new LogicError(this.$store, data.error.message)
          this.laborHours = data.data.laborHours;
          this.laborDays = data.data.laborDays;
          this.laborCosts = data.data.laborCosts;
        })
        .catch(err => {
          if(err instanceof BaseError) return
          new ServerError(this.$store)
        })
    },
    async openReport() {
      await this.getLaborCosts();
      await this.getMaterialList();
      this.openedReport = true;
    },
    closeReport() {
      this.openedReport = false;
    }
  },
  data() {
    return {
      materialList: [],
      laborCosts: [],
      laborHours: 0,
      laborDays: 0,
      openedReport: false
    };
  }
};
</script>

<style lang="scss">
.report {
  position: fixed;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: white;
  z-index: 6;

  &__header {
    padding-bottom: 1rem;
    display: flex;
    justify-content: space-between;
  }

  &__title {
    margin: 0;
  }

  &__content {
    height: calc(100% - 30px);
    padding: 40px;
    overflow: scroll;
  }
}

.report-enter,
.report-leave-to {
  transform: scale(0);
}

.report-enter-active,
.report-leave-active {
  transition: 0.5s;
}

// @media print {
//   body * {
//     visibility: hidden;
//   }
//   .table,
//   .table * {
//     visibility: visible;
//   }
//   // .table {
//   //   position: absolute;
//   //   left: 0;
//   //   top: 0;
//   // }
//}
</style>