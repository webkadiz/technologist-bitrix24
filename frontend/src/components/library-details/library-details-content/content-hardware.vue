<template>
  <div class="hardware">
    <table class="striped centered responsive-table">
      <thead>
        <tr>
          <th>Наименование</th>
          <th>ГОСТ, ТУ</th>
          <th>Кол-во, шт</th>
          <th>Масса, кг</th>
          <th>Масса 1000шт, кг</th>
          <th>Примечания</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(detailRowChild, index) in detail.children" :key="index">
          <td v-for="(detailChild, index) in detailRowChild" :key="index">{{detailChild}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: ["detail"]
};
</script>

