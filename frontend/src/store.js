import { createStore } from "vuex";
import axios from "@/axios";

export default createStore({
  actions: {
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
    }
  }
});