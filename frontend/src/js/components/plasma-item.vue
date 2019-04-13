<template>
  <div class="plasma-item">
    <div class="plasma-item__title">{{plasmaItem.name}}</div>
    <Field
      v-for="(field, index) in detailFields"
      :key="index"
      v-bind="field"
      :id="detailId.toString() + '.' + plasmaItem.id.toString() "
    ></Field>
  </div>
</template>

<script>
import Field from "./field";

export default {
  components: {
    Field
  },
  props: ["plasmaItem", "detailId"],
  data() {
    return {
      detailFields: [
        { label: "Количество деталей", type: "amount_details" },
        {
          label: "Чистый вес детали (кг)",
          depend: "weight",
          type: "pure_weight"
        },
        {
          label: "Чистый вес всех деталей(кг)",
          type: "pure_weight_all"
        }
      ]
    };
  }
};
</script>

<style lang="scss">
.plasma-item {
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