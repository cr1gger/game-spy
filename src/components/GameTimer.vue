<template>
  <div class="timer">
    <strong>Игра началась!</strong>
    <br>
    <div>{{ timerComp }}</div>
    <br>
    <v-btn
        @click="restart()"
        color="red"
        block
        variant="outlined"
    >
      Начать заново
    </v-btn>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue"
import { playDzin, playEndTimer } from "@/use/Helper";

const emit = defineEmits([
    'timeout'
])
const props = defineProps([
    'timer'
])

const soundDzin = playDzin()
const soundEndTimer = playEndTimer()

let beenDzin = ref(false)
let intervalInstance = null

onMounted(() => {
  intervalInstance = setInterval(() => {
    // Sound
    if (!beenDzin.value) {
      soundDzin()
      beenDzin.value = true
    }
    if (props.timer.sec <= 0) {
      props.timer.min--
      props.timer.sec = 59
    } else {
      props.timer.sec--
    }
    if (props.timer.sec <= 0 && props.timer.min <= 0)
    {
      beenDzin.value = false
      restart()
    }
    if (props.timer.sec <= 3 && props.timer.min <= 0) {
      soundEndTimer()
    }
  }, 1000)
})

const restart = () => {
  clearInterval(intervalInstance)
  emit('timeout')
}

const timerComp = computed(() => {
  let sec = props.timer.sec < 10 ? "0" + props.timer.sec : props.timer.sec
  return props.timer.min + ":" + sec
})

</script>

<style scoped>
.timer {
  font-size: 20px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
</style>
