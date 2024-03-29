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
        if (datetime.length <= 11) {
            datetime += " 00:00:00";
        }
        const date = new Date(datetime);
        return date.toLocaleDateString("es", format);
    }

    static time(datetime, format) {
        const date = new Date(datetime);
        const time = date.toLocaleDateString("es", format);
        const comma = time.indexOf(",");
        return time.substring(comma + 2);
    }

    static date(date) {
        if (date.length <= 11) {
            date += " 00:00:00";
        }
        date = new Date(date);
        return `${date.getDate()}-${date.getMonth() + 1}-${date.getFullYear()}`;
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
        const close = form.querySelector(".close");
        close.disabled = true;
        sessionStorage.setItem("lock", "locked");
    }

    static unlock(form) {
        const button = form.querySelector("[type=submit]");
        button.classList.remove("flex");
        button.classList.remove("items-center");
        button.classList.remove("justify-center");
        button.disabled = false;
        button.querySelector(".spinner-border").remove();
        const close = form.querySelector(".close");
        close.disabled = false;
        sessionStorage.removeItem("lock");
    }

    static filter(keys, item, value) {
        if (value == "") {
            return true;
        }
        for (let key of keys) {
            const separator = key.indexOf(".");
            let compare = "";
            if (separator > 0) {
                const mainKey = key.substring(0, separator);
                const subKey = key.substring(separator + 1);
                if (item[mainKey] != null && item[mainKey] != undefined) {
                    if (
                        item[mainKey][subKey] != null &&
                        item[mainKey][subKey] != undefined
                    ) {
                        compare = item[mainKey][subKey];
                    }
                }
            } else {
                if (item[key] != undefined && item[key] != null) {
                    compare = item[key];
                }
            }
            if (
                compare.toString().toLowerCase().includes(value.toLowerCase())
            ) {
                return true;
            }
        }
        return false;
    }

    static sort(activities) {
        if (activities == undefined) return activities;
        const sort = activities.sort((a, b) => {
            return (
                new Date(a.startdate).valueOf() -
                new Date(b.startdate).valueOf()
            );
        });
        return sort;
    }

    static getDateInput(date) {
        date = new Date(date);
        return `${date.getFullYear()}-${(date.getMonth() + 1)
            .toString()
            .padStart(2, "0")}-${date.getDate().toString().padStart(2, "0")}`;
    }

    static place(place, type) {
        switch (type) {
            case 1:
            case 2:
                return place.typeplace_id == 3;
            case 5:
                return place.typeplace_id == 4;
            case 6:
                return place.typeplace_id == 2;
            case 7:
                return place.typeplace_id == 1;
            default:
                return true;
        }
    }

    static contact(contact, type) {
        switch (type) {
            case 1:
            case 2:
            case 5:
            case 6:
                return [9, 5, 6, 4].includes(Number(contact.typecontact_id));
            case 3:
            case 4:
                return [9, 8, 6, 4].includes(Number(contact.typecontact_id));
            case 7:
            case 8:
            case 9:
                return [4, 5, 6, 3, 2].includes(Number(contact.typecontact_id));
            default:
                return false;
        }
    }

    static complete(activity) {
        const current = new Date();

        if (new Date(activity.startdate) > current) {
            return "No completado";
        } else {
            if (current < new Date(activity.enddate)) {
                return "En progreso";
            } else {
                return "Completado";
            }
        }
    }
}
