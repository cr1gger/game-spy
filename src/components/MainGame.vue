<template>
  <v-container>
    <v-row class="text-center">
      <v-col cols="12">
        <div class="game">
          <GameCard :player="players[0]" @closed="closeCard()" v-if="showCards"/>
          <keep-alive>
            <GameMenu @start="startGame" v-if="showMenu" @timeout="endGame()" />
          </keep-alive>
          <GameTimer :timer="time" @timeout="endGame()" v-if="showTimer"/>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import {ref, reactive} from "vue"
import GameCard from "@/components/GameCard"
import GameTimer from "@/components/GameTimer";
import Helper from "@/use/Helper";
import GameMenu from "@/components/GameMenu";

const showMenu = ref(true)
const showCards = ref(false)
const showTimer = ref(false)
const players = ref([])
const time = reactive({
  min: 1,
  sec:0
})

const selectedCategory = ref([])

const startGame = (playerCount, spyCount, min ,word) => {
  players.value = Helper.getPlayers(playerCount, spyCount, word)
  showCards.value = true
  showMenu.value = false
  time.min = min
  time.sec = 0
}

const endGame = () => {
  showCards.value = false
  showTimer.value = false
  showMenu.value = true
}

const closeCard = () => {
  players.value.shift()
  if (players.value.length <= 0) {
    showTimer.value = true
    showCards.value = false
  }
}
</script>

<style lang="scss">
  .game {
    display: flex;
    align-items: center;
    justify-content: center;
    justify-items: center;
  }

</style>
