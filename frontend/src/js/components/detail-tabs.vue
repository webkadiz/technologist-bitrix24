<template>
  <div class="tabs">
    <div
      @click="current = tab"
      class="tab"
      :class="{active: current === tab}"
      v-for="(tab, index) in tabs"
      :key="index"
    >{{tab}}</div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      current: "",
      tabs: ["основное", "чертежи", "доп информация"]
    };
  }
};
</script>

<style lang="scss">
.tabs {
  display: flex;
  background: white;
  border-bottom: 2px solid #5a427f;
}

.tab {
  font-weight: bold;
  color: #95a5a6;
  cursor: pointer;
  padding: 10px;
  border-right: 2px solid #5a427f;
  position: relative;
}

.tab.active {
  color: #5a427f;
}

.tab.active:before {
  content: "";
  position: absolute;
  left: 0;
  bottom: -2px;
  width: 100%;
  height: 2px;
  background: white;
}
</style>