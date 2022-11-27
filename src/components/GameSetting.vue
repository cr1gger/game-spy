<template>
  <v-dialog
      v-model="show"
      fullscreen
      :scrim="false"
      transition="dialog-bottom-transition"
  >
    <v-card>
      <v-toolbar
          dark
          color="red"
      >
        <v-btn
            v-sound-click
            icon
            dark
            color="white"
            @click="show = false"
        >
          <v-icon>mdi-close</v-icon>
        </v-btn>
        <v-toolbar-title>Настройки</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-btn
              v-sound-click
              variant="plain"
              @click="show = false"
          >
            Сохранить
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>
      <v-list>
        <v-list-subheader>Игра</v-list-subheader>
        <v-list-item>
          <template v-slot:prepend>
            <v-checkbox
                @click="playSound(keepWords)"
                v-model="keepWords"
                label="Запоминать слова"
                messages="Запоминать слова которые уже попадались и не показывать их."
            />
          </template>

        </v-list-item>

        <v-list-item>
            <v-btn color="red" variant="plain" @click="resetUsedWords()">
              Сбросить сохраненные слова
            </v-btn>
        </v-list-item>

      </v-list>
      <v-divider></v-divider>
      <v-list>
        <v-list-subheader>Система</v-list-subheader>
        <v-list-item>
          <template v-slot:prepend>
            <v-checkbox
                v-model="sound"
                label="Звуки" messages="Звуки кликов, начало игры, завершение таймера и т.д"
                @click="playSound(sound)"
            />
          </template>
        </v-list-item>
        <v-list-item>
          <template v-slot:prepend>
            <v-checkbox v-model="vibration" label="Вибрация" @click="playSound(vibration)"/>
          </template>

        </v-list-item>
      </v-list>
    </v-card>
    <v-snackbar
        v-model="notify"
        :timeout="3000"
        vertical
        top
        color="red"
    >Список слов успешно очищен!</v-snackbar>
  </v-dialog>
</template>

<script setup>
import {computed, defineProps, ref} from "vue"
import { useStorage } from '@vueuse/core'
import { playSoundClick } from "@/use/Helper"
import Enum from "@/use/Enum";



const props = defineProps({
  modelValue: {
    type: Boolean,
  }
})

const playSound = playSoundClick()

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
const notify = ref(false)
const sound = useStorage(Enum.SETTING_SOUND, true)
const vibration = useStorage(Enum.SETTING_VIBRATION, true)
const keepWords = useStorage(Enum.SETTING_KEEP_WORDS, false)


const resetUsedWords = () => {
  useStorage(Enum.SETTING_USED_WORDS, []).value = []
  notify.value = true
}
</script>

<style scoped>

</style>
