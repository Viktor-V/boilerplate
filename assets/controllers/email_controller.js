import { Controller } from 'stimulus';

export default class extends Controller {
    static values = { username: String, domain: String }

    connect() {
        const email = this.usernameValue + '@' + this.domainValue;

        this.element.textContent = email;
        this.element.href = 'mailto:' + email;
    }
}
