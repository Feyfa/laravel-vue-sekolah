<script setup>
import { RouterLink, RouterView } from 'vue-router';
</script>

<template>
  <header v-if="showNavbar()" class="shadow fixed top-0 left-0 right-0 pl-10 pr-20 flex justify-between items-center bg-[#5AB2FF] h-12">
    <h1 class="text-2xl">SMK TAMANSISWA 2 JAKARTA</h1>
    <nav class="flex items-center">
      <RouterLink 
        class="underline flex items-center h-12 px-4 hover:text-[#F8F4E1]" 
        to="/"
        :class="{'text-[#F8F4E1]': (this.$route.path === '/')}">
        Home
      </RouterLink>
      <RouterLink 
        class="underline flex items-center h-12 px-4 hover:text-[#F8F4E1]" 
        to="/students"
        :class="{'text-[#F8F4E1]': (this.$route.path === '/students')}">
        Students
      </RouterLink>
      <span 
        @click="logout"
        class="underline flex items-center h-12 px-4 hover:text-[#F8F4E1] cursor-pointer">
        logout
      </span>
    </nav>
  </header>

  <RouterView />
</template>


<script>
export default {
  methods: {
    showNavbar() {
      return !['/register', '/login'].includes(this.$route.path);
    },

    logout() {
      this.$store.dispatch('logout')
                 .then(response => {
                  console.log(response);
                  if(response.status === 200 && response.data.message === 'logout success') {
                    localStorage.removeItem('token');
                    this.$router.push('/login');
                  }
                 })
                 .catch(error => {
                  console.error(error);
                 })
    }
  }
}
</script>

