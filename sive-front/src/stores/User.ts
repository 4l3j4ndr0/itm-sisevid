import { defineStore } from "pinia";
import ApiService from "../Helpers/ApiService";
export const useUserStore = defineStore("user", {
  state: () => ({
    users: [],
    tipoPersonas: [],
    user: null,
    bearer_token: null,
  }),
  actions: {
    login(email: String, password: String) {
      return new Promise((resolve, reject) => {
        ApiService()
          .post("/api/login", {
            email,
            password,
          })
          .then((response) => {
            this.bearer_token = response.data.token;
            resolve(response.data.token);
          })
          .catch((error) => {
            console.log("ERROR LOGIN:::", error);
            reject(error);
          });
      });
    },
    logOut() {
      return new Promise((resolve, reject) => {
        ApiService()
          .get("/api/logout")
          .then((response) => {
            this.bearer_token = null;
            resolve(response.data);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    setToken(token: any) {
      this.bearer_token = token;
    },
    getUsers(page: Number = 1, rowsPerPage: Number = 25, filter: any) {
      return new Promise((resolve, reject) => {
        ApiService()
          .get(
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
        ApiService()
          .get(`/api/user/tipoPersonas`)
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
        ApiService()
          .post(`/api/user/create`, user)
          .then((response) => {
            resolve(response);
          })
          .catch((error) => reject(error));
      });
    },
    getUser(id: Number) {
      return new Promise((resolve, reject) => {
        ApiService()
          .get(`/api/user/get/${id}`)
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
        ApiService()
          .put(`/api/user/update`, user)
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
        ApiService()
          .remove(`/api/user/delete/${id}`)
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
