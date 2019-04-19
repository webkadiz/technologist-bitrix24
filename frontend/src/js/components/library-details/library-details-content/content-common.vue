<template>
  <div>
    <transition name="swap" mode="out-in" tag="div">
      <div class="common" v-if="hiddenChildren" :key="'common'">
        <ButtonCommon
          :container="true"
          @click="showChildren"
          v-show="isShowChildren"
        >просмотреть детали</ButtonCommon>
        <Fields :detailId="sumId(nodeId, detail.id)"></Fields>
        <Scheme :scheme="detail.scheme"></Scheme>
        <ButtonCommon
          :container="true"
          class="mt-30"
          :disabled="isErrorTree(sumId(nodeId, detail.id))"
          @click="saveData(sumId(nodeId, detail.id))"
        >сохранить изменения</ButtonCommon>
      </div>
      <div class="library" v-else :key="'library'">
        <ButtonCommon :container="true" @click="hideChildren" class="gutter-add">назад</ButtonCommon>
        <Library :nodeId="detail.id" :detailList="detail.children"></Library>
      </div>
    </transition>
  </div>
</template>

<script>
import ButtonCommon from "../../button-cummon";
import Fields from "../fields";
import Scheme from "../scheme";

export default {
  components: {
    ButtonCommon,
    Fields,
    Scheme,
    Library: () => import("../library.vue")
  },
  props: ["detail"],
  inject: ["nodeId"],
  mixins: [sumId],
  computed: {
    isShowChildren() {
      return this.detail.children && this.detail.children.length;
    }
  },
  methods: {
    ...Vuex.mapActions(["getProject"]),
    showChildren() {
      this.hiddenChildren = false;
    },
    hideChildren() {
      this.hiddenChildren = true;
    },
    saveData(id) {
      let detail = this.getDetailById(id);

      let form = new FormData(detail);
      let detailJSON = JSON.stringify(detail);
      form.append("detail", detailJSON);

      fetchADV(
        "/technologist/project/save",
        {
          method: "POST",
          body: form
        },
        data => {
          this.getProject();
        }
      );
    }
  },
  data() {
    return {
      hiddenChildren: true,
      openedScheme: false
    };
  }
};
</script>

<style lang="scss" scoped>
.common {
  display: flex;
  flex-wrap: wrap;
  flex-shrink: 0;

  &__buttons {
    flex-basis: 100%;
    display: flex;
    justify-content: space-between;
  }
}

// АНИМАЦИЯ
.swap-enter,
.swap-leave-to {
  transform: translateX(calc(-100% - 50px));
  //opacity: 0;
}

.swap-enter-active,
.swap-leave-active {
  transition: 0.5s;
}
</style>