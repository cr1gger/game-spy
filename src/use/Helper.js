import {useStorage} from "@vueuse/core";
import Enum from "@/use/Enum";
import soundClickOn from "@/assets/btn-on.mp3"
import soundClickOff from "@/assets/btn-off.mp3"
import soundTakeCard from "@/assets/take_card.mp3"
import soundTakeCardReverse from "@/assets/take_card_reverse.mp3"
import soundDzin from "@/assets/dzin.mp3"
import soundEndTimer from "@/assets/end_timer.mp3"

const getPlayers = (playerCount, spyCount, word) => {
    let players = [];

    for(let i = 0; i < playerCount; i++) {
        players.push({
            id: i,
            spy: false,
            word
        })
    }

    for(let i = 0; i < spyCount; i++) {
        let candidates = players.filter(p => !p.spy)
        let spy = getRandomElement(candidates)
        let playerIdx = players.findIndex(p => p.id === spy.id)

        if (playerIdx !== -1) {
            players[playerIdx].spy = true
        }
    }
    return players;
}

const getRandomElement = (array) => {
    return array[Math.floor(Math.random() * array.length)]
}

const getRandomWord = (words) => {
    const keepWords = useStorage(Enum.SETTING_KEEP_WORDS, false);

    if (keepWords.value)
    {
        const wordsList = useStorage(Enum.SETTING_USED_WORDS, []);
        const usedWords = useStorage(Enum.SETTING_USED_WORDS, [])
        const word = getRandomElement(words.diff(wordsList.value))
        if (word) {
            usedWords.value = [...new Set([...usedWords.value, word])]
        }

        return word
    }

    return getRandomElement(words)

}

export const playSoundClick = () => {
    const on = new Audio(soundClickOn);
    const off = new Audio(soundClickOff);

    return function (onClick) {
        if (onClick) {
            playSound(on)
        } else {
            playSound(off)
        }
    }
}

export const playSoundCard = () => {
    const sound = new Audio(soundTakeCard)
    const soundReverse = new Audio(soundTakeCardReverse)

    return function (reverse = false) {
        if (reverse) {
            playSound(soundReverse)
        } else {
            playSound(sound)
        }
    }
}

export const playDzin = () => {
    const sound = new Audio(soundDzin)

    return function () {
        playSound(sound)
    }
}

export const playEndTimer = () => {
    const sound = new Audio(soundEndTimer)

    return function () {
        playSound(sound)
    }
}

const playSound = (sound) => {
    const enableSound = useStorage(Enum.SETTING_SOUND, true)

    if (!enableSound.value) {
        return;
    }

    sound.play()
}

export default {
    getPlayers,
    getRandomElement,
    getRandomWord,
}
