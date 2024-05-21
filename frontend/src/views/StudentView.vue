<template>
  <div class="mt-20">

    <!-- alert custom -->
    <div v-if="alert.message" class="border border-neutral-500 rounded shadow-lg fixed top-20 right-8 flex justify-between items-center gap-8 z-50 min-w-72 p-2.5 alert" :class="{'bg-green-500': alert.status === 'success', 'bg-red-500': alert.status === 'error'}">
      <div class="flex justify-center items-center gap-2">
        <i class="bi bi-bell"></i>
        <h2>{{ alert.message }}</h2>
      </div>
      <button type="button" @click="closeAlert">
        <i class="bi bi-x-lg"></i>
      </button>
    </div>
    <!-- alert custom -->



    <!-- form untuk menambahkan student -->
    <form class="w-[95%] mx-auto mb-5" @submit.prevent="">
      <div class="text-end mb-2">
        <button 
          type="submit" 
          class="w-24 py-1 bg-gray-200 border border-neutral-300 rounded shadow-sm transition-all duration-100 ease-in-out hover:bg-gray-300 hover:scale-105 hover:shadow"
          @click="isClickButtonTambah = true">
          Tambah
        </button>
      </div>
      
      <div class="rounded overflow-hidden h-0 transition-all duration-100 ease-in-out" :class="{'h-36 p-2 shadow border border-neutral-200': isClickButtonTambah}">
        <div class="flex justify-between items-start gap-5 mb-2">
          <div class="input-container flex flex-col w-full">
            <label for="nama" :class="{'text-red-500': studentAddError.nama.length !== 0}">Nama</label>
            <input placeholder="nama" id="nama" type="text" class="border border-neutral-500 rounded outline-none py-1 px-1.5" v-model="studentAdd.nama" :class="{'border-red-500': studentAddError.nama.length !== 0}" @blur="inputValidation('nama')" @keyup="inputValidation('nama')">
            <small class="text-red-500" :class="{'hidden': studentAddError.nama.length === 0}">{{ studentAddError.nama }}</small>
          </div>
          <div class="input-container flex flex-col w-full">
            <label for="email" :class="{'text-red-500': studentAddError.email.length !== 0}">Email</label>
            <input placeholder="email" id="email"type="email" class="border border-neutral-500 rounded outline-none py-1 px-1.5" v-model="studentAdd.email" :class="{'border-red-500': studentAddError.email.length !== 0}" @blur="inputValidation('email')" @keyup="inputValidation('email')">
            <small class="text-red-500" :class="{'hidden': studentAddError.email.length === 0}">{{ studentAddError.email }}</small>
          </div>
          <div class="input-container flex flex-col w-full">
            <label for="tanggal_lahir" :class="{'text-red-500': studentAddError.tanggal_lahir.length !== 0}">Tanggal Lahir</label>
            <input id="tanggal_lahir" type="date" class="border border-neutral-500 rounded outline-none py-1 px-1.5" v-model="studentAdd.tanggal_lahir" :class="{'border-red-500': studentAddError.tanggal_lahir.length !== 0}" @blur="inputValidation('tanggal_lahir')" @change="inputValidation('tanggal_lahir')">
            <small class="text-red-500" :class="{'hidden': studentAddError.tanggal_lahir.length === 0}">{{ studentAddError.tanggal_lahir }}</small>
          </div>
          <div class="input-container flex flex-col w-full">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <select name="" id="jenis_kelamin" class="border border-neutral-500 rounded outline-none py-[.48rem] px-1.5" v-model="studentAdd.jenis_kelamin">
              <option value="Laki-Laki">Laki-Laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>  
          <div class="input-container flex flex-col w-full">
            <label for="kelas">Kelas</label>
            <select name="" id="kelas" class="border border-neutral-500 rounded outline-none py-[.48rem] px-1.5" v-model="studentAdd.kelas">
              <option value="Satu">Satu</option>
              <option value="Dua">Dua</option>
              <option value="Tiga">Tiga</option>
              <option value="Empat">Empat</option>
              <option value="Lima">Lima</option>
              <option value="Enam">Enam</option>
            </select>
          </div>
        </div>
        <div class="flex justify-end items-center gap-7">
          <button type="button" class="w-24 py-1 bg-gray-200 border border-neutral-300 rounded shadow-sm transition-all duration-100 ease-in-out hover:bg-gray-300 hover:scale-105 hover:shadow" @click="cancelAddStudent">Cancel</button>
          <button type="button" id="button-save"class="w-24 py-1 bg-gray-200 border border-neutral-300 rounded shadow-sm transition-all duration-100 ease-in-out hover:bg-gray-300 hover:scale-105 hover:shadow" :class="{'opacity-70 hover:scale-100 hover:shadow-none hover:bg-gray-200': buttonSaveDisabled}" @click="addStudent" :disabled="buttonSaveDisabled">Save</button>
        </div>
      </div>
    </form>
    <!-- form untuk menambahkan student -->



    <!-- table untuk menampilkan student -->
    <table class="w-[95%] mx-auto bg-[rgb(253,253,253)] shadow border border-neutral-200 mb-5">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>Tanggal Lahir</th>
          <th>Jenis Kelamin</th>
          <th>Kelas</th>
          <th>Created</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(student, index) in students">
          <td>
            <input 
              required 
              type="text" 
              v-model="students[index].nama"
              class="outline-none w-full"
              :readonly="!(rowEdit === index)" 
              :class="{'border border-neutral-500 bg-white shadow-md rounded py-1 px-1.5': rowEdit === index}">
            <small class="text-red-500 hidden">error nanme</small>
          </td>
          <td>
            <input 
              required 
              type="email" 
              v-model="students[index].email"
              class="outline-none w-full"
              :readonly="!(rowEdit === index)" 
              :class="{'border border-neutral-500 bg-white shadow-md rounded py-1 px-1.5': rowEdit === index}">
            <small class="text-red-500 hidden">error nanme</small>
          </td>
          <td>
            <input 
              required 
              type="date" 
              v-model="students[index].tanggal_lahir"
              class="outline-none w-full"
              :readonly="!(rowEdit === index)" 
              :class="{'border border-neutral-500 bg-white shadow-md rounded py-1 px-1.5': rowEdit === index}">
            <small class="text-red-500 hidden">error nanme</small>
          </td>
          <td>
            <select 
              required 
              v-model="students[index].jenis_kelamin"
              class="outline-none w-full"
              :disabled="!(rowEdit === index)" 
              :class="{'border border-neutral-500 bg-white shadow-md rounded py-[.48rem] px-1.5': rowEdit === index}">
              <option value="Laki-Laki">Laki-Laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
            <small class="text-red-500 hidden">error nanme</small>
          </td>
          <td>
            <select 
              required 
              v-model="students[index].kelas"
              class="outline-none w-full"
              :disabled="!(rowEdit === index)" 
              :class="{'border border-neutral-500 bg-white shadow-md rounded py-[.48rem] px-1.5': rowEdit === index}">
              <option value="Satu">Satu</option>
              <option value="Dua">Dua</option>
              <option value="Tiga">Tiga</option>
              <option value="Empat">Empat</option>
              <option value="Lima">Lima</option>
              <option value="Enam">Enam</option>
            </select>
            <small class="text-red-500 hidden">error nanme</small>
          </td>
          <td>{{ student.created_at }}</td>
          <td>
            <div class="flex items-center justify-center gap-4">
              <button 
                @click="rowEditActive(index, student.id)" 
                :class="{'hidden': rowEdit === index}">
                <i class="bi bi-pencil"></i>
              </button>

              <form 
                @submit.prevent="deleteStudent(student.id)" 
                class="cursor-pointer" 
                :class="{'hidden': rowEdit === index}">
                <button type="submit">
                  <i class="bi bi-trash3"></i>
                </button>
              </form>

              <button 
                @click="updateStudent(index)" 
                :class="{'hidden': rowEdit !== index}">
                <i class="bi bi-check-circle"></i>
              </button>

              <button 
                @click="cancelEdit(index)" 
                :class="{'hidden': rowEdit !== index}">
                <i class="bi bi-x-circle"></i>
              </button>
            </div>
          </td>
        </tr>

        <tr v-if="students.length < 1">
          <td colspan="7">
            <h1 class="text-center">Student Kosong...</h1>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- table untuk menampilkan student -->

  </div>
</template>

<script>

export default {
  data() {
    return {
      isClickButtonTambah: false,
      alert: {
        status: '',
        message: ''
      },
      studentAdd: {
        nama: '',
        email: '',
        tanggal_lahir: '',
        jenis_kelamin: 'Laki-Laki',
        kelas: 'Satu',
      },
      studentAddError: {
        nama: '',
        email: '',
        tanggal_lahir: '',
      },
      students: [],
      rowEdit: null,
      studentBuffer: {},
      buttonSaveDisabled: false,
    }
  },

  mounted() {
    this.getStudents();
  },

  methods: {
    inputValidation(type) {
      switch (type) {
        case 'nama' : 
          this.studentAddError.nama = this.studentAdd.nama.trim() === '' ? 'nama is required' : '';
          break;
        case 'email' :
          this.studentAddError.email = this.studentAdd.email.trim() === '' ? 'email is required' : '';
          break;
        case 'tanggal_lahir' :
          this.studentAddError.tanggal_lahir = this.studentAdd.tanggal_lahir.trim() === '' ? 'tanggal lahir is required' : '';
          break;
      }
    },

    cancelAddStudent() {
      this.studentAdd =  {
        nama: '',
        email: '',
        tanggal_lahir: '',
        jenis_kelamin: 'Laki-Laki',
        kelas: 'Satu',
      };

      this.studentAddError =  {
        nama: '',
        email: '',
        tanggal_lahir: '',
      },
      this.isClickButtonTambah = false;
    },

    setAlertMessage(status, message) {
      this.alert.status = status;
      this.alert.message = message;
    },

    closeAlert() {
      this.alert =  {
        status: '',
        message: ''
      };
    },

    // untuk mendapatkan semua data students
    getStudents() {
      this.$store.dispatch('getStudents')
                 .then(response => {
                  this.students = response.data.students;
                  // console.log(this.students);
                 })
                 .catch(error => {
                  console.error(error);
                 });
    },

    // untuk clear input form saat manambahkan student
    clearInputForm(){
      this.studentAdd.nama = '';
      this.studentAdd.email = '';
      this.studentAdd.tanggal_lahir = '';
      this.studentAdd.jenis_kelamin = 'Laki-Laki';
      this.studentAdd.kelas = 'Satu';
    },

    // operasi untuk menambahkan student
    addStudent() {
      if(this.studentAdd.nama === '' || this.studentAdd.email === '' || this.studentAdd.tanggal_lahir === '')
      {
        if(this.studentAdd.nama === '') this.studentAddError.nama = 'nama is required';
        if(this.studentAdd.email === '') this.studentAddError.email = 'email is required';
        if(this.studentAdd.tanggal_lahir === '') this.studentAddError.tanggal_lahir = 'tanggal lahir is required';
      }
      else
      {
        this.buttonSaveDisabled = true;
        $('#button-save').html('process...');

        this.$store.dispatch('addStudent', {
          nama: this.studentAdd.nama,
          email: this.studentAdd.email,
          tanggal_lahir: this.studentAdd.tanggal_lahir,
          jenis_kelamin: this.studentAdd.jenis_kelamin,
          kelas: this.studentAdd.kelas,
        })
        .then(response => {
          if(response.data.status === 200 && response.data.message === 'Student Add Successfully') {
            this.buttonSaveDisabled = false;
            $('#button-save').html('Save');

            this.isClickButtonTambah = false;
            this.clearInputForm();
            this.getStudents();
            this.setAlertMessage('success', response.data.message);
          }
        })
        .catch(error => {
          this.buttonSaveDisabled = false;
          $('#button-save').html('Save');
          this.setAlertMessage('error', error.response.data.message.email[0]);
        });
      }

    },

    // ini operasi, jika icon pencil di klik
    rowEditActive(index, id) {
      this.rowEdit = index;
    }, 

    // ini operasi, jika icon close di klik
    cancelEdit(index) {
      this.rowEdit = null;
      this.getStudents();
    },

    // untuk update student
    updateStudent(index) {
      this.$store.dispatch('updateStudent', {
        id: this.students[index].id,
        nama: this.students[index].nama,
        email: this.students[index].email,
        tanggal_lahir: this.students[index].tanggal_lahir,
        jenis_kelamin: this.students[index].jenis_kelamin,
        kelas: this.students[index].kelas,
      })
      .then(response => {
        if(response.data.status === 200 && response.data.message === 'Student Update Successfully') {
          this.rowEdit = null;
          this.getStudents();
          this.setAlertMessage(response.data.message);
        }
      })
      .catch(error => {
        console.error(error);
      });
    },  

    // untuk delete student
    deleteStudent(id) {
      this.$store.dispatch('deleteStudent', {
        id
      })
      .then(response => {
        if(response.data.status === 200 && response.data.message === 'Student Delete Successfully') {
          this.students = this.students.filter(student => student.id !== id);
          this.setAlertMessage(response.data.message);
        }
      })
      .catch(error => {
        console.error(error);
      });
    }
    
  },
}

</script>