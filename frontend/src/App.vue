<template>
  <NavbarComponent />
  <RouterView />
</template>

<script>
import { RouterView } from 'vue-router';
import NavbarComponent from './components/app/NavbarComponent.vue';

export default {
  components: {
    NavbarComponent
  }
}
</script>

