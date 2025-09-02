import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

// Importa Bootstrap JS
import "bootstrap";

// Importa gli stili di Bootstrap (se non già inclusi altrove)
import "bootstrap/dist/css/bootstrap.min.css";
