// Toggle element untuk menampilkan/hide
function toggleElement(id) {
    const el = document.getElementById(id);
    if (el) {
        el.classList.toggle('hidden');
    }
}
