import Alert from "./components/alert/Alert.js";
import AlertConfig from "./components/alert/AlertConfig.js";

export default class Utils {
    static FULL_DATE_TIME = {
        day: "2-digit",
        month: "numeric",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        hour12: true,
    };

    static TEXT_DATE = {
        dateStyle: "long",
    };

    static FULL_TIME = {
        hour: "2-digit",
        minute: "2-digit",
        hour12: true,
    };

    static datetime(datetime, format) {
        const date = new Date(datetime);
        return date.toLocaleDateString("es", format);
    }

    static time(datetime, format) {
        const date = new Date(datetime);
        const time = date.toLocaleDateString("es", format);
        const comma = time.indexOf(",");
        return time.substring(comma + 2);
    }

    static elapsedtime(time, today) {
        if (today == undefined) {
            today = new Date();
        }
        const date = new Date(time);
        const diff = today - date;
        if (diff < 0) {
            return "Hace instantes";
        } else if (diff <= 3600000) {
            return `Hace ${Math.floor(diff / 60000)} minutos`;
        } else if (diff <= 86400000) {
            return `Hace ${Math.floor(diff / 3600000)} horas`;
        } else if (diff <= 604800000) {
            return `Hace ${Math.floor(diff / 86400000)} días`;
        } else if (diff <= 2592000000) {
            return `Hace ${Math.floor(diff / 604800000)} semanas`;
        } else if (diff <= 31536000000) {
            let months = today.getMonth() - date.getMonth();
            if (months < 0) {
                months += 12;
            }
            let days = today.getDate() - date.getDate();
            if (days < 0) {
                const last = new Date(
                    date.getFullYear(),
                    date.getMonth() + 1,
                    0
                );
                days = last.getDate() - date.getDate() + today.getDate();
                months--;
            }
            if (months > 0) {
                if (days == 0) {
                    return `Hace ${months} ${months == 1 ? "mes" : "meses"}`;
                } else {
                    return `Hace ${months} ${
                        months == 1 ? "mes" : "meses"
                    } y ${days} ${days == 1 ? "día" : "días"}`;
                }
            } else {
                return `Hace ${days} días`;
            }
        } else {
            return date.toLocaleDateString("es", {
                day: "numeric",
                weekday: "short",
                month: "short",
                year: "numeric",
            });
        }
    }

    static token() {
        return localStorage.getItem("token");
    }

    static username() {
        return localStorage.getItem("username");
    }

    static role() {
        return localStorage.getItem("user_role");
    }

    static manager() {
        return localStorage.getItem("manager");
    }

    static user() {
        return JSON.parse(localStorage.getItem("user"));
    }

    static notify(text) {
        const alert = new Alert(
            new AlertConfig({
                title: "¡Operación satisfactoria!",
                text: text,
                icon: "bi bi-check2-square",
                color: "#198754",
            })
        );
        alert.fire();
    }

    static error(response) {
        let title = "",
            text = "";
        switch (response.status) {
            case 500:
                title = "¡Error en el servidor!";
                text =
                    "Ha ocurrido un error al comunicarse con el servidor, intnte nuevamente";
                break;
            case 422:
                title = "¡Error de validación!";
                text = response.data.message;
                break;
            case 401:
                title = "¡Error de autenticación!";
                text =
                    "No está autenticado o no tiene permisos para realizar esta acción";
                break;
            default:
                title = "¡Error desconocido!";
                text = "Lo sentimos, tuvimos un error desconocido";
                break;
        }
        const alert = new Alert(
            new AlertConfig({
                title: title,
                text: text,
                icon: "bi bi-exclamation-triangle",
                color: "#f55555",
            })
        );
        alert.fire();
    }

    static lock(form) {
        const button = form.querySelector("[type=submit]");
        button.classList.add("flex");
        button.classList.add("items-center");
        button.classList.add("justify-center");
        button.disabled = true;
        button.insertAdjacentHTML(
            "afterbegin",
            '<div class="spinner-border me-2" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
    }

    static unlock(form) {
        const button = form.querySelector("[type=submit]");
        button.classList.remove("flex");
        button.classList.remove("items-center");
        button.classList.remove("justify-center");
        button.disabled = false;
        button.querySelector(".spinner-border").remove();
    }

    static filter(keys, item, value) {
        if (value == "") {
            return true;
        }
        for (let key of keys) {
            if (item[key] != undefined && item[key] != null) {
                if (
                    item[key]
                        .toString()
                        .toLowerCase()
                        .includes(value.toLowerCase())
                ) {
                    return true;
                }
            }
        }
        return false;
    }
}
