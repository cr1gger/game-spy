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
          :disabled="disablePlayerMinus"
      ></v-btn>
      {{ playerCount }}
      <v-btn
          v-sound-click
          @click="playerCountUpdate()"
          class="ma-2"
          color="red"
          size="x-small"
          icon="mdi-plus"
          :disabled="disablePlayerPlus"
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
          :disabled="disableSpyMinus"
      ></v-btn>
      {{ spyCount }}
      <v-btn
          v-sound-click
          @click="spyCountUpdate()"
          class="ma-2"
          color="red"
          size="x-small"
          icon="mdi-plus"
          :disabled="disableSpyPlus"
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
          :disabled="disableTimerMinus"
      ></v-btn>
      {{ timer }}
      <v-btn
          v-sound-click
          @click="timerCountUpdate()"
          class="ma-2"
          color="red"
          size="x-small"
          icon="mdi-plus"
          :disabled="disableTimerPlus"
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
    <v-bottom-navigation grow color="red" border="red">
      <v-btn
          v-sound-click
          @click="showRules = true"
      >
        <v-icon>mdi-information-outline</v-icon>
        Правила
      </v-btn>

      <v-btn
          v-sound-click
          @click="showSettings = true"
      >
        <v-icon>mdi-cog</v-icon>
        Настройки
      </v-btn>

      <v-btn
      @click="App.exitApp()"
      v-if="Capacitor.getPlatform() !== 'web'"
      >
        <v-icon>mdi-exit-to-app</v-icon>
        Выход
      </v-btn>
    </v-bottom-navigation>

    <GameSetting v-model="showSettings"/>
    <GameRulesModal v-model="showRules"/>
  </div>
</template>

<script setup>
import {ref, computed ,onMounted, onActivated, onDeactivated} from "vue"
import localDb from "@/use/local-db";
import Helper from "@/use/Helper";
import GameSetting from "@/components/GameSetting"
import GameRulesModal from "@/components/GameRulesModal";
import { App } from '@capacitor/app';
import { Capacitor } from '@capacitor/core';
import { Haptics, ImpactStyle } from '@capacitor/haptics'; // TODO: add vibration

const MAX_PLAYER = 10;
const MIN_PLAYER = 3;

const MAX_SPY = 25;
const MIN_SPY = 1;

const MAX_TIMER = 30;
const MIN_TIMER = 1;

const showSettings = ref(false)
const showRules = ref(false)
const playerCount = ref(3)
const spyCount = ref(1)
const timer = ref(1)
const categoryError = ref("")
const selectedCategory = ref([])
const category = ref([])
const gameStarted = ref(false)


const emit = defineEmits([
    'start'
])

const playerCountUpdate = (up = true) => {
  if (up) {
    if (playerCount.value >= MAX_PLAYER) return;
    playerCount.value++
  } else {
    if (playerCount.value <= MIN_PLAYER) return;
    playerCount.value--
  }
}
// setInterval(function() {
// TODO: add vibration
//   Haptics.vibrate({
//     options: {
//       duration: 3000
//     }
//   });
// }, 1000)

const spyCountUpdate = (up = true) => {
  if (up) {
    let tmpSpyCount = spyCount.value + 1
    if (spyCount.value >= MAX_SPY) return;
    if (spyCount.value === playerCount.value || (tmpSpyCount) === playerCount.value) return;
    spyCount.value++
  } else {
    if (spyCount.value <= MIN_SPY) return;
    spyCount.value--
  }
}

const timerCountUpdate = (up = true) => {
  if (up) {
    if (timer.value >= MAX_TIMER) return;
    timer.value++
  } else {
    if (timer.value <= MIN_TIMER) return;
    timer.value--
  }
}

const disablePlayerPlus = computed(() => {
  return playerCount.value >= MAX_PLAYER;
})

const disablePlayerMinus = computed(() => {
  return playerCount.value <= MIN_PLAYER;
})

const disableSpyPlus = computed(() => {
  return spyCount.value >= MAX_SPY;
})

const disableSpyMinus = computed(() => {
  return spyCount.value <= MIN_SPY;
})

const disableTimerPlus = computed(() => {
  return timer.value >= MAX_TIMER;
})

const disableTimerMinus = computed(() => {
  return timer.value <= MIN_TIMER;
})

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
  gameStarted.value = true;
}

onMounted(async () => {
  category.value = await localDb.getCategories()

  await App.removeAllListeners();
  App.addListener('backButton', (event) => {
    if (showRules.value) {
      showRules.value = false;
    }

    if (showSettings.value) {
      showSettings.value = false
    }

    if (gameStarted.value) {
      emit('timeout')
    }
  })
})

onActivated(() => {
  gameStarted.value = false;
  // console.log('onActivated', gameStarted.value)
})

onDeactivated(() => {
  gameStarted.value = true;
  // console.log('onDeactivated', gameStarted.value)

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
