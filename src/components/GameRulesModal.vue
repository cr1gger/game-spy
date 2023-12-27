<template>
  <div class="text-center">
    <v-dialog
        v-model="show"
    >
      <v-card>
        <v-card-title>Правила игры</v-card-title>
        <v-card-text>
          <div style="padding: 10px">
            <ol>
              <li>
                <p>В игре учавствуют местные и шпионы, передавайте телефон по кругу между игроками, чтобы узнать какая роль вам досталась.</p>
                <p>Все игроки, кроме <strong>шпиона</strong>, будут знать локацию (слово из выбранной категории)</p>
              </li>
              <li>
                <p>Ваша задача обмениваться вопросами о данной локации.</p>
                <p>Вопросы и ответы должны быть не прямыми, а завуалированными, так как шпион который не знает локацию может её угадать и выиграть.</p>
                <p>Если местные находят шпиона, то они <strong>побеждают</strong>.</p>
                <p>Прислушивайтесь к ответам других игроков, среди них может быть шпион.</p>
              </li>
              <li>
                <p>Если подозреваешь кого-то, скажи: <strong><i>Я знаю кто шпион</i></strong>.</p>
                <p>Остальные игроки должны указать на того, кого они считают шпионом.</p>
              </li>
              <li>
                <p>Если все игроки выбрали одного и того же игрока, <strong>он должен раскрыть свою роль</strong>.</p>
                <p><strong>Если это шпион</strong> - местные победили</p>
                <p><strong>Если это местный</strong> - победил шпион</p>
                <p><strong>Если указали на разных людей</strong> - играйте дальше</p>
              </li>
              <li>
                <p>Если шпион догадался что за локация, <strong>то он может её назвать</strong></p>
                <p><strong>Если угадал</strong> - победил шпион</p>
                <p><strong>Если ошибся</strong> - местные выиграли, так как шпион раскрылся</p>
              </li>
              <li>
                <p>Удачи!</p>
              </li>
            </ol>
          </div>
        </v-card-text>
        <v-card-actions>
          <v-btn color="primary" block @click="show = false" v-sound-click>Все понятно</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script setup>
import {computed, defineProps} from "vue";

const props = defineProps({
  modelValue: {
    type: Boolean,
  }
})

const emit = defineEmits([
  'update:modelValue'
])

const show = computed({
  get() {
    return props.modelValue;
  },
  set(newValue) {
    emit('update:modelValue', newValue)
  }
});

</script>

<style scoped>

</style>
