import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Feedback de "guardando..." al enviar un formulario: evita el doble
// submit en peticiones que pueden tardar (subida de poster, promocion
// con el aviso sincrono a Telegram) sin bloquear el envio en si.
window.pdPending = function (form) {
    const btn = form.querySelector('button[type="submit"]');
    if (!btn || btn.disabled) {
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<span class="h-4 w-4 shrink-0 animate-spin rounded-full border-2 border-current border-t-transparent"></span> Guardando…';
};
