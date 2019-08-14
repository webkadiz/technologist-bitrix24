<template>
  <div>
    <LibraryFilter
      @changeCategory="changeCategory"
      @searchDetail="searchDetail"
      :searchByCategory="searchByCategory"
      :searchByDetail="searchByDetail"
    ></LibraryFilter>
    <LibraryList
      :detailList="detailList"
      :searchByCategory="searchByCategory"
      :searchByDetail="searchByDetail"
    ></LibraryList>
  </div>
</template>

<script>
import LibraryFilter from "./library-filter";
import LibraryList from "./library-list";

export default {
  components: {
    LibraryFilter,
    LibraryList
  },
  props: ["detailList", "nodeId"],
  provide() {
    return {
      nodeId: this.nodeId
    }
  },
  methods: {
    changeCategory(category) {
      this.searchByCategory = category;
    },
    searchDetail(detail) {
      this.searchByDetail = detail;
    }
  },
  data() {
    return {
      searchByCategory: "",
      searchByDetail: ""
    };
  }
};
</script>

<style lang="scss">
</style>