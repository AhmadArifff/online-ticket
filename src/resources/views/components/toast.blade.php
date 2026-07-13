<div id="app-toast" class="toast-wrapper" aria-live="polite" aria-atomic="true">
    <div id="app-toast-container" class="toast-container top-right" style="display:none">
        <div id="app-toast-message" class="toast-item"></div>
    </div>
</div>

<style>
.toast-wrapper { position: fixed; z-index: 1100; inset: 0; pointer-events: none; }
.toast-container.top-right { position: fixed; top: 1rem; right: 1rem; max-width: 320px; display: flex; flex-direction: column; gap: .5rem; }
.toast-item { pointer-events: auto; background: rgba(33,37,41,0.95); color: #fff; padding: .75rem 1rem; border-radius: .5rem; box-shadow: 0 6px 18px rgba(0,0,0,.15); display:flex; align-items:center; justify-content:space-between; gap:.5rem; font-size: .95rem; }
.toast-item.success { background: #198754; }
.toast-item.error { background: #dc3545; }
.toast-item.info { background: #0d6efd; }
.toast-close { margin-left: .5rem; cursor: pointer; opacity: .9; }
@media (max-width: 768px) { .toast-container.top-right { left: 50%; right: auto; transform: translateX(-50%); top: .75rem; max-width: 92%; } }
</style>

<script>
window.__Toast = (function(){
    let timeoutId = null;
    const container = document.getElementById('app-toast-container');
    const messageEl = document.getElementById('app-toast-message');

    function show(message, type = 'info', millis = 4000) {
        if (!container) return;
        clearTimeout(timeoutId);
        messageEl.className = 'toast-item ' + type;
        messageEl.innerHTML = `<div class="toast-body">${escapeHtml(message)}</div><div class="toast-close" role="button" aria-label="close">&times;</div>`;
        container.style.display = 'flex';

        const closeBtn = messageEl.querySelector('.toast-close');
        closeBtn.onclick = hide;

        timeoutId = setTimeout(hide, millis);
    }

    function hide() {
        if (!container) return;
        container.style.display = 'none';
        messageEl.innerHTML = '';
    }

    function escapeHtml(unsafe) {
        return String(unsafe)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/\"/g, "&quot;")
            .replace(/\'/g, "&#039;");
    }

    // auto-show from server-side flash
    document.addEventListener('DOMContentLoaded', function(){
        try {
            const toastData = JSON.parse(document.getElementById('server-toast-data')?.textContent || 'null');
            if (toastData && toastData.message) {
                show(toastData.message, toastData.type || 'info', toastData.duration || 4000);
            }
        } catch(e) { /* ignore */ }
    });

    return { show, hide };
})();
</script>