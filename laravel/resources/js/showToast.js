window.showToast = function(title, message, type = 'info') {
    const toastEl = document.getElementById('liveToast');
    const toastTitle = document.getElementById('toastTitle');
    const toastBody = document.getElementById('toastBody');

    toastTitle.textContent = title;
    toastBody.innerHTML = message;

    const header = toastEl.querySelector('.toast-header');
    header.classList.remove('bg-success','bg-danger','bg-info','bg-warning');
    if(type==='success') header.classList.add('bg-success','text-white');
    if(type==='error') header.classList.add('bg-danger','text-white');
    if(type==='info') header.classList.add('bg-info','text-white');
    if(type==='warning') header.classList.add('bg-warning','text-dark');

    const toast = new bootstrap.Toast(toastEl);
    toast.show();
};
