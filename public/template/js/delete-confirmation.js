document.addEventListener('DOMContentLoaded', function () {
    const table = $('#dataTable').DataTable({
        ordering: true,
        searching: true,
        paging: true,
        info: true,
        language: {
            search: "Cari Data:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Tidak ditemukan data yang sesuai",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 data",
            infoFiltered: "(difilter dari _MAX_ total data)"
        }
    });

    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-id');
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#e74a3b',
                cancelButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteForm');
                    form.setAttribute('action', '/user/delete/' + userId);
                    form.submit();
                }
            });
        });
    });
});
