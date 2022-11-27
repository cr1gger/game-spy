<template>
  <div class="loader-container">
    <div class="loading">
      <div class="arc"></div>
      <div class="arc"></div>
      <div class="arc"></div>
    </div>
    <div class="text">Загрузка данных с сервера</div>
  </div>
</template>

<style scoped lang="scss">
.text {
  margin-top: 20px;
  font-weight: bold;
  animation: text-fade 2.5s infinite;
}
@keyframes text-fade {
  100% {
    opacity: 1;
  }
  50% {
    opacity: 0.1;
  }
  0% {
    opacity: 1;
  }
}
.loader-container {
  display: flex;
  justify-content: center;
  height: 100vh;
  align-items: center;
  flex-direction: column;
}
.loading {
  position: relative;
  width: 4rem;
  height: 4rem;
  transform-style: preserve-3d;
  perspective: 800px;

  .arc {
    position: absolute;
    content: "";
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border-bottom: 3px solid red;

    @for $i from 1 through 3 {
      &:nth-child(#{$i}) {
        animation: rotate#{$i} 1.15s linear infinite;
      }
    }

    &:nth-child(1) {
      animation-delay: -0.8s;
    }

    &:nth-child(2) {
      animation-delay: -0.4s;
    }

    &:nth-child(3) {
      animation-delay: 0s;
    }
  }
}

@keyframes rotate1 {
  from {
    transform: rotateX(35deg) rotateY(-45deg) rotateZ(0);
  }

  to {
    transform: rotateX(35deg) rotateY(-45deg) rotateZ(1turn);
  }
}

@keyframes rotate2 {
  from {
    transform: rotateX(50deg) rotateY(10deg) rotateZ(0);
  }

  to {
    transform: rotateX(50deg) rotateY(10deg) rotateZ(1turn);
  }
}

@keyframes rotate3 {
  from {
    transform: rotateX(35deg) rotateY(55deg) rotateZ(0);
  }

  to {
    transform: rotateX(35deg) rotateY(55deg) rotateZ(1turn);
  }
}


</style>
