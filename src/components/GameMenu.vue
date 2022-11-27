<template>
  <div class="setting">
    <div class="input-group" data-title="Игроки">
      <v-btn
          v-sound-click
          @click="playerCountUpdate(false)"
          class="ma-2"
          color="red"
          icon="mdi-minus"
          size="x-small"
      ></v-btn>
      {{ playerCount }}
      <v-btn
          v-sound-click
          @click="playerCountUpdate()"
          class="ma-2"
          color="red"
          size="x-small"
          icon="mdi-plus"
      ></v-btn>
    </div>
    <div class="input-group" data-title="Шпионы">
      <v-btn
          v-sound-click
          @click="spyCountUpdate(false)"
          class="ma-2"
          color="red"
          icon="mdi-minus"
          size="x-small"
      ></v-btn>
      {{ spyCount }}
      <v-btn
          v-sound-click
          @click="spyCountUpdate()"
          class="ma-2"
          color="red"
          size="x-small"
          icon="mdi-plus"
      ></v-btn>
    </div>

    <div class="input-group" data-title="Таймер">
      <v-btn
          v-sound-click
          @click="timerCountUpdate(false)"
          class="ma-2"
          color="red"
          icon="mdi-minus"
          size="x-small"
      ></v-btn>
      {{ timer }}
      <v-btn
          v-sound-click
          @click="timerCountUpdate()"
          class="ma-2"
          color="red"
          size="x-small"
          icon="mdi-plus"
      ></v-btn>
    </div>

    <div class="input-group border-none" >
      <v-select
          ref="cat"
          class="select-category"
          chips
          label="Категория слов"
          :items="category"
          item-title="name"
          item-value="id"
          multiple
          variant="underlined"
          hint="Можно выбрать несколько категорий слов, так интересней =)"
          :persistent-hint="true"
          :error-messages="categoryError"
          v-model="selectedCategory"
          :clearable="true"
          :persistent-clear="true"
          @update:modelValue="categoryError = ''"
      ></v-select>
    </div>
    <v-btn
        v-sound-click
        @click="start()"
        color="red"
        block
        variant="outlined"
    >
      Старт
    </v-btn>
    <br>
    <v-btn
        v-sound-click
        @click="showSettings = true"
        color="red"
        block
        variant="flat"
    >
      Настройки
    </v-btn>
    <GameSetting v-model="showSettings"/>
  </div>
</template>

<script setup>
import {ref, defineEmits, onMounted} from "vue"
import localDb from "@/use/local-db";
import Helper from "@/use/Helper";
import GameSetting from "@/components/GameSetting"
import {useWebNotification} from "@vueuse/core/index";


const showSettings = ref(false)
const playerCount = ref(3)
const spyCount = ref(1)
const timer = ref(1)
const categoryError = ref("")
const selectedCategory = ref([])
const category = ref([])
import { Haptics, ImpactStyle } from '@capacitor/haptics';


const emit = defineEmits([
    'start'
])

const playerCountUpdate = (up = true) => {
  if (up) {
    if (playerCount.value >= 50) return;
    playerCount.value++
  } else {
    if (playerCount.value <= 3) return;
    playerCount.value--
  }
}
// setInterval(function() {
//   Haptics.vibrate({
//     options: {
//       duration: 3000
//     }
//   });
// }, 1000)

const spyCountUpdate = (up = true) => {
  if (up) {
    if (spyCount.value >= 25) return;
    spyCount.value++
  } else {
    if (spyCount.value <= 1) return;
    spyCount.value--
  }
}

const timerCountUpdate = (up = true) => {
  if (up) {
    if (timer.value >= 30) return;
    timer.value++
  } else {
    if (timer.value <= 1) return;
    timer.value--
  }
}

const start = async () => {
  if (selectedCategory.value.length <= 0) {
    categoryError.value = "Выберите категории слов..."
    return
  }
  let words = await localDb.getWordsByCategory(selectedCategory.value)
  let word = Helper.getRandomWord(words)
  if (!word) {
    categoryError.value = "В выбранных категориях все слова уже были использованы. Выберите другие категории или сбросьте слова в настройках"
    return
  }



  emit('start',
    playerCount.value,
    spyCount.value,
    timer.value,
    word
  )
}

onMounted(async () => {
  category.value = await localDb.getCategories()
})
</script>

<style lang="scss" scoped>
.setting {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

.select-category {
  border: 1px solid rgba(204, 204, 204, 0.1);
  padding: 10px;
  border-radius: 10px;


}

.input-group {
  border: 1px solid rgba(204, 204, 204, 0.1);
  border-radius: 10px;
  padding: 4px 4px 20px;
  margin-bottom: 20px;
  position: relative;
  width: 300px;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  margin-top: 10px;
  font-size: 20px;
  font-weight: bold;

  +.border-none {
    border: none;
  }
  >span {
    font-size: 30px;
    border-radius: 50%;
    height: 30px;
    width: 30px;
    text-align: center;
    padding-top: -5px;
    font-weight: bold;
    cursor: pointer;
    background: rgba(255, 0, 0, 0.53);
  }
  &:before{
    content: attr(data-title);
    position: absolute;
    left:50%;
    right: 50%;
    color:#f44336;
    top:55px;
    transform: translate(-50%, -50%);
    width: 100%;
    text-align: center;
    font-size: 18px;

  }
}
</style>
