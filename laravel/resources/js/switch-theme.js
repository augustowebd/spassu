    (() => {
    const storedTheme = localStorage.getItem('theme');

    const getPreferredTheme = () => {
    if (storedTheme) return storedTheme;
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
};

    const setTheme = (theme) => {
    if (theme === 'auto') {
    document.documentElement.setAttribute('data-bs-theme',
    window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
} else {
    document.documentElement.setAttribute('data-bs-theme', theme);
}
};

    const showActiveTheme = (theme) => {
    const themeSwitcher = document.querySelector('#themeSwitcher');
    const activeBtn = document.querySelector(`[data-bs-theme-value="${theme}"]`);

    // remove active de todos
    document.querySelectorAll('[data-bs-theme-value]').forEach(el => el.classList.remove('active'));

    // marca o atual
    activeBtn.classList.add('active');

    // atualiza o botão principal
    const icon = activeBtn.querySelector('i').outerHTML;
    const text = activeBtn.textContent.trim();
    themeSwitcher.innerHTML = `${icon} ${text}`;
};

    const init = () => {
    const preferredTheme = getPreferredTheme();
    setTheme(preferredTheme);
    showActiveTheme(preferredTheme);

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    if (storedTheme !== 'light' && storedTheme !== 'dark') {
    const newTheme = getPreferredTheme();
    setTheme(newTheme);
    showActiveTheme(newTheme);
}
});

    document.querySelectorAll('[data-bs-theme-value]').forEach(button => {
    button.addEventListener('click', () => {
    const theme = button.getAttribute('data-bs-theme-value');
    localStorage.setItem('theme', theme);
    setTheme(theme);
    showActiveTheme(theme);
});
});
};

    init();
})();
