document.addEventListener("DOMContentLoaded", async () => {
    const baseUrl = '/api/subjects';
    const form = document.getElementById("create-form");
    const submitBtn = form.querySelector('button[type="submit"]');

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        submitBtn.disabled = true;
        const originalText = submitBtn.textContent;
        submitBtn.textContent = "Salvando...";

        const formData = new FormData(form);
        const data = {
            description: formData.get("description"),
        };

        try {
            const res = await fetch(`${baseUrl}`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data)
            });

            if (res.status === 201) {
                showToast("Sucesso", `Assunto cadastrado com sucesso!`, "success");
                form.reset();
            } else if (res.status === 422) {
                const errData = await res.json().catch(() => ({}));
                const messages = Object.values(errData.errors || {}).flat().join("\n");
                showToast("Erro de validação", messages || errData.message || "Erro ao cadastrar o Assunto.", "error");
            }
        } catch (err) {
            const messages = Object.values(errData.errors || {}).flat().join("\n");
            showToast("Erro de validação", messages || errData.message || "Erro ao cadastrar o Assunto.", "error");
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });
});
