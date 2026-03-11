export function formatSellerEmail() {
    const emailField = document.getElementById('email_seller');

    if (emailField) {
        emailField.addEventListener('input', function(event) {
            // Captura o valor digitado antes do "@"
            let input = event.target.value.split('@')[0];

            // Verifica se o domínio já foi adicionado e o evita ser repetido
            if (!input.includes('@visual_tech.com.br')) {
                // Atualiza o campo de input com o domínio fixo
                event.target.value = input + '@visual_tech.com.br';
            }
        });
    }
}
