<div id="user">
    <div class="row">
        <div class="col">
            <div class="card p-3">
                <div class="card-header">
                    <h5 class="card-title text-center mb-0">Konfigurasi User</h5>
                    <div class="text-center" style="float: right">
                        <button class="btn btn-primary btn-sm add-user">Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-primary">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody">
                                <!-- User data will be populated here using Ajax -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editUserId" name="user_id">
                    <div class="form-group">
                        <label for="editName">username</label>
                        <input type="text" class="form-control" id="editName" name="username">
                    </div>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    @csrf
                    <div class="form-group">
                        <label for="username">username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Fetch users and populate the table
        function fetchUsers() {
            $.get('/users', function(data) {
                let tableBody = $('#userTableBody');
                tableBody.empty();

                $.each(data, function(index, user) {
                    tableBody.append(`
                        <tr>
                            <th scope="row">${index + 1}</th>
                            <td>${user.username}</td>
                            <td>
                                <button class="btn btn-primary btn-sm edit-user" data-id="${user.id }">Edit</button>
                                <button class="btn btn-danger btn-sm delete-user" data-id="${user.id}">Delete</button>
                            </td>
                        </tr>
                    `);
                });
            });
        }

        // Load users on page load
        fetchUsers();

        // Add User
        $('#addUserForm').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.post('/users', formData, function() {
                fetchUsers();
                $('#addUserForm')[0].reset();
                $('#addUserModal').modal('hide');
            });
        });

        // Delete User
        $(document).on('click', '.delete-user', function() {
            let userId = $(this).data('id');
            let csrfToken = $('meta[name="csrf-token"]').attr('content'); // Dapatkan token CSRF

            $.ajax({
                url: `/users/${userId}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Sertakan token CSRF dalam header
                },
                success: function() {
                    fetchUsers();
                }
            });
        });


        $(document).on('click', '.edit-user', function() {
            let userId = $(this).data('id');
            let editRow = $(this).closest('tr');
            let username = editRow.find('td:eq(0)').text();

            // Populate form fields
            $('#editUserId').val(userId);
            $('#editName').val(username);

            $('#editUserModal').modal('show');
        });

        $(document).on('click', '.add-user', function() {
            $('#addUserModal').modal('show');
        });

        // Submit Edit Form
        $('#editUserForm').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            let userId = $('#editUserId').val();

            $.ajax({
                url: `/users/${userId}`,
                type: 'PUT',
                data: formData,
                success: function() {
                    fetchUsers();
                    $('#editUserModal').modal('hide');
                }
            });
        });
    });
</script>
