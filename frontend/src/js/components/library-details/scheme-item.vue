<template>
  <div class="scheme__item mb-40">
    <ControlPanel :show="openedScheme" :closeFunc="closeScheme"></ControlPanel>
    <ButtonCommon v-if="!openedScheme" @click="openScheme">Открыть чертеж</ButtonCommon>
    <object :data="schemeObject" type class="scheme__object mt-20"></object>
  </div>
</template>

<script>
import ControlPanel from "../control-panel";
import ButtonCommon from "../button-cummon";

export default {
  components: {
    ControlPanel,
    ButtonCommon
  },
  props: ["schemeObject"],
  computed: {},
  methods: {
    openScheme() {
      let el;

      this.openedScheme = true;

      el = this.$el;
      this.left = el.getBoundingClientRect().left; // запоминаем расстояние от левого края родительского элемнта, до абсолютного позиционирования
      this.top = el.getBoundingClientRect().top; // запоминаем расстояние от верхнего края родительского элемнта,до абсолютного позиционирования
      this.width = el.getBoundingClientRect().width;
      this.height = el.getBoundingClientRect().height;
      $(el).before($(el).clone());

      $(el).addClass("scheme__item_open"); // добавляем класс для абсолютного позиционирования
      $(el).css({
        left: this.left,
        top: this.top - 30,
        width: this.width,
        height: this.height
      }); // возвращаем элемент на исходное положение
      // анимируем раскрытие карточки детали
      //prettier-ignore
      Velocity(el, {
          height: "100%",
          width: "100%",
          left: "0%",
          top: "0%"
        }, 250);
    },
    closeScheme() {
      this.openedScheme = false;
      //prettier-ignore
      Velocity(this.$el,{
          height: this.height,
          width: this.width,
          left: this.left,
          top: this.top
        },{
					delay: 300,
          duration: 250,
          complete(el) {
						$(el).removeClass('scheme__item_open')
            $(el).prev().remove();
				}});
    }
  },
  data() {
    return {
      openedScheme: false
    };
  }
};
</script>

<style lang="scss">

.scheme__item {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  height: 500px;
}

.scheme__object {
  width: 100%;
  height: 100%;
}

.scheme__item_open {
  position: fixed;
}

.scheme__item_open .scheme__object {
  margin: 0;
}
</style>