"use strict";

import { formatCPF } from "./format_datas/format_CPF.js";
import { formatPhoneNumber } from "./format_datas/format_Cell.js";
import { formatLandline } from "./format_datas/format_landline.js";
import { formatCEP, filterNumbers } from './format_datas/format_CEP.js';
import { formatSellerEmail } from './format_datas/format_Email_sellers.js';
import { inputIdProduto, nameError, maternalNameError, emailError, fetchAddressByCEP, passwordValidation } from "./format_datas/message.js";
import { forms } from "./events/events.js";

document.addEventListener("DOMContentLoaded", function () {
    const cpfInput = document.getElementById("cpf");
    const cellInput = document.getElementById("user_cell");
    const landlineInput = document.getElementById("landline");
    const cepInput = document.getElementById("cep");
    const numInput = document.getElementById("num");
    const emailSellers = document.getElementById("email_seller");
    const idProductSpan = document.getElementById("id_product");
    const nameCompleteInput = document.getElementById('name_complete');
    const maternalNameInput = document.getElementById('maternal_name');
    const userEmailInput = document.getElementById('user_email');
    const pass = document.getElementById('pass');

    if (cpfInput) {
        cpfInput.addEventListener("input", function () {
            formatCPF(cpfInput);
        });
    }

    if (cellInput) {
        cellInput.addEventListener("input", function(e) {
            const formattedPhone = formatPhoneNumber(e.target.value);
            e.target.value = formattedPhone;
        });
    }

    if (landlineInput) {
        landlineInput.addEventListener('input', function(e) {
            const formattedLandline = formatLandline(e.target.value);
            e.target.value = formattedLandline;
        });
    }

    if (cepInput) {
        cepInput.addEventListener("input", function(e) {
            const formattedCEP = formatCEP(e.target.value);
            e.target.value = formattedCEP;
        });
    }

    if (numInput) {
        numInput.addEventListener("input", function() {
            filterNumbers(numInput);
        });
    }

    if (emailSellers) {
        formatSellerEmail();
    }

    if (idProductSpan) {
        idProductSpan.textContent = inputIdProduto;  // Atualiza o texto do span com o ID do produto
    }

    if (nameCompleteInput) {
        nameError();
    }

    if (maternalNameInput) {
        maternalNameError();
    }

    if (userEmailInput) {
        emailError();
    }

    if (cepInput) {
        fetchAddressByCEP();
    }

    if (pass) {
        passwordValidation();
    }

    forms()
});
