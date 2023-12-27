import axios from "axios";
import { Preferences } from '@capacitor/preferences';
import { useNetwork } from '@vueuse/core'
import Enum from "@/use/Enum";

const { isOnline } = useNetwork()



// const words = {
//     1: ['Железный человек', 'Хищник', 'Терминатор', 'Маша и медведь'],
//     2: ['Россия', 'Казахстан', 'Беларусь', 'Китай', 'Армения'],
//     3: ['Свет', 'Стул','Кровать','Электричество', 'Ключи', 'Обувь'],
//     4: ['Кафе','Кинотеатр','Музей','Площать','ДК','Парк'],
//     5: ['География 1','География 2','География 4','География 5'],
//     6: ['Автобус','Машина','Камаз','Велосипед','Самокат', 'Самолет'],
//     7: ['Лыжи','Снег','Дартс','Беговая дорожка','Гири'],
//     8: ['Машина времни', 'Летающая машина', 'Инопланетяне'],
// }

const getWords = async () => {

    // Если есть инет берем слова по API
    if (isOnline.value) {
        let response = null;
        try {
             response = await axios.get(Enum.API_BASE + 'api/words')
        } catch (e) {
            return await getSavedWords();
        }

        let result = {}

        response.data.forEach((word) => {
            if (!Array.isArray(result[word.category_id])) {
                result[word.category_id] = [];
            }
            result[word.category_id].push(word.name)
        })

        // Сохраняем на случай отсутствия интернета
        await Preferences.set({
            key: 'words',
            value: JSON.stringify(result)
        })

        return result
    } else {
        // Если нет берем из настроек сохраненные слова
        return await getSavedWords();
    }

}
const getCategories = async () => {
    if (isOnline.value) {
        let response = null
        try {
            response = await axios.get(Enum.API_BASE + 'api/categories')
        } catch (e) {
            return await getSavedCategory()
        }

        // Сохраняем на случай отсутствия интернетас
        await Preferences.set({
            key: 'category',
            value: JSON.stringify(response.data)
        })

        return response.data;
    } else {
        return await getSavedCategory()
    }
}

const getWordsByCategory = async (categoryIds) => {

    let result = [];
    let words = await getWords()

    for(let wordIdx in words) {

        if (categoryIds.includes(+wordIdx)) {
            result = [...result, ...words[wordIdx]]
        }
    }

    return result

}

const getSavedWords = async () => {
    let wordsStore = await Preferences.get({
        key: 'words'
    })
    return JSON.parse(wordsStore.value)
}

const getSavedCategory = async () => {
    let categoryStore = await Preferences.get({
        key: 'category'
    })
    return JSON.parse(categoryStore.value)
}

export default {
    getWords,
    getCategories,
    getWordsByCategory
}
