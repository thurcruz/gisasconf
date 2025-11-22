let currentStep = 0;
const steps = document.querySelectorAll('fieldset');
const headers = [
    "Vamos criar sua conta...",
    "Agora vamos coletar seus dados pessoais...",
    "Por último, seu endereço..."
];
const headerElement = document.getElementById('header');

function showStep(index) {
    steps.forEach((step, i) => step.style.display = i === index ? 'block' : 'none');
    headerElement.innerText = headers[index];
}

function nextStep() {
    if (validateStep(currentStep)) {
        if (currentStep < steps.length - 1) {
            currentStep++;
            showStep(currentStep);
        }
    } else alert("Preencha todos os campos obrigatórios.");
}

function prevStep() {
    if (currentStep > 0) {
        currentStep--;
        showStep(currentStep);
    }
}

function validateStep(index) {
    const inputs = steps[index].querySelectorAll('input[required], select[required]');
    let valid = true;
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('erro');
            valid = false;
        } else input.classList.remove('erro');
    });
    return valid;
}

document.getElementById('form').addEventListener('submit', function(e) {
    if (!validateStep(steps.length - 1)) {
        alert("Preencha todos os campos obrigatórios.");
        e.preventDefault();
        return;
    }

    const senha = document.getElementById('senha').value;
    const confirmar = document.getElementById('confirmar-senha').value;
    if (senha !== confirmar) {
        alert("As senhas não coincidem!");
        e.preventDefault();
    }
});

window.onload = function() { showStep(currentStep); };
