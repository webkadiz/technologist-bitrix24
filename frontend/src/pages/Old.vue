<template>
  <div>
    
    <router-link to="/new" class="new-version"><v-btn>new version</v-btn></router-link>
    <header-panel></header-panel>
    <library :detail-list="$store.state.detailList"></library>
    <report></report>
    <errors></errors>
  </div>
</template>

<script>
import HeaderPanel from "@/components/header-panel";
import Library from "@/components/library-details/library";
import Report from "@/components/report";
import Errors from "@/components/errors"

export default {
  components: {HeaderPanel, Library, Report, Errors}
}

</script>

<style>

.new-version {
  display: block;
  margin-left: 15px;
  margin-top: 20px;
}

</style>