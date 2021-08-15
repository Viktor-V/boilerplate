import { Controller } from 'stimulus';

export default class extends Controller {
    static values = { number: String }

    connect() {
        const phone = this.numberValue;

        this.element.textContent = phone;
        this.element.href = 'tel:' + phone;
    }
}
