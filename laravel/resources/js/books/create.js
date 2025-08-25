document.addEventListener("DOMContentLoaded", async () => {
    const authorSelect = document.getElementById("author_id");
    const subjectSelect = document.getElementById("subject_id");
    const priceInput = document.getElementById("price");
    const bookForm = document.getElementById("book-form");
    const submitBtn = bookForm.querySelector('button[type="submit"]');

    try {
        let authorsResp = await fetch("/api/authors/combo");
        let authors = await authorsResp.json();
        (authors.data ?? authors).forEach(author => {
            let opt = document.createElement("option");
            opt.value = author.codAu;
            opt.textContent = author.nome;
            authorSelect.appendChild(opt);
        });

        let subjectsResp = await fetch("/api/subjects/combo");
        let subjects = await subjectsResp.json();
        (subjects.data ?? subjects).forEach(subject => {
            let opt = document.createElement("option");
            opt.value = subject.codAs;
            opt.textContent = subject.descricao;
            subjectSelect.appendChild(opt);
        });
    } catch (err) {
        console.error("Erro ao carregar dados:", err);
        alert("Não foi possível carregar autores/assuntos.");
    }

    // Máscara de moeda pt-BR
    priceInput.addEventListener("input", (e) => {
        let value = e.target.value.replace(/[^\d,]/g, "");
        const parts = value.split(",");
        if (parts.length > 2) value = parts[0] + "," + parts[1];
        let integerPart = parts[0].replace(/\./g, "");
        integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        value = integerPart;
        if (parts[1] !== undefined) value += "," + parts[1].slice(0, 2);
        e.target.value = value;
    });

    // Submit do formulário
    bookForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        submitBtn.disabled = true;
        const originalText = submitBtn.textContent;
        submitBtn.textContent = "Salvando...";

        const formData = new FormData(bookForm);
        const data = {
            authorIds: formData.getAll("author_id[]").map(Number),
            subjectIds: formData.getAll("subject_id[]").map(Number),
            title: formData.get("title"),
            publisher: formData.get("publisher"),
            edition: parseInt(formData.get("edition")),
            year: parseInt(formData.get("year")),
            price: parseFloat(formData.get("price").replace(/\./g, "").replace(",", "."))
        };

        try {
            const res = await fetch("/api/books", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data)
            });

            if (res.status === 201) {
                showToast("Sucesso", "Livro cadastrado com sucesso!", "success");
                bookForm.reset();
            } else if (res.status === 422) {
                const errData = await res.json().catch(() => ({}));
                const messages = Object.values(errData.errors || {}).flat().join("\n");
                showToast("Erro de validação", messages || errData.message || "Erro ao cadastrar o livro.", "error");
            } else {
                const errData = await res.json().catch(() => ({}));
                showToast("Erro", errData.message || "Não foi possível cadastrar o livro.", "error");
            }
        } catch (err) {
            console.error(err);
            showToast("Erro", "Não foi possível cadastrar o livro.", "error");
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });
});
