<template>
  <div class="mt-16 w-[95%] mx-auto">

    <!-- alert custom -->
    <div v-if="alert.message" class="border border-neutral-500 rounded shadow-lg fixed top-16 right-8 flex justify-between items-center gap-8 z-50 min-w-72 p-2.5 alert" :class="{'bg-green-500': alert.status === 'success', 'bg-red-500': alert.status === 'error'}">
      <div class="flex justify-center items-center gap-2">
        <i class="bi bi-bell"></i>
        <h2>{{ alert.message }}</h2>
      </div>
      <button type="button" @click="closeAlert">
        <i class="bi bi-x-lg"></i>
      </button>
    </div>
    <!-- alert custom -->



    <div class="w-full flex justify-between items-start mb-2">
      <div :style="{visibility: students.data.length < 1 ? 'hidden' : 'visible' }">
        <div>
          <button 
            v-if="students.current_page > 1" 
            class="border border-neutral-500 cursor-pointer hover:bg-neutral-300 w-10 py-1 text-center"
            @click="setCurrentPage('prev')">
            <<
          </button>
          <!-- <button 
            class="border border-neutral-500 cursor-pointer hover:bg-neutral-300 w-10 py-1 text-center" 
            v-for="(i, index) in students.last_page" :class="{'bg-neutral-300': i === students.current_page}"
            @click="setCurrentPage('', i)">
            {{ i }}
          </button> -->
          <button 
            class="border border-neutral-500 cursor-pointer hover:bg-neutral-300 w-10 py-1 text-center" 
            :class="{
              'bg-neutral-300': getPage(1) === students.current_page,
              'hidden': getPage(1) > students.last_page
            }"
            @click="setCurrentPage('', getPage(1))">
            {{ getPage(1) }}
          </button>
          <button 
            class="border border-neutral-500 cursor-pointer hover:bg-neutral-300 w-10 py-1 text-center" 
            :class="{
              'bg-neutral-300': getPage(2) === students.current_page,
              'hidden': getPage(2) > students.last_page
            }"
            @click="setCurrentPage('', getPage(2))">
            {{ getPage(2) }}
          </button>
          <button 
            class="border border-neutral-500 cursor-pointer hover:bg-neutral-300 w-10 py-1 text-center" 
            :class="{
              'bg-neutral-300': getPage(3) === students.current_page,
              'hidden': getPage(3) > students.last_page
            }"
            @click="setCurrentPage('', getPage(3))">
            {{ getPage(3) }}
          </button>
          <button 
            v-if="students.current_page !== students.last_page" 
            class="border border-neutral-500 cursor-pointer hover:bg-neutral-300 w-10 py-1 text-center"
            @click="setCurrentPage('next')">
            >>
          </button>
        </div>
        <div>
          <small>Showing {{ students.current_page }} To {{ students.last_page }} Of {{ students.total }} Entries</small>
        </div>
      </div>
      <input 
        placeholder="seacrh"
        type="text" 
        class="border border-neutral-500 rounded outline-none py-1 px-1.5 shadow"
        @keyup.enter="searchStudent">
      <button 
        type="submit" 
        class="w-24 py-1 bg-gray-200 border border-neutral-300 rounded shadow-sm transition-all duration-100 ease-in-out hover:bg-gray-300 hover:scale-105 hover:shadow"
        @click="isClickButtonTambah = true">
        Tambah
      </button>
    </div>

    <!-- form untuk menambahkan student -->
    <form class="w-full mb-5 rounded overflow-hidden h-0 transition-all duration-300 ease-in-out" :class="{'h-36 p-2 shadow border border-neutral-200': isClickButtonTambah}" @submit.prevent="">
      <div class="flex justify-between items-start gap-5 mb-2">
        <div class="input-container flex flex-col w-full">
          <label for="nama" :class="{'text-red-500': studentAddError.nama.length !== 0}">Nama</label>
          <input placeholder="nama" id="nama" type="text" class="border border-neutral-500 rounded outline-none py-1 px-1.5 shadow" v-model="studentAdd.nama" :class="{'border-red-500': studentAddError.nama.length !== 0}" @blur="inputValidation('nama')" @keyup="inputValidation('nama')">
          <small class="text-red-500" :class="{'hidden': studentAddError.nama.length === 0}">{{ studentAddError.nama }}</small>
        </div>
        <div class="input-container flex flex-col w-full">
          <label for="email" :class="{'text-red-500': studentAddError.email.length !== 0}">Email</label>
          <input placeholder="email" id="email"type="email" class="border border-neutral-500 rounded outline-none py-1 px-1.5 shadow" v-model="studentAdd.email" :class="{'border-red-500': studentAddError.email.length !== 0}" @blur="inputValidation('email')" @keyup="inputValidation('email')">
          <small class="text-red-500" :class="{'hidden': studentAddError.email.length === 0}">{{ studentAddError.email }}</small>
        </div>
        <div class="input-container flex flex-col w-full">
          <label for="tanggal_lahir" :class="{'text-red-500': studentAddError.tanggal_lahir.length !== 0}">Tanggal Lahir</label>
          <input id="tanggal_lahir" type="date" class="border border-neutral-500 rounded outline-none py-1 px-1.5 shadow" v-model="studentAdd.tanggal_lahir" :class="{'border-red-500': studentAddError.tanggal_lahir.length !== 0}" @blur="inputValidation('tanggal_lahir')" @change="inputValidation('tanggal_lahir')">
          <small class="text-red-500" :class="{'hidden': studentAddError.tanggal_lahir.length === 0}">{{ studentAddError.tanggal_lahir }}</small>
        </div>
        <div class="input-container flex flex-col w-full">
          <label for="jenis_kelamin">Jenis Kelamin</label>
          <select name="" id="jenis_kelamin" class="border border-neutral-500 rounded outline-none py-[.48rem] px-1.5 shadow" v-model="studentAdd.jenis_kelamin">
            <option value="Laki-Laki">Laki-Laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
        </div>  
        <div class="input-container flex flex-col w-full">
          <label for="kelas">Kelas</label>
          <select name="" id="kelas" class="border border-neutral-500 rounded outline-none py-[.48rem] px-1.5 shadow" v-model="studentAdd.kelas">
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
        <button type="button" id="button-save" class="w-24 py-1 bg-gray-200 border border-neutral-300 rounded shadow-sm transition-all duration-100 ease-in-out hover:bg-gray-300 hover:scale-105 hover:shadow" :class="{'opacity-70 hover:scale-100 hover:shadow-none hover:bg-gray-200': buttonSaveDisabled}" @click="addStudent" :disabled="buttonSaveDisabled">Save</button>
      </div>
    </form>
    <!-- form untuk menambahkan student -->

    <div>

    </div>


    <!-- table untuk menampilkan student -->
    <table class="w-full bg-[rgb(253,253,253)] shadow border border-neutral-400 mb-5">
      <thead>
        <tr class="bg-green-500">
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
        
        <tr v-for="(student, index) in students.data">
          <td>
            <input 
              required 
              type="text" 
              v-model="students.data[index].nama"
              class="outline-none w-full"
              :readonly="!(rowEdit === index)" 
              :class="{'border border-neutral-500 bg-white shadow-md rounded py-1 px-1.5': rowEdit === index}">
          </td>
          <td>
            <input 
              required 
              type="email" 
              v-model="students.data[index].email"
              class="outline-none w-full"
              :readonly="!(rowEdit === index)" 
              :class="{'border border-neutral-500 bg-white shadow-md rounded py-1 px-1.5': rowEdit === index}">
          </td>
          <td>
            <input 
              required 
              type="date" 
              v-model="students.data[index].tanggal_lahir"
              class="outline-none w-full"
              :readonly="!(rowEdit === index)" 
              :class="{'border border-neutral-500 bg-white shadow-md rounded py-1 px-1.5': rowEdit === index}">
          </td>
          <td>
            <select 
              required 
              v-model="students.data[index].jenis_kelamin"
              class="outline-none w-full"
              :disabled="!(rowEdit === index)" 
              :class="{'border border-neutral-500 bg-white shadow-md rounded py-[.48rem] px-1.5': rowEdit === index}">
              <option value="Laki-Laki">Laki-Laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </td>
          <td>
            <select 
              required 
              v-model="students.data[index].kelas"
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

        <tr v-if="students.data.length < 1">
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
import Swal from 'sweetalert2';

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
      students: {
        data: [],
        // page saat ini
        current_page: 1,
        // akhir dari page
        last_page: 0,
        // banyak page dalam 1 halaman, dalam hal ini ada 3
        // jadi bentuknya pagenya akan seperti ini
        // 1 2 3
        // 4 5 6
        // 7 8 9
        // dan seterusnya
        limit_page: 3,
        // ini adalah posisi page per limit pagenya, maksudnya gini
        // kan bentuk page itu akan seprti ini ya
        // 1 2 3 -> position_page_per_limit_page = 1
        // 4 5 6 -> position_page_per_limit_page = 2
        // 7 8 9 -> position_page_per_limit_page = 3
        position_page_per_limit_page: 1,
        total: 0
      },
      keyword: '',
      studentBuffer: {},
      rowEdit: null,
      buttonSaveDisabled: false,
    }
  },

  mounted() {
    this.getStudents();
  },

  methods: {
    getPage(buttonPosition) { 
      return (this.students.limit_page * (this.students.position_page_per_limit_page - 1)) + buttonPosition;
    },

    setCurrentPage(action, page) {
      if(action === 'prev') {
        if(this.students.current_page > 1) {
          this.students.current_page--;
          this.students.position_page_per_limit_page = Math.ceil(this.students.current_page / this.students.limit_page);
          this.getStudents();
          this.rowEdit = null;
          this.isClickButtonTambah = false;
        }
      }
      else if(action === 'next') {
        if(this.students.current_page < this.students.last_page) {
          this.students.current_page++;
          this.students.position_page_per_limit_page = Math.ceil(this.students.current_page / this.students.limit_page);
          console.log({
            position_page_per_limit_page: this.students.position_page_per_limit_page,
            limit_page: this.students.limit_page,
            current_page: this.students.current_page,
        });
          this.getStudents();
          this.rowEdit = null;
          this.isClickButtonTambah = false;
        }
      }
      else {
        this.students.current_page = page;
        this.students.position_page_per_limit_page = Math.ceil(this.students.current_page / this.students.limit_page);
        this.getStudents();
        this.rowEdit = null;
        this.isClickButtonTambah = false;
      }
    },

    searchStudent(event) {
      this.keyword = event.target.value;
      this.students.current_page = 1;
      this.getStudents();
    },

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
      this.$store.dispatch('getStudents',{
        current_page: this.students.current_page,
        keyword: this.keyword
      }).then(response => {
        this.students.data = response.data.students.data;
        this.students.last_page = response.data.students.last_page;
        this.students.total = response.data.students.total;
        console.log(this.students);
      }).catch(error => {
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
        id: this.students.data[index].id,
        nama: this.students.data[index].nama,
        email: this.students.data[index].email,
        tanggal_lahir: this.students.data[index].tanggal_lahir,
        jenis_kelamin: this.students.data[index].jenis_kelamin,
        kelas: this.students.data[index].kelas,
      })
      .then(response => {
        if(response.data.status === 200 && response.data.message === 'Student Update Successfully') {
          this.rowEdit = null;
          this.getStudents();
          this.setAlertMessage('success', response.data.message);
        }
      })
      .catch(error => {
        console.error(error);
      });
    },  

    // untuk delete student
    deleteStudent(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
          this.$store.dispatch('deleteStudent', {
            id
          })
          .then(response => {
            console.log(response);
            if(response.data.status === 200 && response.data.message === 'Student Delete Successfully') {
              this.students.data = this.students.data.filter(student => student.id !== id);
              
              Swal.fire({
                title: "Deleted!",
                text: response.data.message,
                icon: "success",
                confirmButtonColor: '#3085d6'
              });
            }
          })
          .catch(error => {
            console.error(error);
          });
        }
      });
      
    }
    
  },
}

</script>