import { createApp } from "vue";
import ConfirmItem from "./ConfirmItem.vue";

/**
 * @class Maneja los ventanas tipo "Modal" del sistema
 */
export default class Modal {
    constructor(title, subtitle) {
        const _this = this;
        //Si no se pasa un diseño personalizado del modal usar el diseño predeterminado
        this.root = ConfirmItem;
        this.root.mixins = [
            {
                data() {
                    const data = {
                        title: title,
                        subtitle: subtitle,
                    };
                    return data;
                },
                methods: {
                    /**
                     * Resuelve la promesa del modal
                     */
                    accept() {
                        _this.resolve({
                            status: "accept",
                        });
                    },
                    /**
                     * Resuelve la promesa del modal
                     */
                    cancel() {
                        _this.reject({
                            status: "cancel",
                        });
                    },
                    resolve(result) {
                        _this.resolve({
                            status: result.status,
                        });
                    },
                },
            },
        ];
        this.app = createApp(this.root);
    }

    /**
     * Muestra el modal
     * @returns {Promise} Promesa que se resuelve cuando se acepta, se cancela o se cierra el modal
     */
    fire() {
        return new Promise((resolve, reject) => {
            this.resolve = resolve;
            this.reject = reject;
            this.app.mount("#confirm");
        });
    }
}
