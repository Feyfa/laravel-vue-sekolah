<template>
  <div class="mt-16 w-[95%] mx-auto">

    <div>
      <h1 class="text-center font-medium text-3xl">{{ user.name }}</h1>
    </div>
    
    <!-- user setting -->
    <div class="border bg-neutral-50 border-neutral-400 shadow-md p-5 rounded mt-5">
      <h3 class="text-xl text-center">User Setting</h3>

      <div class="flex justify-end items-center gap-4">
        <button 
          v-if="!isEdit.user"
          @click="isEdit.user = true">
          <i class="bi bi-pencil"></i>
        </button>
  
        <button 
          v-if="isEdit.user"
          @click="updateUser">
          <i class="bi bi-check-circle"></i>
        </button>
  
        <button 
          v-if="isEdit.user && !loading.user"
          @click="cancelEditUser">
          <i class="bi bi-x-circle"></i>
        </button>

        <div role="status" v-if="loading.user">
            <svg aria-hidden="true" class="w-[1.1rem] h-[1.1rem] text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
            <span class="sr-only">Loading...</span>
        </div>
      </div>
  
      <div class="grid grid-cols-3 items-start gap-y-4 gap-x-8">
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
            :readonly="!isEdit.user"
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
            for="jenis-kelamin">
            Jenis Kelamin
          </label>
          <select 
            id="jenis-kelamin" 
            class="border w-full border-neutral-500 rounded outline-none py-[0.42rem] px-1.5 shadow" 
            v-model="user.jenis_kelamin" 
            :disabled="!isEdit.user">
            <option value="Laki-Laki">Laki-Laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
        </div>
  
        <div class="input-container flex flex-col w-full">
          <label 
            for="jabatan">
            Jabatan
          </label>
          <select 
            id="jabatan" 
            class="border w-full border-neutral-500 rounded outline-none py-[0.42rem] px-1.5 shadow" 
            v-model="user.jabatan" 
            :disabled="!isEdit.user">
            <option value="Guru Kelas 1">Guru Kelas 1</option>
            <option value="Guru Kelas 2">Guru Kelas 2</option>
            <option value="Guru Kelas 3">Guru Kelas 3</option>
            <option value="Guru Kelas 4">Guru Kelas 4</option>
            <option value="Guru Kelas 5">Guru Kelas 5</option>
            <option value="Guru Kelas 6">Guru Kelas 6</option>
          </select>
        </div>

        <div class="input-container flex flex-col w-full">
          <label 
            for="tanggal-lahir">
            Tanggal Lahir
          </label>
          <input 
            type="date" 
            id="tanggal-lahir"
            class="border w-full border-neutral-500 rounded outline-none py-1 px-1.5 shadow" 
            v-model="user.tanggal_lahir" 
            :readonly="!isEdit.user">
        </div>
  
        <div class="input-container flex flex-col w-full">
          <label 
            for="alamat">
            Alamat
          </label>
          <input 
            type="text" 
            id="alamat"
            class="border w-full border-neutral-500 rounded outline-none py-1 px-1.5 shadow" 
            v-model="user.alamat" 
            :readonly="!isEdit.user">
        </div>
  
        <div class="input-container flex flex-col w-full">
          <label 
            for="pendidikan">
            Pendidikan
          </label>
          <input 
            type="text" 
            id="pendidikan"
            class="border w-full border-neutral-500 rounded outline-none py-1 px-1.5 shadow" 
            v-model="user.pendidikan" 
            :readonly="!isEdit.user">
        </div>
      </div>
    </div>
    <!-- user setting -->

    <!-- email setting -->
    <div class="border bg-neutral-50 border-neutral-400 shadow-md p-5 rounded mt-10">
      <h3 class="text-xl text-center">Email Setting</h3>
      <small
        v-if="isEdit.email"
        class="text-center block">
        save will send the message to the email you set
      </small>

      <div class="flex justify-end items-center gap-4">
        <button 
          v-if="!isEdit.email"
          @click="isEdit.email = true">
          <i class="bi bi-pencil"></i>
        </button>
  
        <button 
          v-if="isEdit.email"
          @click="updateEmail">
          <i class="bi bi-check-circle"></i>
        </button>
  
        <button 
          v-if="isEdit.email && !loading.email"
          @click="cancelEditEmail">
          <i class="bi bi-x-circle"></i>
        </button>

        <div role="status" v-if="loading.email">
            <svg aria-hidden="true" class="w-[1.1rem] h-[1.1rem] text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
            <span class="sr-only">Loading...</span>
        </div>
      </div>
  
      <div class="grid grid-cols-3 items-start gap-y-4 gap-x-8">  
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
            :readonly="!isEdit.email"
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
            :readonly="!isEdit.email">
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
            :readonly="!isEdit.email">
        </div>
  
        <div class="input-container flex flex-col w-full">
          <label 
            for="mail_port">
            Mail Port
          </label>
          <input
            placeholder="Mail Port" 
            id="mail_port" 
            type="number" 
            min="1"
            class="border w-full border-neutral-500 rounded outline-none py-1 px-1.5 shadow" 
            v-model="user.mail_port"  
            :readonly="!isEdit.email">
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
            :readonly="!isEdit.email">
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
            :readonly="!isEdit.email">
        </div>
      </div>
    </div>
    <!-- email setting -->

  </div>
</template>

<script>
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      user: {
        id: '',
        img: '',
        jenis_kelamin: '',
        tanggal_lahir: '',
        jabatan: '',
        alamat: '',
        pendidikan: '',
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
      isEdit: {
        user: false,
        email: false,
      },
      loading: {
        user: false,
        email: false,
      }
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
      if(this.user.name === '')
      {
        this.userUpdateError.name = 'name is required';
      }
      else 
      {
        this.loading.user = true;
        this.$store.dispatch('updateUser', {
          id: this.user.id,
          name: this.user.name,
          jenis_kelamin: this.user.jenis_kelamin,
          jabatan: this.user.jabatan,
          tanggal_lahir: this.user.tanggal_lahir,
          alamat: this.user.alamat,
          pendidikan: this.user.pendidikan,
        })
        .then(response => {
          console.log(response);
          if(response.status === 200) {
            this.isEdit.user = false;
            this.loading.user = false;
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

    cancelEditUser() {
      this.isEdit.user = false;

      this.user.name = this.$store.getters.user.name;
      this.user.jenis_kelamin = this.$store.getters.user.jenis_kelamin;
      this.user.jabatan = this.$store.getters.user.jabatan;
      this.user.tanggal_lahir = this.$store.getters.user.tanggal_lahir;
      this.user.alamat = this.$store.getters.user.alamat;
      this.user.pendidikan = this.$store.getters.user.pendidikan;

      this.userUpdateError.name = "";
    },

    updateEmail() {
      if(this.user.email === '')
      {
        this.userUpdateError.email = 'email is required';
      }
      else 
      {
        this.loading.email = true;
        this.$store.dispatch('updateEmail', {
          id: this.user.id,
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
            this.isEdit.email = false;
            this.loading.email = false;
            this.$alert({
              status: 'success',
              message: response.data.message
            })
            localStorage.setItem('user', JSON.stringify(response.data.user));
          }
        })
        .catch(error => {
          console.error(error);
          this.loading.email = false;
          Swal.fire({
              text: error.response.data.message,
              icon: "error",
              confirmButtonColor: '#3085d6',
              width: '80%',
            })
        });
      }
    },

    cancelEditEmail() {
      this.isEdit.email = false;
      
      this.user.email = this.$store.getters.user.email;
      this.user.mail_mailer = this.$store.getters.user.mail_mailer;
      this.user.mail_host = this.$store.getters.user.mail_host;
      this.user.mail_port = this.$store.getters.user.mail_port;
      this.user.mail_password = this.$store.getters.user.mail_password;
      this.user.mail_encryption = this.$store.getters.user.mail_encryption;
    
      this.userUpdateError.email = "";
    },

    inputTypeDateValidation(type) {
      const lastChar = this.user.mail_port.slice(-1);
      
      if(type === 'integer') {
        if (/\D/.test(lastChar)) {
          this.user.mail_port = this.user.mail_port.slice(0, -1);
        }
      }
      
    }
  },
}
</script>