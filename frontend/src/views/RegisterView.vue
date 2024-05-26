<template>
  <div class="w-[95%] mx-auto border-black h-screen flex justify-center items-center">

    <div v-if="alert.message" class="mini-alert border border-neutral-500 rounded shadow-lg fixed top-16 right-8 flex justify-between items-center gap-8 z-50 min-w-72 p-2.5 alert" :class="{'bg-green-500': alert.status === 'success', 'bg-red-500': alert.status === 'error'}">
      <div class="flex justify-center items-center gap-2">
        <i class="bi bi-bell"></i>
        <h2>{{ alert.message }}</h2>
      </div>
      <button type="button" @click="closeAlert">
        <i class="bi bi-x-lg"></i>
      </button>
    </div>

    <form class="border border-neutral-500 w-2/5 p-2 rounded shadow-md flex flex-col justify-center gap-3 items-center bg-zinc-50">
      <h1 class="text-2xl">Register</h1>
      
      <div class="input-container">
        <label 
          :class="{'text-red-500': registerError.name.length !== 0}"
          for="name">Name</label>
        <input 
          @blur="inputValidation('name')" 
          @keyup="inputValidation('name')"
          :class="{'border-red-500': registerError.name.length !== 0}"
          v-model="register.name" 
          class="border border-neutral-500 rounded outline-none py-2 px-2 shadow w-full" type="text" id="name" name="name" placeholder="Name">
        <small 
          class="text-red-500" 
          :class="{'hidden': registerError.name.length === 0}">{{ registerError.name }}</small>
      </div>
      
      <div class="input-container">
        <label 
          :class="{'text-red-500': registerError.email.length !== 0}"
          for="email">Email</label>
        <input 
          @blur="inputValidation('email')" 
          @keyup="inputValidation('email')"
          :class="{'border-red-500': registerError.email.length !== 0}" 
          v-model="register.email" 
          class="border border-neutral-500 rounded outline-none py-2 px-2 shadow w-full" type="email" id="email" name="email" placeholder="Email">
        <small 
          class="text-red-500" 
          :class="{'hidden': registerError.email.length === 0}">{{ registerError.email }}</small>
      </div>
      
      <div class="input-container">
        <label 
          :class="{'text-red-500': registerError.password.length !== 0}"
          for="password">Password</label>
        <input 
          @blur="inputValidation('password')" 
          @keyup="inputValidation('password')"
          :class="{'border-red-500': registerError.password.length !== 0}" 
          v-model="register.password" 
          class="border border-neutral-500 rounded outline-none py-2 px-2 shadow w-full" type="password" id="password" name="password" placeholder="Password">
        <small 
          class="text-red-500" 
          :class="{'hidden': registerError.password.length === 0}">{{ registerError.password }}</small>
      </div>
      
      <div class="w-full text-end">
        <RouterLink to="/login" class="underline font-sans text-blue-800">login</RouterLink>
      </div>
      
      <button 
        @click="registerSubmit" 
        type="button" 
        id="button-register"
        class="button-register w-full border border-neutral-500 rounded bg-zinc-100 hover:bg-zinc-200 shadow py-2"
        :class="{'opacity-70 hover:scale-100 hover:shadow-none hover:bg-gray-200': buttonRegisterDisabled}">
        Register
      </button>
    </form>
  </div>

</template>

<script>
import Swal from "sweetalert2";
import { RouterLink } from "vue-router";

export default {
  data() {
    return {
      register: {
        name: '',
        email: '',
        password: ''
      },
      registerError: {
        name: '',
        email: '',
        password: ''
      },
      alert: {
        message: '',
        status: ''
      },
      buttonRegisterDisabled: false
    }
  },

  methods: {
    inputValidation(type) {
      switch (type) {
        case 'name' : 
          this.registerError.name = this.register.name.trim() === '' ? 'name is required' : '';
          break;
        case 'email' :
          this.registerError.email = this.register.email.trim() === '' ? 'email is required' : '';
          break;
        case 'password' :
          this.registerError.password = this.register.password.trim() === '' ? 'password is required' : '';
          break;
      }
    },

    closeAlert() {
      this.alert =  {
        status: '',
        message: ''
      };
    },

    registerSubmit() {
      if(this.register.name === '' || this.register.email === '' || this.register.password === '')
      {
        if(this.register.name === '') this.registerError.name = 'name is required';
        if(this.register.email === '') this.registerError.email = 'email is required';
        if(this.register.password === '') this.registerError.password = 'password is required';
      }
      else 
      {
        this.buttonRegisterDisabled = true;
        $('#button-register').html('process...');

        this.$store.dispatch('registerSubmit',{
          name: this.register.name,
          email: this.register.email,
          password: this.register.password,
        })
        .then(response => {
          // console.log(response);
          if(response.status === 201 && response.data.message === "register success") {
            Swal.fire({
              title: response.data.message,
              icon: "success"
            })
            .then(result => {
              if(result.isConfirmed) {
                this.buttonRegisterDisabled = false;
                $('#button-register').html('Register');

                this.$router.push('/login');
              }
            });
          }
        })
        .catch(error => {
          // console.error(error);
          if(error.response.status === 422) {
            this.buttonRegisterDisabled = false;
            $('#button-register').html('Register');

            this.alert.message = error.response.data.message;
            this.alert.status = 'error';
          }
        });
      }
    }
  },
  
  watch: {
    // jika value dari variabel 'alert.message' ada perubahan maka jalankan function ini
    'alert.message': function(value) {
      // jika value ada isinya, maka tunggu sampai 3 detik, lalu ubah menjadi string kosong
      if (value) {
        setTimeout(() => {
          this.alert.message = '';
        }, 3000);
      }
    }
  }
}

</script>
