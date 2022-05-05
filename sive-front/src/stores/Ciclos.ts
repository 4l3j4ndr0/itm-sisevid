import { defineStore } from "pinia";
import ApiService from "../Helpers/ApiService";
import moment from "moment";
export const useCiclosStore = defineStore("ciclos", {
  state: () => ({
    ciclos: [],
    ciclo: null,
  }),
  actions: {
    getCiclos(page: Number = 1, rowsPerPage: Number = 25, filter: any = null) {
      return new Promise((resolve, reject) => {
        ApiService()
          .get(
            `/api/ciclo/list${`?page=${page}`}&rows=${rowsPerPage}&filter=${filter}`
          )
          .then((response) => {
            console.log("RESPUESTA CICLOS:::", response.data);
            this.ciclos = response.data.data.data;
            resolve(response.data.data.data);
          })
          .catch((error) => {
            // console.log("ERROR USERS:::", error);
            reject(error);
          });
      });
    },
    createCiclo(ciclo: any) {
      return new Promise((resolve, reject) => {
        ApiService()
          .post(`/api/ciclo/create`, ciclo)
          .then((response) => {
            resolve(response);
          })
          .catch((error) => reject(error));
      });
    },
    getCiclo(id: Number) {
      return new Promise((resolve, reject) => {
        ApiService()
          .get(`/api/ciclo/get/${id}`)
          .then((response) => {
            this.ciclo = response.data.data;
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    updateCiclo(ciclo: any) {
      ciclo.desde = moment(ciclo.desde).format("YYYY-MM-DD 00:00:00");
      ciclo.hasta = moment(ciclo.hasta).format("YYYY-MM-DD 23:59:59");
      return new Promise((resolve, reject) => {
        ApiService()
          .put(`/api/ciclo/update`, ciclo)
          .then((response) => {
            console.log("Update ciclo:::", response.data);
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    deleteCiclo(id: Number) {
      return new Promise((resolve, reject) => {
        ApiService()
          .remove(`/api/ciclo/delete/${id}`)
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
