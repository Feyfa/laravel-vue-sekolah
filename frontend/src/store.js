import { createStore } from "vuex";
import axios from "@/axios";

export default createStore({
  state: {
    user: '',
    userImage: ''
  },

  getters: {
    user: state => state.user,
    userImage: state => state.userImage
  },

  actions: {
    fetchUserFromLocalStorage() {
      this.state.user = JSON.parse(localStorage.getItem('user'));
    },

    fetchimgFileFromLocalStorage() {
      this.state.userImage = JSON.parse(localStorage.getItem('userImage'));
    },

    fetchUserImageFromGoogleDrive(context, data) {
      return new Promise((resolve, reject) => {
        axios.get(`/users/image/${data.path}`)
             .then(response => {
              resolve(response);
             })
             .catch(error => {
              reject(error);
             })
      })
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
        // axios.post ini di override menjadi put
        axios.post(`/users/${data.get('id')}`, data)
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