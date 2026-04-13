function initRegistrationWizard() {
    const wizards = document.querySelectorAll('[data-registration-wizard]');

    wizards.forEach((wizard) => {
        if (wizard.dataset.wizardReady === 'true') {
            return;
        }

        wizard.dataset.wizardReady = 'true';

        const indicators = Array.from(wizard.querySelectorAll('[data-step-indicator]'));
        const panels = Array.from(wizard.querySelectorAll('[data-step-panel]'));
        const progressFill = wizard.querySelector('[data-progress-fill]');
        const totalSteps = indicators.length;

        const setStep = (step) => {
            indicators.forEach((indicator) => {
                const indicatorStep = Number(indicator.dataset.stepIndicator);
                indicator.classList.toggle('is-active', indicatorStep === step);
                indicator.classList.toggle('is-complete', indicatorStep < step);
            });

            panels.forEach((panel) => {
                const panelStep = Number(panel.dataset.stepPanel);
                const isActive = panelStep === step;

                panel.hidden = !isActive;
                panel.classList.toggle('is-active', isActive);
            });

            if (progressFill) {
                const percentage = totalSteps === 2
                    ? (step === 1 ? 42 : 100)
                    : Math.max(0, ((step - 1) / Math.max(1, totalSteps - 1)) * 100);

                progressFill.style.width = `${percentage}%`;
            }

            wizard.dataset.currentStep = String(step);

            const currentPanel = wizard.querySelector(`[data-step-panel="${step}"]`);
            const firstInput = currentPanel?.querySelector('.is-invalid, input, textarea, select');
            if (firstInput instanceof HTMLElement) {
                firstInput.focus();
            }
        };

        const showNetworkError = (panel) => {
            if (!panel) {
                return;
            }

            let errorBox = panel.querySelector('.form-custom-errors[data-network-error]');

            if (!errorBox) {
                errorBox = document.createElement('div');
                errorBox.className = 'form-custom-errors';
                errorBox.setAttribute('data-network-error', 'true');
                errorBox.innerHTML = '<div class="form-custom-error">Une erreur est survenue. Reessayez dans un instant.</div>';
                panel.prepend(errorBox);
            }
        };

        const toggleSubmitting = (form, isSubmitting) => {
            const submitButton = form.querySelector('[type="submit"]');
            if (!(submitButton instanceof HTMLButtonElement || submitButton instanceof HTMLInputElement)) {
                return;
            }

            if (isSubmitting) {
                if (!submitButton.dataset.originalLabel) {
                    submitButton.dataset.originalLabel = submitButton instanceof HTMLInputElement
                        ? submitButton.value
                        : submitButton.innerHTML;
                }

                const loadingLabel = submitButton.dataset.loadingLabel || 'Envoi en cours...';
                submitButton.disabled = true;

                if (submitButton instanceof HTMLInputElement) {
                    submitButton.value = loadingLabel;
                } else {
                    submitButton.textContent = loadingLabel;
                }

                return;
            }

            submitButton.disabled = false;

            if (submitButton.dataset.originalLabel) {
                if (submitButton instanceof HTMLInputElement) {
                    submitButton.value = submitButton.dataset.originalLabel;
                } else {
                    submitButton.innerHTML = submitButton.dataset.originalLabel;
                }
            }
        };

        wizard.addEventListener('submit', async (event) => {
            const form = event.target;
            if (!(form instanceof HTMLFormElement)) {
                return;
            }

            const stepName = form.dataset.registrationStep;
            if (!stepName) {
                return;
            }

            event.preventDefault();

            const currentStep = stepName === 'profile' ? 2 : 1;
            const panel = wizard.querySelector(`[data-step-panel="${currentStep}"]`);

            toggleSubmitting(form, true);

            try {
                const response = await fetch(form.action, {
                    method: form.method || 'POST',
                    body: new FormData(form),
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                });

                const data = await response.json();

                if (!response.ok || data.success === false) {
                    if (panel && data.html) {
                        panel.innerHTML = data.html;
                    }

                    setStep(currentStep);
                    return;
                }

                if (stepName === 'user') {
                    const profilePanel = wizard.querySelector('[data-step-panel="2"]');
                    if (profilePanel && data.html) {
                        profilePanel.innerHTML = data.html;
                    }

                    setStep(2);
                    return;
                }

                if (data.redirect) {
                    window.location.assign(data.redirect);
                }
            } catch (error) {
                showNetworkError(panel);
            } finally {
                const activeForm = panel?.querySelector('form[data-registration-step]');
                if (activeForm instanceof HTMLFormElement) {
                    toggleSubmitting(activeForm, false);
                }
            }
        });

        setStep(Number(wizard.dataset.currentStep || '1'));
    });
}

function updateFileInputState(fileInput) {
    const targetId = fileInput.dataset.fileNameTarget;
    const target = targetId
        ? document.getElementById(targetId)
        : fileInput.closest('.cv-upload-field')?.querySelector('.cv-upload-name');

    if (!target) {
        return;
    }

    const emptyLabel = fileInput.dataset.emptyLabel || 'Aucun fichier selectionne';
    const hasFile = Boolean(fileInput.files && fileInput.files.length > 0);
    const fileName = hasFile ? fileInput.files[0].name : emptyLabel;

    target.textContent = fileName;
    fileInput.closest('.cv-upload-field')?.classList.toggle('has-file', hasFile);
}

document.addEventListener('change', (event) => {
    const target = event.target;

    if (target instanceof HTMLInputElement && target.matches('[data-file-input]')) {
        updateFileInputState(target);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    initRegistrationWizard();
    document.querySelectorAll('input[data-file-input]').forEach(updateFileInputState);
});

document.addEventListener('turbo:load', () => {
    initRegistrationWizard();
    document.querySelectorAll('input[data-file-input]').forEach(updateFileInputState);
});
