<template>
  <div class="plasma">
    <div class="plasma__list">
      <MiniDetail
        v-for="(miniDetail, index) in detail.children"
        :miniDetailId="sumId(detail.id, miniDetail.id)"
        :key="index"
      ></MiniDetail>
    </div>

    <Scheme :scheme="detail.scheme"></Scheme>
    <ButtonCommon :container="true" :disabled="isErrorTree(detail.id)">сохранить изменения</ButtonCommon>
  </div>
</template>

<script>
import ButtonCommon from "../../button-cummon";
import Scheme from "../scheme";
import MiniDetail from "../mini-detail";

export default {
  components: {
    ButtonCommon,
    Scheme,
    MiniDetail
  },
  mixins: [sumId],
  props: ["detail"]
};
</script>



<style lang="scss">
.plasma {
  display: flex;
  flex-wrap: wrap;

  &__list {
    flex-grow: 1;
  }
}
</style>