import a from "axios";
const axios = a.create({
  baseURL: "http://localhost:8000",
});
import { useUserStore } from "../stores/User";
export default function () {
  const user = useUserStore();

  const post = (url, data) => {
    return new Promise((resolve, reject) => {
      axios
        .post(`${url}`, data, {
          timeout: 60000,
          headers: {
            Authorization: `Bearer ${user.bearer_token}`,
          },
        })
        .then((response) => {
          resolve(response);
        })
        .catch((err) => {
          reject(err);
        });
    });
  };

  const get = (url) => {
    return new Promise((resolve, reject) => {
      axios
        .get(`${url}`, {
          timeout: 60000,
          headers: {
            Authorization: `Bearer ${user.bearer_token}`,
          },
        })
        .then((response) => {
          resolve(response);
        })
        .catch((err) => {
          console.log("ERRROR:::::", err);
          reject(err);
        });
    });
  };

  const remove = (url) => {
    return new Promise((resolve, reject) => {
      axios
        .delete(`${url}`, {
          timeout: 60000,
          headers: {
            Authorization: `Bearer ${user.bearer_token}`,
          },
        })
        .then((response) => {
          resolve(response);
        })
        .catch((err) => {
          reject(err);
        });
    });
  };

  const put = (url, data) => {
    return new Promise((resolve, reject) => {
      axios
        .put(`${url}`, data, {
          timeout: 60000,
          headers: {
            Authorization: `Bearer ${user.bearer_token}`,
          },
        })
        .then((response) => {
          resolve(response);
        })
        .catch((err) => {
          reject(err);
        });
    });
  };

  return {
    post,
    get,
    remove,
    put,
  };
}
