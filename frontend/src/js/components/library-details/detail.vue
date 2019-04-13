<template>
  <div class="detail" @click="openDetail" :class="detailClasses">
    <ControlPanel :show="openedDetail" :closeFunc="closeDetail"></ControlPanel>
    <DetailTitle :detail="detail" :style="titleStyle"></DetailTitle>

    <div class="detail__content">
      <transition name="fade-translateY">
        <component v-if="openedDetail" :is="detail.component" :detail="detail"></component>
      </transition>
    </div>
  </div>
</template>

<script>
import ControlPanel from "../control-panel";
import DetailTitle from "../detail-title";

import ContentCommon from "./library-details-content/content-common";
import ContentPlasma from "./library-details-content/content-plasma";
import ContentHardware from "./library-details-content/content-hardware";

export default {
  components: {
    ControlPanel,
    DetailTitle,
    ContentCommon,
    ContentPlasma,
    ContentHardware
  },
  props: ["detail"],
  inject: ["nodeId"],
  mixins: [sumId],
  computed: {
    detailClasses() {
      return {
        border_error: this.isErrorTree(this.sumId(this.nodeId, this.detail.id)),
        detail_open: this.openedDetail
      };
    },
    titleStyle() {
      return {
        cursor: this.openedDetail ? "default" : "pointer"
      };
    }
  },
  methods: {
    //открывает карточку детали
    openDetail() {
      let el, left, top;

      if (this.openedDetail) return;

      this.openedDetail = true;

      el = this.$el;

      this.left = left = el.getBoundingClientRect().left; // запоминаем расстояние от левого края родительского элемнта, до абсолютного позиционирования
      this.top = top = el.getBoundingClientRect().top; // запоминаем расстояние от верхнего края родительского элемнта, до абсолютного позиционирования
      $(el).before($(el).clone()); // добавляем до елемента его клон
      $(el).css({
        position: "fixed",
        margin: 0
      });
      $(el).css({ left, top: top - 30 }); // возвращаем элемент на исходное положение
      // анимируем раскрытие карточки детали
      //prettier-ignore
      Velocity(el, {
          height: "100%",
          width: "100%",
          left: "0%",
          top: "0%"
        }, 250);
    },
    //закрывает карточку детали
    closeDetail() {
      this.openedDetail = false;
      //prettier-ignore
      Velocity(this.$el, {
          top: this.top ,
          left: this.left,
          width: 200,
          height: 60
        }, {
          delay: 300,
          duration: 250,
          complete: () => {
            $(this.$el).css({
              position: '',
              margin: ''
            })
            //prettier-ignore
            $(this.$el).prev().remove();

          }
        })
    }
  },
  data() {
    return {
      openedDetail: false
    };
  }
};
</script>

<style lang="scss">
.detail {
  width: 200px;
  height: 60px;
  white-space: nowrap;
  margin-right: 5px;
  margin-left: 5px;
  margin-top: 15px;
  overflow: hidden;
  border: 2px solid #b39ddb;

  &__content {
    background: white;
    height: calc(100% - 90px);
    width: 100%;
    padding: 40px;
    overflow: hidden scroll;
  }
}

.detail_open {
  z-index: 20;
  position: fixed;
  margin: 0;
}

// АНИМАЦИЯ ПОЯВЛЕНИЯ КОНТЕНТА
.fade-translateY-enter,
.fade-translateY-leave-to {
  transform: translateY(30px);
  opacity: 0;
}

.fade-translateY-enter-active {
  transition: 0.3s 0.3s;
}

.fade-translateY-leave-active {
  transition: 0.3s;
}
</style>