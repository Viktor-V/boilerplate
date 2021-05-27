import { Controller } from 'stimulus';
import md5 from 'crypto-js/md5';

export default class extends Controller {
    static targets = ['hash'];

    onSubmit(event) {
        event.preventDefault();

        let concatenatedValues = '';
        [...this.element.elements].forEach(function(element) {
            if (element.name !== 'hash') {
                concatenatedValues += element.value;
            }
        });

        this.hashTarget.value = md5(concatenatedValues);

        this.element.submit();
    }
}
