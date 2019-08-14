<template>
  <div class="detail-filter mt-40 gutter-add">
    <div class="detail-filter__list">
      <div
        :class="{'detail-filter__item_active' : category === current}"
        class="detail-filter__item"
        @click="changeCategory($event, category)"
        v-for="(category, index) in computeCategories"
        :key="index"
      >{{category}}</div>
    </div>
    <input @input="searchDetail" autofocus placeholder="поиск карточки детали">
  </div>
</template>

<script>
export default {
  props: ["searchByCategory", "searchByDetail"],
  computed: {
    computeCategories() {
      let categories = [];

      this.$store.state.detailList.forEach(detail => {
        categories.push(detail.category);
      });

      categories = _.uniq(categories);

      return ["все", "детали", "сборки", ...categories, "ошибки"];
    }
  },
  methods: {
    changeCategory(e, category) {
      this.current = category;

      this.$emit("changeCategory", category);
    },
    searchDetail(e) {
      this.$emit("searchDetail", e.target.value);
    }
  },
  data() {
    return {
      current: "",
      categories: [
        "все",
        "детали",
        "сборки",
        "метизы",
        "уголки черные",
        "колонны сварные",
        "балки сварные"
      ]
    };
  }
};
</script>

<style lang="scss">
.detail-filter {
  &__list {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
  }

  &__item {
    position: relative;
    color: #7f8c8d;
    transition: 0.4s;
    white-space: nowrap;
    margin-right: 10px;
    margin-top: 10px;
    padding: 0 10px 10px 10px;
    cursor: pointer;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 1.1em;

    // &:after {
    //   content: "";
    //   transition: 0.4s;
    //   position: absolute;
    //   left: 0;
    //   bottom: 0;
    //   width: 100%;
    //   height: 3px;
    //   background: #3498db;
    //   transform: scale(0);
    // }

    &:hover {
      color: #3498db;
      // &:after {
      //   transform: scale(1);
      // }
    }
  }

  &__search {
    margin-top: 40px;
    outline: none;
    border: none;
    background: transparent;
    width: 100%;
    border-bottom: 2px solid #dee2e6;
    display: block;
    padding-left: 15px;
    padding-bottom: 6px;
  }
}

.detail-filter__item_active {
  color: #3498db;

  &:after {
    transform: scale(1);
  }
}
</style>