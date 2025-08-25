document.addEventListener('DOMContentLoaded', () => {
    const loader = document.getElementById('loader');
    const container = document.getElementById('booksContainer');
    const tbody = document.getElementById('booksBody');
    const pagination = document.getElementById('pagination');

    let currentAuthor = null;
    let currentSubject = null;
    let bookToDelete = null;
    let allAuthors = [];
    let allSubjects = [];

    const colors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark'];

    const getColorFromId = id => colors[id % colors.length];

    const confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    const deleteBtnText = document.getElementById('deleteBtnText');
    const deleteBtnSpinner = document.getElementById('deleteBtnSpinner');

    async function loadAuthorsAndSubjects() {
        if (allAuthors.length === 0) {
            const res = await fetch("/api/authors/combo");
            allAuthors = await res.json();
        }
        if (allSubjects.length === 0) {
            const res = await fetch("/api/subjects");
            allSubjects = await res.json();
        }
    }

    async function loadBooks(url = '/api/books') {

        loader.classList.remove('d-none');
        container.classList.add('d-none');

        const params = new URLSearchParams();
        if (currentAuthor) params.set('a', currentAuthor);
        if (currentSubject) params.set('s', currentSubject);

        // Preserva query string da URL da paginação
        const [baseUrl, query] = url.split('?');
        const urlParams = new URLSearchParams(query || '');
        for (const [key, value] of params.entries()) {
            urlParams.set(key, value);
        }
        url = `${baseUrl}?${urlParams.toString()}`;

        try {
            const res = await fetch(url);
            if (!res.ok) throw new Error('Erro ao carregar livros');
            const data = await res.json();

            tbody.innerHTML = '';
            pagination.innerHTML = '';

            const thAuthors = document.querySelector('th:nth-child(4)');
            const thSubjects = document.querySelector('th:nth-child(5)');

            // sinaliza que a coluna está filtrada
            thAuthors.innerHTML = `Autores`;
            if (currentAuthor) {
                thAuthors.innerHTML += ` <i class="bi bi-funnel-fill text-secondary" style="cursor:pointer" title="Remover filtro"></i>`;
                thAuthors.querySelector('i').addEventListener('click', () => {
                    currentAuthor = null;
                    loadBooks();
                });
            }

            // sinaliza que a coluna está filtrada
            thSubjects.innerHTML = `Assuntos`;
            if (currentSubject) {
                thSubjects.innerHTML += ` <i class="bi bi-funnel-fill text-secondary" style="cursor:pointer" title="Remover filtro"></i>`;
                thSubjects.querySelector('i').addEventListener('click', () => {
                    currentSubject = null;
                    loadBooks();
                });
            }

            data.data.forEach((book, index) => {
                // Autores
                let authorsHtml = '';
                const maxAuthors = 3;
                book.autores.forEach((author, i) => {
                    if (i < maxAuthors) {
                        const color = getColorFromId(author.codAu);
                        const opacityClass = currentAuthor && currentAuthor != author.codAu ? 'opacity-25' : '';
                        authorsHtml += `<a href="#" class="badge bg-${color} me-1 text-decoration-none author-badge ${opacityClass}" data-author="${author.codAu}">${author.nome}</a>`;
                    }
                });

                if (book.autores.length > maxAuthors) {
                    const remaining = book.autores.slice(maxAuthors);
                    authorsHtml += `
                        <div class="dropdown d-inline">
                            <button class="badge bg-secondary dropdown-toggle ${currentAuthor ? 'opacity-25' : ''}" type="button" data-bs-toggle="dropdown">
                                +${remaining.length}
                            </button>
                            <ul class="dropdown-menu">
                                ${remaining.map(a => {
                        const color = getColorFromId(a.codAu);
                        const opacityClass = currentAuthor && currentAuthor != a.codAu ? 'opacity-25' : '';
                        return `<li><a class="dropdown-item text-${color} author-badge ${opacityClass}" href="#" data-author="${a.codAu}">${a.nome}</a></li>`;
                    }).join('')}
                            </ul>
                        </div>
                    `;
                }

                // Assuntos
                let subjectsHtml = '';
                const maxSubjects = 2;
                book.assuntos.forEach((subject, i) => {
                    if (i < maxSubjects) {
                        const color = getColorFromId(subject.codAs);
                        const opacityClass = currentSubject && currentSubject != subject.codAs ? 'opacity-25' : '';
                        subjectsHtml += `<a href="#" class="badge bg-${color} me-1 text-decoration-none subject-badge ${opacityClass}" data-subject="${subject.codAs}">${subject.descricao}</a>`;
                    }
                });

                if (book.assuntos.length > maxSubjects) {
                    const remaining = book.assuntos.slice(maxSubjects);
                    subjectsHtml += `
                        <div class="dropdown d-inline">
                            <button class="badge bg-secondary dropdown-toggle ${currentSubject ? 'opacity-25' : ''}" type="button" data-bs-toggle="dropdown">
                                +${remaining.length}
                            </button>
                            <ul class="dropdown-menu">
                                ${remaining.map(s => {
                        const color = getColorFromId(s.codAs);
                        const opacityClass = currentSubject && currentSubject != s.codAs ? 'opacity-25' : '';
                        return `<li><a class="dropdown-item text-${color} subject-badge ${opacityClass}" href="#" data-subject="${s.codAs}">${s.descricao}</a></li>`;
                    }).join('')}
                            </ul>
                        </div>
                    `;
                }

                const row = document.createElement('tr');
                row.innerHTML = `
                    <th scope="row">${index + 1 + (data.current_page - 1) * data.per_page}</th>
                    <td>${book.titulo}</td>
                    <td>${parseFloat(book.preco).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'})}</td>
                    <td>${authorsHtml}</td>
                    <td>${subjectsHtml}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary edit-btn" data-id="${book.codl}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger remove-btn" data-id="${book.codl}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });

            // Remover
            document.querySelectorAll('.remove-btn').forEach(btn => {
                btn.addEventListener('click', e => {
                    bookToDelete = btn.dataset.id;
                    confirmModal.show();
                });
            });

            // Filtrar autores
            document.querySelectorAll('.author-badge').forEach(el => {
                el.addEventListener('click', e => {
                    e.preventDefault();
                    currentAuthor = el.dataset.author;
                    loadBooks();
                });
            });

            // Filtrar assuntos
            document.querySelectorAll('.subject-badge').forEach(el => {
                el.addEventListener('click', e => {
                    e.preventDefault();
                    currentSubject = el.dataset.subject;
                    loadBooks();
                });
            });

            // Paginação
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
                        loadBooks(link.url);
                    });
                }
                pagination.appendChild(li);
            });

            // Edição
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const id = btn.dataset.id;
                    console.log(id);

                    try {
                        const res = await fetch(`/api/books/${id}`);
                        if (!res.ok) throw new Error("Erro ao carregar livro");
                        const book = await res.json();

                        // Preencher campos
                        document.getElementById("edit_id").value = book.codl;
                        document.getElementById("edit_title").value = book.titulo;
                        document.getElementById("edit_publisher").value = book.editora;
                        document.getElementById("edit_edition").value = book.edicao;
                        document.getElementById("edit_year").value = book.anoPublicacao;
                        document.getElementById("edit_price").value = parseFloat(book.preco).toLocaleString("pt-BR", {minimumFractionDigits: 2});

                        await loadAuthorsAndSubjects();

                        // Preencher autores
                        const authorsSelect = document.getElementById("edit_authors");
                        authorsSelect.innerHTML = allAuthors.map(
                            a => `<option value="${a.codAu}" ${book.autores.some(ba => ba.codAu == a.codAu) ? 'selected' : ''}>${a.nome}</option>`
                        ).join("");

                        // Preencher assuntos
                        const subjectsSelect = document.getElementById("edit_subjects");
                        subjectsSelect.innerHTML = allSubjects.data.map(
                            s =>`<option value="${s.codAs}" ${book.assuntos.some(bs => bs.codAs == s.codAs) ? 'selected' : ''}>${s.descricao}</option>`
                        ).join("");

                        const modal = new bootstrap.Modal(document.getElementById("editBookModal"));
                        modal.show();

                    } catch (err) {
                        showToast("Erro", "Não foi possível carregar os dados do livro.", "error");
                    }
                });
            });

            loader.classList.add('d-none');
            container.classList.remove('d-none');

        } catch (err) {
            loader.innerHTML = '<div class="text-danger">Erro ao carregar os livros.</div>';
        }
    }

    // Confirmação de exclusão
    confirmBtn.addEventListener('click', async () => {
        deleteBtnText.classList.add('d-none');
        deleteBtnSpinner.classList.remove('d-none');

        const startTime = Date.now();
        const minDelay = 500; // tempo mínimo para exibir o spinner

        try {
            const res = await fetch(`/api/books/${bookToDelete}`, {method: 'DELETE'});
            if (!res.ok) throw new Error('Erro ao remover');

            // delay mínimo para o usuário notar
            const elapsed = Date.now() - startTime;
            if (elapsed < minDelay) {
                await new Promise(r => setTimeout(r, minDelay - elapsed));
            }

            confirmModal.hide();
            showToast('Sucesso', 'Livro removido com sucesso!', 'success');
            await loadBooks();

        } catch (err) {
            showToast('Erro', 'Não foi possível remover o livro.', 'error');

        } finally {
            deleteBtnText.classList.remove('d-none');
            deleteBtnSpinner.classList.add('d-none');
        }
    });

    // submit para editar
    document.getElementById("editBookForm").addEventListener("submit", async e => {
        e.preventDefault();

        const formData = {
            id: document.getElementById("edit_id").value,
            title: document.getElementById("edit_title").value,
            publisher: document.getElementById("edit_publisher").value,
            edition: document.getElementById("edit_edition").value,
            year: document.getElementById("edit_year").value,
            price: document.getElementById("edit_price").value,
            authorIds: Array.from(document.getElementById("edit_authors").selectedOptions).map(o => o.value),
            subjectIds: Array.from(document.getElementById("edit_subjects").selectedOptions).map(o => o.value),
        };

        try {
            const res = await fetch(`/api/books/${formData.id}`, {
                method: "PUT",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(formData)
            });

            if (!res.ok) throw new Error("Erro ao atualizar livro");

            showToast("Sucesso", "Livro atualizado com sucesso!", "success");
            bootstrap.Modal.getInstance(document.getElementById("editBookModal")).hide();
            loadBooks();
        } catch (err) {
            console.error(err);
            showToast("Erro", "Não foi possível atualizar o livro.", "error");
        }
    });

    // carregar livros
    loadBooks();
});
