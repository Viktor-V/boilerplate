import { Controller } from "stimulus"

export default class extends Controller {
    static targets = [ "toggleable" ]

    connect() {
        console.log('test');
    }

    toggle() {
        this.toggleableTarget.classList.toggle('show');
    }
}
