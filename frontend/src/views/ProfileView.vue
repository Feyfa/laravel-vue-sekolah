<template>
  <div class="mt-16 w-[95%] mx-auto">

    <div>
      <h1 class="text-center font-medium text-3xl">{{ user.name }}</h1>
    </div>

    <div class="flex justify-end items-center gap-4">
      <button 
        @click="isEdit = true" 
        :class="{'hidden': isEdit}">
        <i class="bi bi-pencil"></i>
      </button>

      <button 
        @click="updateUser" 
        :class="{'hidden': !isEdit}">
        <i class="bi bi-check-circle"></i>
      </button>

      <button 
        @click="cancelEdit" 
        :class="{'hidden': !isEdit}">
        <i class="bi bi-x-circle"></i>
      </button>
    </div>

    <div class="grid grid-cols-4 items-start gap-y-4 gap-x-8">
      <div class="input-container flex flex-col w-full">
        <label 
          for="name" 
          :class="{'text-red-500': userUpdateError.name.length !== 0}">
          Name
        </label>
        <input
          placeholder="name" 
          id="name" 
          type="text" 
          class="border w-full border-neutral-500 rounded outline-none py-1 px-1.5 shadow" 
          v-model="user.name" 
          :class="{'border-red-500': userUpdateError.name.length !== 0}" 
          :readonly="!isEdit"
          @blur="inputValidation('name')" 
          @keyup="inputValidation('name')">
        <small 
          class="text-red-500" 
          :class="{'hidden': userUpdateError.name.length === 0}">
          {{ userUpdateError.name }}
        </small>
      </div>

      <div class="input-container flex flex-col w-full">
        <label 
          for="email" 
          :class="{'text-red-500': userUpdateError.email.length !== 0}">
          Email
        </label>
        <input
          placeholder="email" 
          id="email" 
          type="email" 
          class="border w-full border-neutral-500 rounded outline-none py-1 px-1.5 shadow" 
          v-model="user.email" 
          :class="{'border-red-500': userUpdateError.email.length !== 0}" 
          :readonly="!isEdit"
          @blur="inputValidation('email')" 
          @keyup="inputValidation('email')">
        <small 
          class="text-red-500" 
          :class="{'hidden': userUpdateError.email.length === 0}">
          {{ userUpdateError.email }}
        </small>
      </div>

      <div class="input-container flex flex-col w-full">
        <label 
          for="mail_mailer">
          Mail Mailer
        </label>
        <input
          placeholder="Mail Mailer" 
          id="mail_mailer" 
          type="text" 
          class="border w-full border-neutral-500 rounded outline-none py-1 px-1.5 shadow" 
          v-model="user.mail_mailer"
          :readonly="!isEdit">
      </div>

      <div class="input-container flex flex-col w-full">
        <label 
          for="mail_host" >
          Mail Host
        </label>
        <input
          placeholder="Mail Host" 
          id="mail_host" 
          type="text" 
          class="border w-full border-neutral-500 rounded outline-none py-1 px-1.5 shadow" 
          v-model="user.mail_host" 
          :readonly="!isEdit">
      </div>

      <div class="input-container flex flex-col w-full">
        <label 
          for="mail_port">
          Mail Port
        </label>
        <input
          placeholder="Mail Port" 
          id="mail_port" 
          type="text" 
          class="border w-full border-neutral-500 rounded outline-none py-1 px-1.5 shadow" 
          v-model="user.mail_port"  
          :readonly="!isEdit">
      </div>

      <div class="input-container flex flex-col w-full">
        <label 
          for="mail_password">
          Mail Password
        </label>
        <input
          placeholder="Mail Password" 
          id="mail_password" 
          type="text" 
          class="border w-full border-neutral-500 rounded outline-none py-1 px-1.5 shadow" 
          v-model="user.mail_password" 
          :readonly="!isEdit">
      </div>

      <div class="input-container flex flex-col w-full">
        <label 
          for="mail_encryption">
          Mail Encryption
        </label>
        <input
          placeholder="Mail Encryption" 
          id="mail_encryption" 
          type="text" 
          class="border w-full border-neutral-500 rounded outline-none py-1 px-1.5 shadow" 
          v-model="user.mail_encryption"
          :readonly="!isEdit">
      </div>
    </div>
  </div>
</template>

<script>
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      user: {
        id: '',
        name: '',
        email: '',
        mail_mailer: '',
        mail_host: '',
        mail_port: '',
        mail_username: '',
        mail_password: '',
        mail_encryption: '',
      },
      userUpdateError: {
        name: '',
        email: '',
      },
      isEdit: false
    }
  },

  mounted() {
    this.user = JSON.parse(localStorage.getItem('user'));
  },

  methods: {
    inputValidation(type) {
      switch (type) {
        case 'name' : 
          this.userUpdateError.name = this.user.name.trim() === '' ? 'name is required' : '';
          break;
        case 'email' :
          this.userUpdateError.email = this.user.email.trim() === '' ? 'email is required' : '';
          break;
      }
    },

    updateUser() {
      if(this.user.name === '' || this.user.email === '')
      {
        if(this.user.name === '') this.userUpdateError.name = 'name is required';
        if(this.user.email === '') this.userUpdateError.email = 'email is required';
      }
      else 
      {
        this.$store.dispatch('updateUser', {
          id: this.user.id,
          name: this.user.name,
          email: this.user.email,
          mail_mailer: this.user.mail_mailer,
          mail_host: this.user.mail_host,
          mail_port: this.user.mail_port,
          mail_password: this.user.mail_password,
          mail_encryption: this.user.mail_encryption,
        })
        .then(response => {
          console.log(response);
          if(response.status === 200) {
            this.isEdit = false;
            this.$alert({
              status: 'success',
              message: response.data.message
            })
            localStorage.setItem('user', JSON.stringify(response.data.user));
          }
        })
        .catch(error => {
          console.error(error);
        });
      }
    },

    cancelEdit() {
      this.isEdit = false;
      this.user = JSON.parse(localStorage.getItem('user'));
      this.userUpdateError = {
        name: '',
        email: '',
      };
    }
  },
}
</script>