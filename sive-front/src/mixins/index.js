export const Loading = {
  methods: {
    showLoading(message) {
      this.$q.loading.show({
        message: message,
      });
    },
    hideLoading() {
      this.$q.loading.hide();
    },
  },
};
export const Noty = {
  methods: {
    NotyHtml(icon, title, message, timeout = 10000) {
      this.$q.notify({
        timeout,
        color: "white",
        position: "center",
        message: `<div style="background-color: white;" class="items-center justify-center column text-center">
          <img
            style="height:50px"
            src="https://ikiero.s3.amazonaws.com/Recursos+ikiero/icons/${icon}.png"
            alt
          />
          <div class="full-width text-center text-grey-7">
            <div class="text-h6 text-bold ft">${title}</div>
          </div>
        </div>
        <div class="full-width text-center text-grey-7" style="background-color: white;">
          <div class="text-subtitle2" style="max-width: 400px; margin: auto;">
            ${message}
          </div>
        </div>`,
        html: true,
      });
    },
    Noty(type, message, timeout = 5000) {
      switch (type) {
        case "success":
          this.$q.notify({
            type: "positive",
            timeout,
            message,
            actions: [
              {
                color: "white",
                icon: "close",
              },
            ],
          });
          break;
        case "warning":
          this.$q.notify({
            type: "warning",
            message,
            timeout,
            textColor: "white",
            actions: [
              {
                color: "white",
                icon: "close",
              },
            ],
          });
          break;
        case "error":
          this.$q.notify({
            type: "negative",
            timeout,
            message,
            actions: [
              {
                color: "white",
                icon: "close",
              },
            ],
          });
          break;
        case "info":
          this.$q.notify({
            type: "info",
            timeout,
            message,
            actions: [
              {
                color: "white",
                icon: "close",
              },
            ],
          });
          break;
      }
    },
  },
};
export const Auxiliars = {
  methods: {
    validateEmail(value) {
      const pattern =
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return pattern.test(value) || false;
    },
  },
};
