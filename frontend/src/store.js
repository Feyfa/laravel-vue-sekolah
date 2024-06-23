import { createStore } from "vuex";
import axios from "@/axios";

export default createStore({
  state: {
    user: ''
  },

  getters: {
    user: state => state.user
  },

  actions: {
    fetchUserFromLocalStorage() {
      this.state.user = JSON.parse(localStorage.getItem('user'));
    },

    processSendEmail(context, data) {
      return new Promise((resolve, reject) => {
        axios.post('/sendemail', {
          idUser: data.idUser,
          to: data.to,
          subject: data.subject,
          content: data.content,
        })
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
      });
    },

    updateUser(context, data) {
      return new Promise((resolve, reject) => {
        axios.put(`/users/${data.id}`, {
          name: data.name,
          jenis_kelamin: data.jenis_kelamin,
          tanggal_lahir: data.tanggal_lahir,
          jabatan: data.jabatan,
          alamat: data.alamat,
          pendidikan: data.pendidikan,
        })
        .then(response => {
          resolve(response);
        }) 
        .catch(error => {
          reject(error);
        });
      });
    },

    updateEmail(context, data) {
      return new Promise((resolve, reject) => {
        axios.put(`/users/email/${data.id}`, {
          email: data.email,
          mail_mailer: data.mail_mailer,
          mail_host: data.mail_host,
          mail_port: data.mail_port,
          mail_password: data.mail_password,
          mail_encryption: data.mail_encryption,
        })
        .then(response => {
          resolve(response);
        }) 
        .catch(error => {
          reject(error);
        });
      });
    },

    importExcel(context, data) {
      return new Promise((resolve, reject) => {
        axios.post('/students/import/excel', data)
             .then(response => {
               resolve(response);
             })
             .catch(error => {
              reject(error);
             })
      })
    },

    exportExcel(context, data) {
      return new Promise((resolve, reject) => {
        axios.get('/students/export/excel', {
          responseType: 'blob'
        })
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
      });
    },

    getStudents(context, data) {
      return new Promise((resolve, reject) => {
        axios.get(`/students?page=${data.current_page}&keyword=${data.keyword}`)
             .then(response => {
              resolve(response);
             })
             .catch(error => {
              reject(error);
             })
      });
    },

    addStudent(context, data) {
      return new Promise((resolve, reject) => {
        axios.post('/students', {
          nama: data.nama,
          email: data.email,
          tanggal_lahir: data.tanggal_lahir,
          jenis_kelamin: data.jenis_kelamin,
          kelas: data.kelas,
        })
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
      });
    },

    updateStudent(context, data) {
      return new Promise((resolve, reject) => {
        axios.put(`/students/${data.id}`, {
          nama: data.nama,
          email: data.email,
          tanggal_lahir: data.tanggal_lahir,
          jenis_kelamin: data.jenis_kelamin,
          kelas: data.kelas,
        })
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        })
      });
    },

    deleteStudent(context, data) {
      return new Promise((resolve, reject) => {
        axios.delete(`/students/${data.id}`)
             .then(response => {
               resolve(response);
             })
             .catch(error => {
               reject(error);
             });
      });
    },

    registerSubmit(context, data) {
      return new Promise((resolve, reject) => {
        axios.post('/register', {
          name: data.name,
          email: data.email,
          password: data.password,
        })
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
      });
    },

    loginSubmit(context, data) {
      return new Promise((resolve, reject) => {
        axios.post('/login', {
          email: data.email,
          password: data.password,
        })
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        });
      });
    },

    logout(context, data) {
      return new Promise((resolve, reject) => {
        axios.post('/logout')
             .then(response => {
              resolve(response);
             })
             .catch(error => {
              reject(error);
             })
      });
    }
  }
});