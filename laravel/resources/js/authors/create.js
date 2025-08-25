document.addEventListener("DOMContentLoaded", async () => {
    const baseUrl = '/api/authors';
    const form = document.getElementById("create-form");
    const submitBtn = form.querySelector('button[type="submit"]');

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        submitBtn.disabled = true;
        const originalText = submitBtn.textContent;
        submitBtn.textContent = "Salvando...";

        const formData = new FormData(form);
        const data = {
            name: formData.get("name"),
        };

        try {
            const res = await fetch(`${baseUrl}`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data)
            });

            if (res.status === 201) {
                showToast("Sucesso", `Autor cadastrado com sucesso!`, "success");
                form.reset();
            } else if (res.status === 422) {
                const errData = await res.json().catch(() => ({}));
                const messages = Object.values(errData.errors || {}).flat().join("\n");
                showToast("Erro de validação", messages || errData.message || "Erro ao cadastrar o Autor.", "error");
            }
        } catch (err) {
            showToast("Erro", "Não foi possível cadastrar o Autor.", "error");
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });
});
