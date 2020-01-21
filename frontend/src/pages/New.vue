<template>
  <v-app>
    <v-navigation-drawer app permanent>
      <v-treeview
        @update:active="treeActive"
        @update:open="treeOpen"
        activatable
        :items="$store.state.detailList"
        rounded
      ></v-treeview>
    </v-navigation-drawer>

    <v-app-bar app>
      <!-- -->
    </v-app-bar>

    <v-content>
      <v-container fluid></v-container>
    </v-content>
  </v-app>
</template>

<script>
export default {
  mounted() {
    console.log(this.$route)
  },
  methods: {
    treeOpen(tree) {
      console.log('open', tree)
    },
    treeActive([active]) {
      console.log('active', active)
    }
  }
}
</script>

<style lang="scss" scoped>
.wrapper {
  width: 100vh;
  max-width: 1000px;
  margin: 0 auto;
  padding: 5vh 2vw 0;
}
</style>