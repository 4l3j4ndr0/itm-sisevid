import { defineStore } from "pinia";
import ApiService from "../Helpers/ApiService";
export const useEvidenciaStore = defineStore("evidencia", {
  state: () => ({
    evidencias: [],
    tipoEvidencias: [],
    evidencia: null,
  }),
  actions: {
    uploadFile(data: any, fileName: String) {
      return new Promise((resolve, reject) => {
        ApiService()
          .uploadFile(
            `/api/evidencias/uploadFile?fileName=${fileName.replace(".", "_")}`,
            data
          )
          .then((response) => {
            resolve(response.data.path);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    getTiposEvidencia() {
      return new Promise((resolve, reject) => {
        ApiService()
          .get("/api/evidencias/get/tipo/evidencias")
          .then((response) => {
            this.tipoEvidencias = response.data.data;
            resolve(true);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    getEvidencias(page: Number = 1, rowsPerPage: Number = 25, filter: any) {
      return new Promise((resolve, reject) => {
        ApiService()
          .get(
            `/api/evidencias/list${`?page=${page}`}&rows=${rowsPerPage}&filter=${filter}`
          )
          .then((response) => {
            // console.log("RESPUESTA USERS:::", response.data);
            this.evidencias = response.data.data.data;
            resolve(true);
          })
          .catch((error) => {
            // console.log("ERROR USERS:::", error);
            reject(error);
          });
      });
    },
    createEvidencia(evidencia: any) {
      return new Promise((resolve, reject) => {
        ApiService()
          .post(`/api/evidencias/create`, evidencia)
          .then((response) => {
            resolve(response);
          })
          .catch((error) => reject(error));
      });
    },
    getEvidencia(id: Number) {
      return new Promise((resolve, reject) => {
        ApiService()
          .get(`/api/evidencias/get/${id}`)
          .then((response) => {
            this.evidencia = response.data.evidencia;
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    updateEvidencia(evidencia: any) {
      return new Promise((resolve, reject) => {
        ApiService()
          .put(`/api/evidencias/update`, evidencia)
          .then((response) => {
            console.log("Update evidencias:::", response.data);
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    deleteEvidencia(id: Number) {
      return new Promise((resolve, reject) => {
        ApiService()
          .remove(`/api/evidencias/delete/${id}`)
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
