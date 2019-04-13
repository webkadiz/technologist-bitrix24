<template>
  <div class="detail-list mt-40">
    <Detail v-for="detail in detailListFilter" :key="detail.id" :detail="detail"></Detail>
  </div>
</template>

<script>
import Detail from "./detail";

export default {
  components: {
    Detail
  },
  props: ["searchByCategory", "searchByDetail", "detailList"],
  computed: {
    detailListFilter() {
      let details = this.detailList;
      let category = this.searchByCategory;
      let search = this.searchByDetail;

      if (category === "детали") {
        details = details.filter(detail => detail.type === "detail");
      } else if (category === "сборки") {
        details = details.filter(detail => detail.type === "assembly");
      } else if (category === "все") {
        details = details;
      } else if (category === "ошибки") {
        details = details.filter(detail => this.isErrorTree(detail.id));
      } else if (category) {
        details = details.filter(detail => detail.category === category);
      }

      if (search) {
        details = details.filter(
          detail => ~detail.name.toLowerCase().indexOf(search.toLowerCase())
        );
      }

      return details;
    }
  }
};
</script>

<style lang="scss">
.detail-list {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}
</style>

