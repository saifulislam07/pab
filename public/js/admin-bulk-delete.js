document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const bulkCheckboxes = document.querySelectorAll('.bulk-checkbox');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const bulkDeleteForm = document.getElementById('bulkDeleteForm');
    const selectedIdsInput = document.getElementById('selectedIds');

    if (!selectAll || !bulkDeleteBtn) return;

    function updateBulkButton() {
        const checkedCount = document.querySelectorAll('.bulk-checkbox:checked').length;
        if (checkedCount > 0) {
            bulkDeleteBtn.classList.remove('d-none');
            bulkDeleteBtn.innerHTML = `<i class="fas fa-trash"></i> Delete Selected (${checkedCount})`;
        } else {
            bulkDeleteBtn.classList.add('d-none');
        }
    }

    selectAll.addEventListener('change', function() {
        bulkCheckboxes.forEach(cb => {
            cb.checked = selectAll.checked;
        });
        updateBulkButton();
    });

    bulkCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateBulkButton);
    });

    bulkDeleteBtn.addEventListener('click', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to delete multiple items. This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete them!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                const selectedIds = Array.from(document.querySelectorAll('.bulk-checkbox:checked')).map(cb => cb.value);
                selectedIdsInput.value = JSON.stringify(selectedIds);
                bulkDeleteForm.submit();
            }
        });
    });
});
