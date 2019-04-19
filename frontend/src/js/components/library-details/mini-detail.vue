<template>
  <div class="mini-detail" :class="{'border_error': isErrorTree(miniDetailId)}">
    <div class="mini-detail__title">{{getDetailField(miniDetailId, 'name')}}</div>

    <Fields :detailId="miniDetailId"></Fields>
  </div>
</template>

<script>
import Fields from "./fields";

export default {
  components: {
    Fields
  },
  props: ["miniDetailId"]
};
</script>

<style lang="scss">
.mini-detail {
  border: 2px solid #5a427f;
  border-radius: 5px;
  margin-bottom: 40px;
  padding-bottom: 20px;

  &__title {
    padding: 20px;
    text-align: center;
    background: #5a427f;
    color: white;
  }
}
</style>