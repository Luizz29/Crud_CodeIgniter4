$('#userTable').on('click', '.deleteBtn', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    $.ajax({
                        url: '<?= site_url("usercontroller/deleteUser"); ?>',
                        type: 'POST',
                        data: {
                            userid: id
                        },
                        success: function(response) {
                            loadUsers();
                            alert('Data berhasil dihapus');
                        }
                    });
                }
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        });
                    }
                });
                
            });