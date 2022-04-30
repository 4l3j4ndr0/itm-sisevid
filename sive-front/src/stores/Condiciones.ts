import { defineStore } from "pinia";
import ServiceApi from "../Helpers/ServiceApi";
export const useCondicionesStore = defineStore("condiciones", {
  state: () => ({
    condiciones: [],
    condicion: null,
  }),
  actions: {
    getCondiciones(
      page: Number = 1,
      rowsPerPage: Number = 25,
      filter: any = null
    ) {
      return new Promise((resolve, reject) => {
        ServiceApi.get(
          `/api/condicion/list${`?page=${page}`}&rows=${rowsPerPage}&filter=${filter}`
        )
          .then((response) => {
            console.log("RESPUESTA CONDICIONES:::", response.data);
            this.condiciones = response.data.data.data;
            resolve(response.data.data.data);
          })
          .catch((error) => {
            // console.log("ERROR USERS:::", error);
            reject(error);
          });
      });
    },
    createCondicion(condicion: any) {
      return new Promise((resolve, reject) => {
        ServiceApi.post(`/api/condicion/create`, condicion)
          .then((response) => {
            resolve(response);
          })
          .catch((error) => reject(error));
      });
    },
    getCondicion(id: Number) {
      return new Promise((resolve, reject) => {
        ServiceApi.get(`/api/condicion/get/${id}`)
          .then((response) => {
            this.condicion = response.data.data;
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    updateCondicion(condicion: any) {
      return new Promise((resolve, reject) => {
        ServiceApi.put(`/api/condicion/update`, condicion)
          .then((response) => {
            console.log("Update condicion:::", response.data);
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    deleteCondicion(id: Number) {
      return new Promise((resolve, reject) => {
        ServiceApi.remove(`/api/condicion/delete/${id}`)
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
