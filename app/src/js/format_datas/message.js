

export function nameError() {
    const nameComplete = document.getElementById('name_complete');  // Certifica-se de que o campo de nome está sendo selecionado corretamente
    const nameErrorElement = document.getElementById('nameError');  // Seleciona o elemento de erro onde a mensagem será exibida

    nameComplete.addEventListener('input', () => {
        // Verifica se o valor do campo de nome completo está vazio
        if (nameComplete.value.trim() === '') {
            nameErrorElement.textContent = 'Por favor, preencha o nome completo.';
        } else {
            nameErrorElement.textContent = '';  // Limpa a mensagem se o campo estiver preenchido
        }
    });
}

export function maternalNameError() {
    const maternalNameInput = document.getElementById('maternal_name');  // Seleciona o campo de input para o nome materno
    const maternalNameErrorElement = document.getElementById('nameMaternalError');  // Seleciona o elemento de erro onde a mensagem será exibida

    maternalNameInput.addEventListener('input', () => {
        // Verifica se o valor do campo de nome materno está vazio
        if (maternalNameInput.value.trim() === '') {
            maternalNameErrorElement.textContent = 'Por favor, preencha o nome materno.';
        } else {
            maternalNameErrorElement.textContent = '';  // Limpa a mensagem se o campo estiver preenchido
        }
    });
}

export function emailError() {
    const emailInput = document.getElementById('user_email');  // Seleciona o campo de input para o e-mail
    const emailErrorElement = document.getElementById('emailError');  // Seleciona o elemento de erro onde a mensagem será exibida

    emailInput.addEventListener('input', () => {
        const emailValue = emailInput.value.trim();
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;  // Padrão básico de e-mail

        // Verifica se o valor do campo de e-mail está vazio ou não corresponde ao padrão
        if (emailValue === '') {
            emailErrorElement.textContent = 'Por favor, preencha o e-mail.';
        } else if (!emailPattern.test(emailValue)) {
            emailErrorElement.textContent = 'Formato de e-mail inválido.';
        } else {
            emailErrorElement.textContent = '';  // Limpa a mensagem se o campo estiver correto
        }
    });
}

export function fetchAddressByCEP() {
    const cepInput = document.getElementById('cep');
    const streetInput = document.getElementById('street');
    const complementInput = document.getElementById('complement');
    const numberInput = document.getElementById('num');

    cepInput.addEventListener('input', async () => {
        const cepValue = cepInput.value.replace(/\D/g, '');  // Remove qualquer caracter que não seja número

        // Verifica se o CEP tem 8 dígitos antes de fazer a requisição
        if (cepValue.length === 8) {
            try {
                // Faz a requisição à API do ViaCEP
                const response = await fetch(`https://viacep.com.br/ws/${cepValue}/json/`);
                const data = await response.json();

                // Verifica se a API retornou um erro (cep não encontrado)
                if (data.erro) {
                    streetInput.value = '';
                    complementInput.value = '';
                    const CEPErrorInput  = document.getElementById('CEPError').textContent  = 'CEP não encontrado. Por favor, verifique o CEP digitado.';
                } else {
                    const CEPErrorInput  = document.getElementById('CEPError').textContent  = '';
                    streetInput.value = data.logradouro;
                    complementInput.value = data.complemento;
                    numberInput.focus();  
                }
            } catch (error) {
                console.error('Erro ao buscar o endereço:', error);
                const CEPErrorInput  = document.getElementById('CEPError').textContent  = 'Erro ao buscar o endereço.';
            }
        } else {
            // Limpa os campos se o CEP for apagado
            streetInput.value = '';
            complementInput.value = '';
        }
    });
}

export function passwordValidation() {
    const passwordInput = document.getElementById('pass');
    const confirmPasswordInput = document.getElementById('c_pass');
    const passwordErrorElement = document.getElementById('passwordError');

    confirmPasswordInput.addEventListener('input', () => {
        const passwordValue = passwordInput.value;
        const confirmPasswordValue = confirmPasswordInput.value;

        // Verifica se as senhas coincidem
        if (passwordValue !== confirmPasswordValue) {
            passwordErrorElement.textContent = 'As senhas não coincidem.';
        } else {
            passwordErrorElement.textContent = '';  // Limpa a mensagem se as senhas coincidirem
        }
    });

    // Você também pode adicionar uma verificação para garantir que a senha atenda aos critérios mínimos
    passwordInput.addEventListener('input', () => {
        const passwordValue = passwordInput.value;

        if (passwordValue.length < 8) {
            passwordErrorElement.textContent = 'A senha deve ter pelo menos 8 caracteres.';
        } else {
            passwordErrorElement.textContent = '';  // Limpa a mensagem se a senha for válida
        }
    });
}


export function inputIdProduto() {
    const inputElement = document.getElementById('id_product'); // Pegando o input correto
    const messageElement = document.getElementById('message'); // Seleciona o elemento de mensagem

    // Adiciona o evento de input para verificar mudanças no valor do campo
    inputElement.addEventListener('input', function () {
        let id = inputElement.value.trim(); // Remove espaços extras

        if (id) {
            messageElement.innerHTML = 'Preencha o campo do id';
        } else {
            messageElement.innerHTML = ''; // Limpa a mensagem se o valor for preenchido
        }
    });
}
