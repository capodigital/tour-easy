export default class Utils {
    static FULL_DATE_TIME = {
        day: "2-digit",
        month: "numeric",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        hour12: true,
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
}
