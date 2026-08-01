import './bootstrap';

const confirmationDialog = document.createElement('dialog');
confirmationDialog.className = 'ui-confirm-dialog';
confirmationDialog.setAttribute('aria-labelledby', 'confirmation-dialog-title');
confirmationDialog.setAttribute('aria-describedby', 'confirmation-dialog-message');
confirmationDialog.setAttribute('aria-modal', 'true');
confirmationDialog.innerHTML = `
    <div class="p-6 sm:p-7">
        <div class="flex size-11 items-center justify-center rounded-full bg-rose-50 text-rose-700" aria-hidden="true">
            <svg viewBox="0 0 24 24" class="size-5 fill-none stroke-current" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 9v4m0 4h.01M10.3 3.9 2.8 17a2 2 0 0 0 1.7 3h15a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z" />
            </svg>
        </div>
        <h2 id="confirmation-dialog-title" class="mt-4 text-lg font-semibold tracking-tight text-slate-950"></h2>
        <p id="confirmation-dialog-message" data-confirmation-message class="mt-2 text-sm leading-6 text-slate-600"></p>
        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <button type="button" data-confirmation-cancel class="ui-button-secondary w-full sm:w-auto">Cancel</button>
            <button type="button" data-confirmation-approve class="ui-button-danger w-full sm:w-auto"></button>
        </div>
    </div>
`;

document.body.append(confirmationDialog);

const confirmationTitle = confirmationDialog.querySelector('#confirmation-dialog-title');
const confirmationMessage = confirmationDialog.querySelector('[data-confirmation-message]');
const cancelConfirmation = confirmationDialog.querySelector('[data-confirmation-cancel]');
const approveConfirmation = confirmationDialog.querySelector('[data-confirmation-approve]');
let formAwaitingConfirmation = null;
let confirmationTrigger = null;

const destructiveActionName = (form) => {
    const action = form.action;

    if (action.includes('/committee-positions/')) return 'Committee Position';
    if (action.includes('/meetings/')) return 'Meeting';
    if (action.includes('/activities/')) return 'Activity';
    if (action.includes('/members/')) return 'Member';

    return 'Record';
};

const setFormProcessing = (form, submitter) => {
    if (form.method.toLowerCase() === 'get' || form.dataset.processing === 'true') {
        return;
    }

    const button = submitter instanceof HTMLButtonElement
        ? submitter
        : form.querySelector('button[type="submit"], button:not([type])');

    if (! button) {
        return;
    }

    form.dataset.processing = 'true';
    button.disabled = true;
    button.setAttribute('aria-busy', 'true');
    button.classList.add('ui-button-processing');
    button.innerHTML = `<span class="ui-loading-indicator" aria-hidden="true"></span><span>${form.dataset.confirm ? 'Deleting…' : 'Saving…'}</span>`;
};

cancelConfirmation.addEventListener('click', () => confirmationDialog.close());

approveConfirmation.addEventListener('click', () => {
    const confirmedForm = formAwaitingConfirmation;

    if (! confirmedForm) {
        return;
    }

    confirmedForm.dataset.confirmed = 'true';
    confirmationDialog.close();
    confirmedForm.requestSubmit();
});

confirmationDialog.addEventListener('close', () => {
    formAwaitingConfirmation = null;
    confirmationTrigger?.focus();
    confirmationTrigger = null;
});

document.addEventListener('submit', (event) => {
    const form = event.target;

    if (! (form instanceof HTMLFormElement)) {
        return;
    }

    if (! form.dataset.confirm) {
        setFormProcessing(form, event.submitter);
        return;
    }

    if (form.dataset.confirmed === 'true') {
        delete form.dataset.confirmed;
        setFormProcessing(form, event.submitter);
        return;
    }

    event.preventDefault();

    const actionName = destructiveActionName(form);
    const message = form.dataset.confirm.includes('cannot be undone')
        ? form.dataset.confirm
        : `${form.dataset.confirm} This action cannot be undone.`;

    if (typeof confirmationDialog.showModal !== 'function') {
        if (window.confirm(message)) {
            form.dataset.confirmed = 'true';
            form.requestSubmit();
        }

        return;
    }

    formAwaitingConfirmation = form;
    confirmationTrigger = event.submitter instanceof HTMLElement ? event.submitter : document.activeElement;
    confirmationTitle.textContent = `Delete ${actionName}`;
    confirmationMessage.textContent = message;
    approveConfirmation.textContent = `Delete ${actionName}`;
    confirmationDialog.showModal();
    cancelConfirmation.focus();
});
