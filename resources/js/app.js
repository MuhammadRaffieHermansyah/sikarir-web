import "./blatui.js";

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const setupDeleteConfirmation = () => {
    const forms = [...document.querySelectorAll('form[onsubmit*="confirm("], form[data-confirm-action]')];

    if (!forms.length || document.querySelector('[data-delete-confirmation]')) return;

    const confirmation = document.createElement('div');
    confirmation.dataset.deleteConfirmation = '';
    confirmation.className = 'delete-confirmation';
    confirmation.setAttribute('aria-hidden', 'true');
    confirmation.innerHTML = `
        <div class="delete-confirmation__backdrop" data-delete-cancel></div>
        <section class="delete-confirmation__dialog" role="alertdialog" aria-modal="true" aria-labelledby="delete-confirmation-title" aria-describedby="delete-confirmation-message">
            <div class="delete-confirmation__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v5M14 11v5"/></svg>
            </div>
            <p class="delete-confirmation__eyebrow" data-confirmation-eyebrow>Tindakan permanen</p>
            <h2 id="delete-confirmation-title" data-confirmation-title>Hapus data ini?</h2>
            <p id="delete-confirmation-message">Data yang dihapus tidak bisa dipulihkan lagi.</p>
            <div class="delete-confirmation__actions">
                <button type="button" class="delete-confirmation__cancel" data-delete-cancel>Batal</button>
                <button type="button" class="delete-confirmation__confirm" data-delete-confirm>Ya, hapus data</button>
            </div>
        </section>
    `;
    document.body.appendChild(confirmation);

    let activeForm = null;
    let lastTrigger = null;
    const cancelButton = confirmation.querySelector('[data-delete-cancel]:not(.delete-confirmation__backdrop)');
    const confirmButton = confirmation.querySelector('[data-delete-confirm]');
    const message = confirmation.querySelector('#delete-confirmation-message');
    const title = confirmation.querySelector('[data-confirmation-title]');
    const eyebrow = confirmation.querySelector('[data-confirmation-eyebrow]');
    const icon = confirmation.querySelector('.delete-confirmation__icon');
    const deleteIcon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v5M14 11v5"/></svg>';
    const logoutIcon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 17l5-5-5-5"/><path d="M15 12H3"/><path d="M21 19V5a2 2 0 0 0-2-2h-6"/></svg>';

    const close = () => {
        confirmation.classList.remove('is-open');
        confirmation.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('delete-confirmation-open');
        activeForm = null;
        lastTrigger?.focus();
    };

    const wireForm = (form) => {
        if (form.dataset.confirmationType) return;

        const inlineHandler = form.getAttribute('onsubmit') || '';
        const matches = inlineHandler.match(/confirm\(['"]([^'"]+)['"]\)/);
        const isLogout = form.dataset.confirmAction === 'logout';
        form.dataset.confirmationType = isLogout ? 'logout' : 'delete';
        form.dataset.deleteConfirmationMessage = matches?.[1] || (isLogout
            ? 'Kamu akan keluar dari sesi ini dan perlu masuk lagi untuk mengakses dashboard.'
            : 'Data yang dihapus tidak bisa dipulihkan lagi.');
        form.removeAttribute('onsubmit');

        form.addEventListener('submit', (event) => {
            if (form.dataset.deleteConfirmed === 'true') {
                delete form.dataset.deleteConfirmed;
                return;
            }

            event.preventDefault();
            activeForm = form;
            lastTrigger = document.activeElement;
            const isLogout = form.dataset.confirmationType === 'logout';
            message.textContent = form.dataset.deleteConfirmationMessage;
            title.textContent = isLogout ? 'Keluar dari akun?' : 'Hapus data ini?';
            eyebrow.textContent = isLogout ? 'Konfirmasi sesi' : 'Tindakan permanen';
            confirmButton.textContent = isLogout ? 'Ya, keluar' : 'Ya, hapus data';
            icon.innerHTML = isLogout ? logoutIcon : deleteIcon;
            confirmation.classList.toggle('is-logout', isLogout);
            confirmation.classList.add('is-open');
            confirmation.setAttribute('aria-hidden', 'false');
            document.body.classList.add('delete-confirmation-open');
            cancelButton.focus();
        });
    };

    const matchesConfirmationForm = (form) => form.matches('form[onsubmit*="confirm("], form[data-confirm-action]');

    forms.forEach(wireForm);

    // The mobile sidebar drawer is cloned from a <template> the first time it opens, so its
    // logout form is not in the document yet. Wire forms that appear later as they submit.
    document.addEventListener('submit', (event) => {
        const form = event.target;

        if (!(form instanceof HTMLFormElement) || form.dataset.confirmationType || !matchesConfirmationForm(form)) {
            return;
        }

        event.preventDefault();
        wireForm(form);
        form.requestSubmit();
    });

    confirmation.querySelectorAll('[data-delete-cancel]').forEach((button) => button.addEventListener('click', close));
    confirmButton.addEventListener('click', () => {
        if (!activeForm) return;
        const form = activeForm;
        form.dataset.deleteConfirmed = 'true';
        confirmation.classList.remove('is-open');
        confirmation.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('delete-confirmation-open');
        activeForm = null;
        form.requestSubmit();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && confirmation.classList.contains('is-open')) close();
    });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupDeleteConfirmation);
} else {
    setupDeleteConfirmation();
}
