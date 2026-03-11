"use strict"

export function formatCEP(cep) {
    // Remove todos os caracteres não numéricos
    cep = cep.replace(/\D/g, '');

    // Adiciona a formatação do CEP
    if (cep.length <= 8) {
        cep = cep.replace(/^(\d{5})(\d)/, '$1-$2');
    }

    return cep;
}

export function filterNumbers(inputElement) {
    inputElement.addEventListener('input', function() {
        // Obtém o valor atual do input
        let num = inputElement.value;
        
        // Remove todos os caracteres não numéricos
        num = num.replace(/\D/g, '');

        // Atualiza o valor do input com apenas números
        inputElement.value = num;
    });
}