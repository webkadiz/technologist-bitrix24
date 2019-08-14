<template>
  <div class="header-panel gutter-add">
    <div class="file-field mr-20">
      <div class="btn waves-effect waves-light">
        <span>Загрузить ведомость</span>
        <input type="file" @change="choosedFile" accept=".zip, .rar">
      </div>
    </div>
    <div class="file-field mr-20">
      <div class="btn waves-effect waves-light">
        <span>Загрузить нормы экономиста</span>
        <input type="file" @change="loadEconomist" accept=".xls, .xlsx">
      </div>
    </div>
    <div flex>
      <ButtonCommon mr-20 @click="openReport">Отчет по проекту</ButtonCommon>
      <ButtonCommon mr-20 @click="removeProject">Удалить проект</ButtonCommon>
      <ButtonCommon>Экспортировать в ПЛАНИРОВЩИК</ButtonCommon>
    </div>
  </div>
</template>

<script>
import ButtonCommon from "./button-cummon";
//v-if="!$store.state.detailList.length"

export default {
  components: { ButtonCommon },
  computed: {},
  methods: {
    openReport() {
      bus.$emit("openReport");
    },
    loadEconomist(e) {
      let file = e.target.files[0];
      e.target.value = "";

      if (!file) return;

      if (file.name.endsWith(".xls") || file.name.endsWith(".xlsx")) {
        if (file.size < 1024 * 1024) {
          let formData = new FormData();

          formData.append("economist", file);

          fetch("/technologist/project/load-economist", {
            method: "POST",
            body: formData
          })
            .then(res => res.text())
            .then(data => {
              console.log(data);
            });
        } else {
          // ошибка файл большого размера
        }
      } else {
        // ошибка не соответсвует формату расширения
      }
    },
    choosedFile(e) {
      let file = e.target.files[0];
      e.target.value = "";

      if (!file) return;

      if (file.name.endsWith(".zip") || file.name.endsWith(".rar")) {
        if (file.size < 1024 * 1024 * 30) {
          let form = new FormData();

          form.append("project", file);

          fetchADV(
            "/technologist/project/create",
            {
              method: "POST",
              body: form
            },
            data => {
              this.getProject();
            }
          );
        } else {
          toastError(
            "загружаемый файл превышает допустимый размер в 30 мегабайт, загрузите файл размером меньше 30 мегабайт",
            "header-panel.vue -> choosedFile -> загружаемый файл превышает допустимый размер в 30 мегабайт, загрузите файл размером меньше 30 мегабайт"
          );
        }
      } else {
        toastError(
          "загружаемый файл не соответствует допустимому типу, файл должен быть zip-архивом",
          "header-panel.vue -> choosedFile -> загружаемый файл не соответствует допустимому типу, файл должен быть zip-архивом"
        );
      }
    },
    removeProject() {
      fetchADV("/technologist/project/remove", {}, data => {
        this.getProject();
      });
    },
    ...Vuex.mapActions(["getProject"])
  }
};
</script>

<style lang="scss">
.header-panel {
  padding-top: 30px;
  display: flex;
  justify-content: space-between;
}

.wrapper {
  position: relative;
}

.custom-file-layer {
  pointer-events: none;
}

.custom-file-input {
  height: 100%;
}
</style>