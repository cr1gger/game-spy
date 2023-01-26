<template>
  <MainGame />
</template>

<script>
import { defineComponent } from 'vue';

// Components
import MainGame from '../components/MainGame.vue';

export default defineComponent({
  name: 'HomeView',

  components: {
    MainGame,
  },
});
</script>
