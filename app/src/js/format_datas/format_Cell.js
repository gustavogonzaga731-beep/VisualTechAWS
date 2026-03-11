"use strict"

export function formatPhoneNumber(phone) {
    // Remove todos os caracteres não numéricos
    phone = phone.replace(/\D/g, '');

    // Adiciona a formatação do número de celular
    if (phone.length <= 11) {
        phone = phone.replace(/^(\d{2})(\d)/, '($1) $2');
        phone = phone.replace(/(\d{5})(\d)/, '$1-$2');
    }

    return phone;
}

/*  
    Função para inicializar o campo de input de telefone com a biblioteca intl-tel-input
export function initPhoneInput(inputSelector, formSelector) {
    const input = document.querySelector(inputSelector);
    const iti = window.intlTelInput(input, {
        initialCountry: "br",  // Define o Brasil como o país inicial
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"  // Carrega utilitários adicionais
    });

    const form = document.querySelector(formSelector);
    form.addEventListener("submit", function (event) {
        event.preventDefault();  // Previne o envio padrão do formulário
        const phoneNumber = iti.getNumber();  // Obtém o número formatado
        console.log(phoneNumber);  // Exibe no console o número formatado com o código do país
    });
}
*/
