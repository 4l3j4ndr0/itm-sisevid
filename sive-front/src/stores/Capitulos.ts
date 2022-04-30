import { defineStore } from "pinia";
import ServiceApi from "../Helpers/ServiceApi";
export const useCapitulosStore = defineStore("capitulos", {
  state: () => ({
    capitulos: [],
    capitulo: null,
  }),
  actions: {
    getCapitulos(
      page: Number = 1,
      rowsPerPage: Number = 25,
      filter: any = null
    ) {
      return new Promise((resolve, reject) => {
        ServiceApi.get(
          `/api/capitulo/list${`?page=${page}`}&rows=${rowsPerPage}&filter=${filter}`
        )
          .then((response) => {
            console.log("RESPUESTA CAPITULOS:::", response.data);
            this.capitulos = response.data.data.data;
            resolve(response.data.data.data);
          })
          .catch((error) => {
            // console.log("ERROR USERS:::", error);
            reject(error);
          });
      });
    },
    createCapitulo(capitulo: any) {
      return new Promise((resolve, reject) => {
        ServiceApi.post(`/api/capitulo/create`, capitulo)
          .then((response) => {
            resolve(response);
          })
          .catch((error) => reject(error));
      });
    },
    getCapitulo(id: Number) {
      return new Promise((resolve, reject) => {
        ServiceApi.get(`/api/capitulo/get/${id}`)
          .then((response) => {
            this.capitulo = response.data.data;
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    updateCapitulo(capitulo: any) {
      return new Promise((resolve, reject) => {
        ServiceApi.put(`/api/capitulo/update`, capitulo)
          .then((response) => {
            console.log("Update capitulo:::", response.data);
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    deleteCapitulo(id: Number) {
      return new Promise((resolve, reject) => {
        ServiceApi.remove(`/api/capitulo/delete/${id}`)
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
