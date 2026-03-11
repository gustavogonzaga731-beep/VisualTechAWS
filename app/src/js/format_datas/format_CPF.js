"use strict"

export function formatCPF(cpfInput) {
  let cpf = cpfInput.value;
  
  // Remove todos os caracteres que não são números
  cpf = cpf.replace(/\D/g, '');
  
  // Aplica a formatação do CPF
  if (cpf.length <= 11) {
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
  }

  // Atualiza o valor formatado no campo de input
  cpfInput.value = cpf;

  // Valida o CPF após a formatação
  if (cpf.length === 14 && !isValidCPF(cpf)) {
    document.getElementById('CPFError').textContent = "CPF inválido";
  } else {
    document.getElementById('CPFError').textContent = "";

  }
}

// Função de validação do CPF
function isValidCPF(cpf) {
  cpf = cpf.replace(/\D/g, ''); // Remove qualquer caractere que não seja número

  if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
    return false; // Verifica se o CPF tem 11 dígitos e não é uma sequência repetida
  }

  let soma = 0;
  let resto;

  // Validação do primeiro dígito verificador
  for (let i = 1; i <= 9; i++) {
    soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
  }

  resto = (soma * 10) % 11;
  if (resto === 10 || resto === 11) resto = 0;
  if (resto !== parseInt(cpf.substring(9, 10))) return false;

  soma = 0;

  // Validação do segundo dígito verificador
  for (let i = 1; i <= 10; i++) {
    soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
  }

  resto = (soma * 10) % 11;
  if (resto === 10 || resto === 11) resto = 0;
  if (resto !== parseInt(cpf.substring(10, 11))) return false;

  return true;
}

