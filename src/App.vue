<template>
  <v-app>
    <div class="title">
      <img :src="spyImage" width="100" style="filter:invert()" alt="Logo"/>
      <span>ШПИОН</span>
    </div>
    <v-main>
      <AppSpinner v-if="loading"/>
      <router-view v-else />
    </v-main>
  </v-app>
</template>

<script setup>
import spyImage from "@/assets/spy.png"
import { Preferences } from '@capacitor/preferences';
import {onBeforeMount, onMounted, ref} from "vue";
import localDB from "@/use/local-db"
import AppSpinner from "@/components/AppSpinner"

const loading = ref(true);
onBeforeMount(() => {
  YaGames
      .init()
      .then(ysdk => {
        console.log('Yandex SDK initialized');
        window.ysdk = ysdk;
      });
})
onMounted(async () => {
  let settingJson = await Preferences.get({
    key: 'setting'
  })
  let setting = JSON.parse(settingJson.value)

  if (setting?.loaded) {
    loading.value = false
  } else {
    // При первом запуске нужно сохранить все слова в настройки чтобы приложение работало без интернета
    await localDB.getWords()
    await localDB.getCategories()
    await Preferences.set({
      key: 'setting',
      value: JSON.stringify({
        loaded: true
      })
    })
    loading.value = false
  }
  ysdk.features.LoadingAPI?.ready();
})
</script>

<style lang="scss">

.title {
  display: flex;
  justify-content: center;

  >span {
    font-size: 3rem;
    color: red;
    padding-top: 30px;

  }
}
</style>
