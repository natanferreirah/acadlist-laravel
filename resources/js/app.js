import Alpine from 'alpinejs'
import IMask from 'imask'

document.addEventListener('alpine:init', () => {
    Alpine.directive('mask-cpf', (el) => {
        IMask(el, { mask: '000.000.000-00' });
    });
    
    Alpine.directive('mask-phone', (el) => {
        IMask(el, {
            mask: [
                { mask: '(00) 00000-0000' }
            ]
        });
    });
});

window.Alpine = Alpine
Alpine.start()