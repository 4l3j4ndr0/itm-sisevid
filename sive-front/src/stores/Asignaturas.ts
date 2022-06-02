import { defineStore } from "pinia";
import ApiService from "../Helpers/ApiService";
export const useAsignaturasStore = defineStore("asignaturas", {
  state: () => ({
    asignaturas: [],
    asignatura: null,
  }),
  actions: {
    getAsignaturas(page: Number = 1, rowsPerPage: Number = 25, filter: any) {
      return new Promise((resolve, reject) => {
        ApiService()
          .get(
            `/api/asignatura/list${`?page=${page}`}&rows=${rowsPerPage}&filter=${filter}`
          )
          .then((response) => {
            // console.log("RESPUESTA ASIGNATURAS:::", response.data);
            this.asignaturas = response.data.data.data;
            resolve(response.data.data.data);
          })
          .catch((error) => {
            // console.log("ERROR USERS:::", error);
            reject(error);
          });
      });
    },
    createAsignatura(asignatura: any) {
      return new Promise((resolve, reject) => {
        ApiService()
          .post(`/api/asignatura/create`, asignatura)
          .then((response) => {
            resolve(response);
          })
          .catch((error) => reject(error));
      });
    },
    getAsignatura(id: Number) {
      return new Promise((resolve, reject) => {
        ApiService()
          .get(`/api/asignatura/get/${id}`)
          .then((response) => {
            // console.log("EL PROGRAMA:::::", response.data.data);
            this.asignatura = response.data.data;
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    updateAsignatura(asignatura: any) {
      asignatura.ciclo_id_fk = asignatura.ciclo_id_fk.value;
      asignatura.programa_id_fk = asignatura.programa_id_fk.value;
      asignatura.asignatura = asignatura.asignatura.toUpperCase();
      asignatura.creditos = parseInt(asignatura.creditos);
      return new Promise((resolve, reject) => {
        ApiService()
          .put(`/api/asignatura/update`, asignatura)
          .then((response) => {
            console.log("Update asignatura:::", response.data);
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    deleteAsignatura(id: Number) {
      return new Promise((resolve, reject) => {
        ApiService()
          .remove(`/api/asignatura/delete/${id}`)
          .then((response) => {
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
  },
});
