import { defineStore } from "pinia";
import ApiService from "../Helpers/ApiService";
export const useUserStore = defineStore("user", {
  state: () => ({
    users: [],
    tipoPersonas: [],
    user: null,
    bearer_token: null,
    permisos: [
      {
        label: "Dashboard inicial",
        value: "/",
      },
      {
        label: "Listar usuarios",
        value: "/users",
      },
      {
        label: "Crear usuarios",
        value: "/users/create",
      },
      {
        label: "Editar usuarios",
        value: "/users/edit/:id",
      },
      {
        label: "Eliminar usuarios",
        value: "/users/delete",
      },
      {
        label: "Listar facultades",
        value: "/facultades",
      },
      {
        label: "Crear facultades",
        value: "/facultades/create",
      },
      {
        label: "Editar facultades",
        value: "/facultades/edit/:id",
      },
      {
        label: "Eliminar facultades",
        value: "/facultades/delete",
      },
      {
        label: "Listar programas académicos",
        value: "/programs",
      },
      {
        label: "Crear programas académicos",
        value: "/programs/create",
      },
      {
        label: "Editar programas académicos",
        value: "/programs/edit/:id",
      },
      {
        label: "Eliminar programas académicos",
        value: "/programs/delete",
      },
      {
        label: "Listar ciclos",
        value: "/ciclos",
      },
      {
        label: "Crear ciclos",
        value: "/ciclos/create",
      },
      {
        label: "Editar ciclos",
        value: "/ciclos/edit/:id",
      },
      {
        label: "Eliminar ciclos",
        value: "/ciclos/delete",
      },
      {
        label: "Listar asignaturas",
        value: "/asignaturas",
      },
      {
        label: "Crear asignaturas",
        value: "/asignaturas/create",
      },
      {
        label: "Editar asignaturas",
        value: "/asignaturas/edit/:id",
      },
      {
        label: "Eliminar asignaturas",
        value: "/asignaturas/delete",
      },
      {
        label: "Listar capitulos",
        value: "/capitulos",
      },
      {
        label: "Crear capitulos",
        value: "/capitulos/create",
      },
      {
        label: "Editar capitulos",
        value: "/capitulos/edit/:id",
      },
      {
        label: "Eliminar capitulos",
        value: "/capitulos/delete",
      },
      {
        label: "Crear condiciones",
        value: "/condiciones/create/:program_id/:program_name",
      },
      {
        label: "Editar condiciones",
        value: "/condiciones/edit/:id",
      },
      {
        label: "Eliminar condiciones",
        value: "/condiciones/delete",
      },
      {
        label: "Listar evidencias",
        value: "/evidencias",
      },
      {
        label: "Crear evidencias",
        value: "/evidencias/create",
      },
      {
        label: "Editar evidencias",
        value: "/evidencias/edit/:id",
      },
      {
        label: "Eliminar evidencias",
        value: "/evidencias/delete",
      },
    ],
    permisosUser: [],
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
            this.permisosUser = response.data.permisos;
            resolve(response.data);
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
    setPermisos(permisos: any) {
      this.permisosUser = permisos;
    },
    getUsers(
      page: Number = 1,
      rowsPerPage: Number = 25,
      filter: any,
      onlyStudentTeacher: Boolean = false
    ) {
      return new Promise((resolve, reject) => {
        ApiService()
          .get(
            `/api/user/list${`?page=${page}`}&rows=${rowsPerPage}&filter=${filter}&onlyStudentTeacher=${onlyStudentTeacher}`
          )
          .then((response) => {
            // console.log("RESPUESTA USERS:::", response.data);
            this.users = response.data.data.data;
            resolve(response.data.data.data);
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
            resolve(response.data);
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
    hasPermission(permiso: String) {
      return (
        this.permisosUser.filter((p: any) => p.path === permiso).length > 0
      );
    },
  },
});
