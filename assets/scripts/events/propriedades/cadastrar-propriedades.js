import { getFormData } from "../../handlers/form.handler.js";
import { handleException } from "../../services/handle-exception.service.js";
import { request } from "../../services/request.service.js";
import { clearMask, maskCpf } from "../../utils/mask-cpf.util.js";

document.getElementById('form').addEventListener('submit', async (e) => {
	e.preventDefault();
	const datas = getFormData('form');
	const create_property = await request('api/properties', 'POST', {
		...datas,
		is_admin: datas.is_admin === 'true'
	});
	const created = create_property.status;

	if (created === 201) {
		window.location.href = 'visualizar-propriedades.html';
	}
	else {
		handleException(create_property);
	}
});

// script.js
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 0;
    const steps = document.querySelectorAll('.step');
    const nextButton = document.getElementById('nextBtn');
    const prevButton = document.getElementById('prevBtn');
    const form = document.getElementById('multiStepForm');

    function showStep(step) {
        steps.forEach((stepElement, index) => {
            stepElement.classList.toggle('active', index === step);
        });
        prevButton.style.display = step === 0 ? 'none' : 'inline-block';
        nextButton.innerText = step === steps.length - 1 ? 'Enviar' : 'Próximo';
    }

    nextButton.addEventListener('click', () => {
        if (currentStep < steps.length - 1) {
            currentStep++;
            showStep(currentStep);
        } else {
            form.submit();
        }
    });

    prevButton.addEventListener('click', () => {
        if (currentStep > 0) {
            currentStep--;
            showStep(currentStep);
        }
    });

    showStep(currentStep);
});
