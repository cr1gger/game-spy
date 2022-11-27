import {playSoundClick} from "@/use/Helper";

export const initDirectives = (appInstance) => {
    appInstance.directive('sound-click', {
        mounted(el) {
            let soundClick = playSoundClick();
            el.addEventListener('click', soundClick)
        }
    })
}
