
"use strict"

export function formatLandline(phone) {
    // Remove todos os caracteres não numéricos
    phone = phone.replace(/\D/g, '');

    // Adiciona a formatação do número de telefone fixo
    if (phone.length <= 10) {
        phone = phone.replace(/^(\d{2})(\d)/, '($1) $2');
        phone = phone.replace(/(\d{4})(\d)/, '$1-$2');
    }

    return phone;
}