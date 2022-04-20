import { defineStore } from "pinia";
import ServiceApi from "../Helpers/ServiceApi";
export const useFacultadesStore = defineStore("facultad", {
  state: () => ({
    facultades: [],
    decanos: [],
    facultad: null,
  }),
  actions: {
    getFacultades(
      page: Number = 1,
      rowsPerPage: Number = 25,
      filter: any = null
    ) {
      return new Promise((resolve, reject) => {
        ServiceApi.get(
          `/api/facultad/list${`?page=${page}`}&rows=${rowsPerPage}&filter=${filter}`
        )
          .then((response) => {
            console.log("RESPUESTA FACULTADES:::", response.data);
            this.facultades = response.data.data.data;
            resolve(response.data.data.data);
          })
          .catch((error) => {
            // console.log("ERROR USERS:::", error);
            reject(error);
          });
      });
    },
    getDecanos() {
      return new Promise((resolve, reject) => {
        ServiceApi.get(`/api/facultad/decanos`)
          .then((response) => {
            console.log("RESPUESTA DECANOS:::", response.data);
            this.decanos = response.data.data;
            resolve(true);
          })
          .catch((error) => {
            // console.log("ERROR USERS:::", error);
            reject(error);
          });
      });
    },
    createFacultad(facultad: any) {
      return new Promise((resolve, reject) => {
        ServiceApi.post(`/api/facultad/create`, facultad)
          .then((response) => {
            resolve(response);
          })
          .catch((error) => reject(error));
      });
    },
    getFacultad(id: Number) {
      return new Promise((resolve, reject) => {
        ServiceApi.get(`/api/facultad/get/${id}`)
          .then((response) => {
            this.facultad = response.data.data;
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    updateFacultad(facultad: any) {
      facultad.decano_id_fk = facultad.decano_id_fk.value;
      facultad.facultad = facultad.facultad.toUpperCase();
      return new Promise((resolve, reject) => {
        ServiceApi.put(`/api/facultad/update`, facultad)
          .then((response) => {
            console.log("Update facultad:::", response.data);
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    deleteFacultad(id: Number) {
      return new Promise((resolve, reject) => {
        ServiceApi.remove(`/api/facultad/delete/${id}`)
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
