document.addEventListener('DOMContentLoaded', () => {
    const itemLabel = 'Autor';

    const loader = document.getElementById('loader');
    const container = document.getElementById('myContainer');
    const tbody = document.getElementById('myBody');
    const pagination = document.getElementById('pagination');

    /* modal control */
    const confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
    const confirmRemoveBtn = document.getElementById('confirmDeleteBtn');
    const deleteBtnText = document.getElementById('deleteBtnText');
    const deleteBtnSpinner = document.getElementById('deleteBtnSpinner');

    let itemToDelete = null;
    const baseUrl = '/api/authors';

    async function loadContent(url = baseUrl) {
        loader.classList.remove('d-none');
        container.classList.add('d-none');

        try {
            const result = await fetch(url);

            if (!result.ok) { throw new Error('Erro ao carregar dados'); }

            const data = await result.json();
            tbody.innerHTML = '';
            pagination.innerHTML = '';

            // adiciona os dados na tabela
            data.data.forEach((item, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <th scope="row">${index + 1 + (data.current_page - 1) * data.per_page}</th>
                    <td>${item.nome}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary edit-btn" data-id="${item.codAu}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger remove-btn" data-id="${item.codAu}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });
            data.links.forEach(link => {
                const li = document.createElement('li');
                li.className = `page-item ${link.active ? 'active' : ''} ${link.url === null ? 'disabled' : ''}`;
                let label = link.label;
                if (label.includes('Previous')) label = 'Anterior';
                if (label.includes('Next')) label = 'Próximo';
                li.innerHTML = `<a class="page-link" href="#">${label}</a>`;

                if (link.url) {
                    li.querySelector('a').addEventListener('click', e => {
                        e.preventDefault();
                        loadContent(link.url);
                    });
                }
                pagination.appendChild(li);
            });

            document.querySelectorAll('.remove-btn').forEach(btn => {
                btn.addEventListener('click', e => {
                    itemToDelete = btn.dataset.id;
                    confirmModal.show();
                });
            });

            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const id = btn.dataset.id;

                    try {
                        const response = await fetch(`${baseUrl}/${id}`);
                        if (! response.ok) throw new Error("Erro ao carregar item");

                        const item = await response.json();
                        console.log(item);

                        // Preencher campos
                        document.getElementById("edit_id").value = item.codAu;
                        document.getElementById("edit_name").value = item.nome;

                        const modal = new bootstrap.Modal(document.getElementById("editModal"));
                        modal.show();
                    } catch (err) {
                        let message = err?.message?.toString().trim() || "Não foi possível carregar os dados.";
                        showToast("Erro", message, "error");
                    }
                });
            });

            loader.classList.add('d-none');
            container.classList.remove('d-none');

        } catch (e) {
            console.error(e);
            let err = '<div class="text-danger">Erro ao carregar os dados.</div>';
            showToast("Falha no carregamento dos dados", err, "error");
        }
    }

    // remove o item
    confirmRemoveBtn.addEventListener('click', async () => {
        deleteBtnText.classList.add('d-none');
        deleteBtnSpinner.classList.remove('d-none');

        const startTime = Date.now();
        const minDelay = 500;

        try {
            const response = await fetch(`${baseUrl}/${itemToDelete}`, { method: 'DELETE' });

            if (! response.ok) {
                if (response.status === 422) {
                    throw new Error(`Existe(m) 1 ou mais dependência(s) vinculada(s) ao ${itemLabel}.`);
                }

                throw new Error(`Erro ao carregar ${itemLabel}.`);
            }

            // delay mínimo para o usuário notar
            const elapsed = Date.now() - startTime;
            if (elapsed < minDelay) {
                await new Promise(r => setTimeout(r, minDelay - elapsed));
            }

            confirmModal.hide();
            showToast('Sucesso', `${itemLabel} removido com sucesso!`, 'success');
            await loadContent();

        } catch (err) {
            showToast('Erro', err.message, 'error');
        } finally {
            deleteBtnText.classList.remove('d-none');
            deleteBtnSpinner.classList.add('d-none');
        }
    });

    // edita item
    document.getElementById("editItemForm").addEventListener("submit", async e => {
        e.preventDefault();

        const formData = {
            id: document.getElementById("edit_id").value,
            name: document.getElementById("edit_name").value,
        };

        try {
            const res = await fetch(`${baseUrl}/${formData.id}`, {
                method: "PUT",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(formData)
            });

            if (! res.ok) {
                throw new Error(`Erro ao atualizar ${itemLabel}`);
            }

            showToast("Sucesso", `${itemLabel} atualizado com sucesso!`, "success");
            bootstrap.Modal.getInstance(document.getElementById("editModal")).hide();
            await loadContent();
        } catch (err) {
            showToast("Erro", `Não foi possível atualizar o ${itemLabel}.`, "error");
        }
    });

    // inicializa a grid
    loadContent()
});
