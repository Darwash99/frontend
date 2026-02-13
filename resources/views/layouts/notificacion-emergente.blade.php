
{{-- Notificación emergente  --}}
<div class="position-fixed top-0 end-0 p-4" style="z-index: 1100">
    <div id="liveToast" class="toast shadow border-0" role="alert">
        <div class="toast-body d-flex align-items-center">
            <div id="toastIconWrapper" class="me-3">
                <i id="toastIcon" class="fs-4"></i>
            </div>
            <div class="flex-grow-1">
                <strong id="toastTitle" class="d-block"></strong>
                <span id="toastMessage" class="small text-muted">
                </span>
            </div>
            <button type="button" class="btn-close ms-3" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>