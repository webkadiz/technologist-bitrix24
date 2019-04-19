<template>
  <transition name="report">
    <div class="report" v-if="openedReport">
      <ControlPanel :show="openedReport" :closeFunc="closeReport"></ControlPanel>
      <div class="report__content">
        <h4>Материалы</h4>
        <div class="divider"></div>
        <table class="striped centered">
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
        <h4 class="mt-30">Трудозатраты</h4>
        <div class="divider"></div>
        <table class="striped centered">
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

export default {
  components: { FieldInput, ControlPanel },
  mounted() {
    bus.$on("openReport", this.openReport);
  },
  methods: {
    getMaterialList() {
      fetchADV("/technologist/project/compute/materials", {}, data => {
        this.materialList = data;
      });
    },

    getLaborCosts() {
      fetchADV("/technologist/project/compute/labor-costs", {}, data => {
        this.laborHours = data.laborHours;
        this.laborDays = data.laborDays;
        this.laborCosts = data.laborCosts;
      });
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
  z-index: 100;

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
</style>