import { defineStore } from "pinia";
import ServiceApi from "../Helpers/ServiceApi";
export const useProgramsStore = defineStore("programas-academicos", {
  state: () => ({
    programas: [],
    programa: null,
    pagination: {
      current_page: "",
      last_page: "",
    },
  }),
  actions: {
    getProgramas(page: Number = 1, rowsPerPage: Number = 25, filter: any) {
      return new Promise((resolve, reject) => {
        ServiceApi.get(
          `/api/programa/list${`?page=${page}`}&rows=${rowsPerPage}&filter=${filter}`
        )
          .then((response) => {
            this.programas = response.data.data.data;
            this.pagination.current_page = response.data.data.current_page;
            this.pagination.last_page = response.data.data.last_page;
            resolve(response.data.data.data);
          })
          .catch((error) => {
            // console.log("ERROR USERS:::", error);
            reject(error);
          });
      });
    },
    getCondiciones(programa_academico_id_fk: Number) {
      return new Promise((resolve, reject) => {
        ServiceApi.post(`/api/programa/get/condiciones`, {
          programa_academico_id_fk,
        })
          .then((response) => {
            resolve(response.data.data);
          })
          .catch((error) => {
            // console.log("ERROR USERS:::", error);
            reject(error);
          });
      });
    },
    createProgram(program: any) {
      return new Promise((resolve, reject) => {
        ServiceApi.post(`/api/programa/create`, program)
          .then((response) => {
            resolve(response);
          })
          .catch((error) => reject(error));
      });
    },
    getProgram(id: Number) {
      return new Promise((resolve, reject) => {
        ServiceApi.get(`/api/programa/get/${id}`)
          .then((response) => {
            // console.log("EL PROGRAMA:::::", response.data.data);
            this.programa = response.data.data;
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    updatePrograma(programa: any) {
      programa.facultad_id_fk = programa.facultad_id_fk.value;
      programa.programa = programa.programa.toUpperCase();
      return new Promise((resolve, reject) => {
        ServiceApi.put(`/api/programa/update`, programa)
          .then((response) => {
            console.log("Update programa:::", response.data);
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    deletePrograma(id: Number) {
      return new Promise((resolve, reject) => {
        ServiceApi.remove(`/api/programa/delete/${id}`)
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
