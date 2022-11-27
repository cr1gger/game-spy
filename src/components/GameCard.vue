<template>
  <div class="card" @click.stop="openCard($event)">
    <div class="back">
      {{ getWord }}
      <div class="timeline"></div>
    </div>
    <div class="front">
      <v-img src="@/assets/click.png" style="width: 30%"/>
    </div>

  </div>
</template>

<script setup>
import { defineProps, defineEmits, ref, computed } from "vue"
import { playSoundCard } from "@/use/Helper";

const showWord = ref(false);

const timeShowing = 3; // in sec

const props = defineProps({
  player: Object
})

const emit = defineEmits([
    'closed'
])

const soundCard = playSoundCard()

const openCard = (e) => {
  if (showWord.value) return

  soundCard()
  showWord.value = true
  const cardNode = e.currentTarget;
  const timelineNode = cardNode.querySelector('.timeline')

  cardNode.classList.add('hover')
  timelineNode.classList.add('start')

  setTimeout(() => {
    soundCard(true)
    showWord.value = false
    emit('closed')
    cardNode.classList.remove('hover')
    timelineNode.classList.remove('start')
  }, timeShowing * 1000)

}

const getWord = computed(() => {
  if (showWord.value) {
    return props.player.spy ? "Шпион" : props.player.word
  }
  return '';
})
</script>

<style lang="scss">

@keyframes timelineDown {
  from {
    width: 100%;
  }
  to {
    width: 0;
  }
}

.timeline {
  position: absolute;
  bottom: 10px;
  height: 1px;
  width: 100%;
  background: red;
  display: none;

  &.start {
    display: flex;
    animation: timelineDown 3s;
  }
}

.card {
  position: relative;
  cursor: pointer;
  transition-duration: 0.6s;
  transition-timing-function: ease-in-out;
  transform-style: preserve-3d;
  background: white;
  border-radius: 10px;
  color: black;
  min-height: 300px;
  min-width: 200px;
  padding: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;

  .front, .back {
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
  }

  .front {
    color: red;
    background: white;
    font-weight: 700;
    font-size: 1rem;
    z-index: 2;
    position: absolute;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    justify-items: center;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
    transform: rotateX(0deg);
  }

  .back {
    z-index: 1;
    font-size: 1.5rem;
    color: black;
    background: white;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
    transform: rotateX(180deg) rotate(180deg);
  }

  .timeline {
    position: absolute;
    height: 5px;
    width: 100%;
    background: #4f4f4f;
    bottom: 10px;
  }

  &.hover {
    .back {
      z-index: 2
    }
    .front {
      z-index: 1;
    }
    transform: rotateY(180deg);
  }
}

</style>
