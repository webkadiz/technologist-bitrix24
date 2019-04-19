<template>
  <div class="title">
    <div class="title__name">{{detail.name}}</div>
    <div class="title__category">({{detail.category}})</div>
  </div>
</template>

<script>
export default {
  props: ["detail"]
};
</script>

<style lang="scss" scoped>
.title {
  padding: 10px 10px;
  background: #b39ddb;
  color: black;
  font-size: 1em;

  &__name {
    font-weight: bold;
    text-align: center;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  &__category {
    text-align: center;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 0.8em;
  }
}
</style>