import { defineStore } from "pinia";
import ServiceApi from "../Helpers/ServiceApi";
export const useUserStore = defineStore("user", {
  state: () => ({
    users: [],
    tipoPersonas: [],
    user: null,
  }),
  actions: {
    getUsers(page: Number = 1, rowsPerPage: Number = 25, filter: any) {
      return new Promise((resolve, reject) => {
        ServiceApi.get(
          `/api/user/list${`?page=${page}`}&rows=${rowsPerPage}&filter=${filter}`
        )
          .then((response) => {
            // console.log("RESPUESTA USERS:::", response.data);
            this.users = response.data.data.data;
            resolve(true);
          })
          .catch((error) => {
            // console.log("ERROR USERS:::", error);
            reject(error);
          });
      });
    },
    getTiposUsuarios() {
      return new Promise((resolve, reject) => {
        ServiceApi.get(`/api/user/tipoPersonas`)
          .then((response) => {
            const tipoPersonas = response.data.data;
            let newList: any = [];
            tipoPersonas.map((tp: any) => {
              newList.push({
                value: tp.id,
                label: tp.tipo,
              });
            });
            this.tipoPersonas = newList;
            resolve(true);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    createUser(user: any) {
      return new Promise((resolve, reject) => {
        ServiceApi.post(`/api/user/create`, user)
          .then((response) => {
            resolve(response);
          })
          .catch((error) => reject(error));
      });
    },
    getUser(id: Number) {
      return new Promise((resolve, reject) => {
        ServiceApi.get(`/api/user/get/${id}`)
          .then((response) => {
            this.user = response.data.data;
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    updateUser(user: any) {
      user.tipo_personas_id_fk = user.tipo_personas_id_fk.value;
      return new Promise((resolve, reject) => {
        ServiceApi.put(`/api/user/update`, user)
          .then((response) => {
            console.log("Update usuario:::", response.data);
            resolve(response);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    deleteUser(id: Number) {
      return new Promise((resolve, reject) => {
        ServiceApi.remove(`/api/user/delete/${id}`)
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
