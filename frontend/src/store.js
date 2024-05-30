import { createStore } from "vuex";
import axios from "@/axios";

export default createStore({
  actions: {
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