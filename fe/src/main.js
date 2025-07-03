import { createApp } from "vue";
import "./assets/styles/style.css";
import App from "./App.vue";
import router from "./router";
import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
  faEdit,
  faPlus,
  faEye,
  faEyeSlash,
} from "@fortawesome/free-solid-svg-icons";

library.add(faEdit, faPlus, faEye, faEyeSlash);

const app = createApp(App);
app.use(router);
app.component("font-awesome-icon", FontAwesomeIcon);
app.mount("#app");
