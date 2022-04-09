import a from "axios";
const axios = a.create({
  baseURL: "http://localhost:8000",
});
async function post(url, data) {
  //   let token = await sessionStorage.getItem("token");
  //console.log('EL TOKEN:::', token)
  return new Promise((resolve, reject) => {
    axios
      .post(`${url}`, data, {
        timeout: 60000,
        headers: {
          Authorization: `Bearer ww`,
        },
      })
      .then((response) => {
        resolve(response);
      })
      .catch((err) => {
        reject(err);
      });
  });
}

async function get(url) {
  //   let token = await sessionStorage.getItem("token");
  // console.log('EL TOKEN:::', token)
  return new Promise((resolve, reject) => {
    axios
      .get(`${url}`, {
        timeout: 60000,
        headers: {
          Authorization: `Bearer qqq`,
        },
      })
      .then((response) => {
        resolve(response);
      })
      .catch((err) => {
        reject(err);
      });
  });
}

export default {
  post,
  get,
};
