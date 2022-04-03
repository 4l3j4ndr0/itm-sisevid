<template>
  <q-layout>
    <q-page-container>
      <q-page class="flex flex-center">
        <div id="particles-js"></div>
        <header-main></header-main>
        <loginForm class="q-pt-xl q-pb-sm"></loginForm>
      </q-page>
      <footer-main></footer-main>
    </q-page-container>
  </q-layout>
</template>

<script type="text/javascript"></script>
<script>
import LoginForm from "../components/Login/Index.vue";
import Footer from "../components/Tools/Footer.vue";
import Header from "../components/Tools/Header.vue";
export default {
  name: "main-view",
  components: {
    loginForm: LoginForm,
    headerMain: Header,
    footerMain: Footer,
  },
  mounted() {
    particlesJS("particles-js", {
      particles: {
        number: {
          value: 80,
          density: {
            enable: true,
            value_area: 800,
          },
        },
        color: {
          value: "#ffffff",
        },
        shape: {
          type: "circle",
          stroke: {
            width: 0,
            color: "#000000",
          },
          polygon: {
            nb_sides: 5,
          },
          image: {
            src: "img/github.svg",
            width: 100,
            height: 100,
          },
        },
        opacity: {
          value: 0.5,
          random: false,
          anim: {
            enable: false,
            speed: 1,
            opacity_min: 0.1,
            sync: false,
          },
        },
        size: {
          value: 3,
          random: true,
          anim: {
            enable: false,
            speed: 40,
            size_min: 0.1,
            sync: false,
          },
        },
        line_linked: {
          enable: true,
          distance: 150,
          color: "#ffffff",
          opacity: 0.4,
          width: 1,
        },
        move: {
          enable: true,
          speed: 6,
          direction: "none",
          random: false,
          straight: false,
          out_mode: "out",
          bounce: false,
          attract: {
            enable: false,
            rotateX: 600,
            rotateY: 1200,
          },
        },
      },
      interactivity: {
        detect_on: "canvas",
        events: {
          onhover: {
            enable: true,
            mode: "grab",
          },
          onclick: {
            enable: true,
            mode: "push",
          },
          resize: true,
        },
        modes: {
          grab: {
            distance: 140,
            line_linked: {
              opacity: 1,
            },
          },
          bubble: {
            distance: 400,
            size: 40,
            duration: 2,
            opacity: 8,
            speed: 3,
          },
          repulse: {
            distance: 200,
            duration: 0.4,
          },
          push: {
            particles_nb: 4,
          },
          remove: {
            particles_nb: 2,
          },
        },
      },
      retina_detect: true,
    });
  },
};
</script>

<style>
#particles-js {
  position: absolute;
  width: 100%;
  height: 100%;
  background: linear-gradient(145deg, rgb(74, 94, 137) 15%, #b61924 70%);
  background-repeat: no-repeat;
  background-size: cover;
  background-position: 50% 50%;
}
.login-form {
  position: absolute;
}
</style>
