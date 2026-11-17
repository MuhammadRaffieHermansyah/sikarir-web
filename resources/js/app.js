

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const setupDeleteConfirmation = () => {
    const forms = [...document.querySelectorAll('form[onsubmit*="confirm("]')];

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
            <p class="delete-confirmation__eyebrow">Tindakan permanen</p>
            <h2 id="delete-confirmation-title">Hapus data ini?</h2>
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

    const close = () => {
        confirmation.classList.remove('is-open');
        confirmation.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('delete-confirmation-open');
        activeForm = null;
        lastTrigger?.focus();
    };

    forms.forEach((form) => {
        const inlineHandler = form.getAttribute('onsubmit') || '';
        const matches = inlineHandler.match(/confirm\(['"]([^'"]+)['"]\)/);
        form.dataset.deleteConfirmationMessage = matches?.[1] || 'Data yang dihapus tidak bisa dipulihkan lagi.';
        form.removeAttribute('onsubmit');

        form.addEventListener('submit', (event) => {
            if (form.dataset.deleteConfirmed === 'true') {
                delete form.dataset.deleteConfirmed;
                return;
            }

            event.preventDefault();
            activeForm = form;
            lastTrigger = document.activeElement;
            message.textContent = form.dataset.deleteConfirmationMessage;
            confirmation.classList.add('is-open');
            confirmation.setAttribute('aria-hidden', 'false');
            document.body.classList.add('delete-confirmation-open');
            cancelButton.focus();
        });
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
