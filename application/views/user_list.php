<!DOCTYPE html>
<html>
<head>
    <title>User List</title>


<link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/jquery.dataTables.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/toastr.min.css'); ?>">
<script src="<?= base_url('assets/js/jquery-3.6.0.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.validate.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/toastr.min.js'); ?>"></script>
<script src="<?= base_url('assets/npm/sweetalert2@11'); ?>"></script>

</head>

<body>
<div class="container mt-4">

    <h3 class="text-center mb-4">User Details</h3>
<div class="d-flex justify-content-end mb-3">
    <a href="<?= base_url(); ?>" class="btn btn-success">
        + Add User
    </a>
</div>
    <table id="userTable" class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Sl no</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Gender</th>
                <th>State Code</th>
                <th>Created On</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <form id="editUserForm">
          <input type="hidden" name="id" id="editUserId">
          
          <div class="mb-3">
              <label class="form-label" for="editName">Full Name</label>
              <input type="text" name="name" id="editName" class="form-control" placeholder="Enter your full name" required>
          </div>

          <div class="mb-3">
              <label class="form-label" for="editEmail">Email Address</label>
              <input type="email" name="email" id="editEmail" class="form-control" placeholder="Enter email" required>
          </div>

          <div class="mb-3">
              <label class="form-label" for="editMobile">Mobile Number</label>
              <input type="text" name="mobile" id="editMobile" class="form-control" placeholder="10-digit mobile number" minlength="10" maxlength="10" required>
          </div>

          <div class="mb-3">
              <label class="form-label">Gender</label><br>
              <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" id="editGenderMale" value="Male" required>
                  <label class="form-check-label" for="editGenderMale">Male</label>
              </div>
              <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" id="editGenderFemale" value="Female">
                  <label class="form-check-label" for="editGenderFemale">Female</label>
              </div>
              <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" id="editGenderOther" value="Other">
                  <label class="form-check-label" for="editGenderOther">Other</label>
              </div>
          </div>

          <div class="mb-3">
              <label class="form-label" for="editStateSelect">State</label>
              <select name="state" id="editStateSelect" class="form-select" required>
                  <option value="">Select State</option>
              </select>
          </div>

          <button type="submit" class="btn btn-primary w-100">Update</button>
        </form>
      </div>
      
    </div>
  </div>
</div>


</div>

<script>
    
$('#userTable').DataTable({
    "ajax": {
        "url": "<?php echo base_url('user/getUsers'); ?>",
        "type": "POST",
        "dataSrc": "data"
    },
    "columns": [
        { "data": "sl_no" },
        { "data": "name" },
        { "data": "email" },
        { "data": "mobile" },
        { "data": "gender" },
        { "data": "state_name" },
        { "data": "created_on" },
        { "data": "action", "orderable": false, "searchable": false }
    ]
});

$('#userTable').on('click', '.deleteBtn', function() {
    var userId = $(this).data('id');

    Swal.fire({
        title: "Are you sure?",
        text: "This action cannot be undone!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: "<?= base_url('user/deleteUser'); ?>",
                type: "POST",
                data: { id: userId },
                success: function(response) {
                    var res = JSON.parse(response);

                    if (res.status == 'success') {
                        Swal.fire(
                            "Deleted!",
                            res.message,
                            "success"
                        );
                        $('#userTable').DataTable().ajax.reload();
                    } else {
                        Swal.fire("Error!", res.message, "error");
                    }
                },
                error: function() {
                    Swal.fire("Error!", "Something went wrong!", "error");
                }
            });
        }
    });
});
$(document).on('click', '.editUserBtn', function() {
    console.log('Edit button clicked');

    var userId = $(this).data('id');

    // Fetch user data via AJAX
    $.ajax({
        url: "<?= base_url('user/get_user_by_id'); ?>/" + userId,
        type: "POST",
        dataType: "json",
        success: function(res){
            if(res.status == 'success'){
                var user = res.data;

                $('#editUserId').val(user.id);
                $('#editName').val(user.name);
                $('#editEmail').val(user.email);
                $('#editMobile').val(user.mobile);

                // Set gender radio
                $("input[name='gender'][value='"+user.gender+"']").prop('checked', true);

                // Load states and select user state
                loadStates('#editStateSelect', user.state);

                // Open modal
                var editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                editModal.show();
            } else {
                toastr.error('Failed to fetch user data');
            }
        }
    });
});
 function loadStates(selectId, selectedState = '') {
        $.ajax({
            url: "<?= base_url('user/get_states'); ?>",
            type: "GET",
            dataType: "json",
            success: function(states){
                var options = '<option value="">Select State</option>';
                $.each(states, function(i,state){
                    options += `<option value="${state.state_code}" ${state.state_code == selectedState ? 'selected' : ''}>${state.state_name}</option>`;
                });
                $(selectId).html(options);
            }
        });
}
    // Submit edit form via AJAX
    // Validation for Edit Form
$("#editUserForm").validate({
    rules: {
        name: { required: true, minlength: 3 },
        email: { required: true, email: true },
        mobile: { required: true, digits: true, minlength: 10, maxlength: 10 },
        gender: { required: true },
        state: { required: true }
    },
    messages: {
        name: { required: "Please enter your name" },
        email: { required: "Enter a valid email address" },
        mobile: { required: "Enter mobile number", minlength: "Must be 10 digits" },
        gender: { required: "Please select gender" },
        state: { required: "Please select state" }
    },
    errorElement: "label",
    errorPlacement: function (error, element) {
        if(element.attr("name") == "gender"){
            error.insertAfter(element.closest('.mb-3')); // Place error below gender radios
        } else {
            error.insertAfter(element);
        }
    },
    submitHandler: function (form) {
        // AJAX submit after validation
        $.ajax({
            url: "<?= base_url('user/update_user_details'); ?>",
            type: "POST",
            data: $(form).serialize(),
            dataType: "json",
            success: function(res){
                if(res.status == 'success'){
                    toastr.success(res.message);
                    $('#editUserModal').modal('hide'); // Close modal
                   $('#userTable').DataTable().ajax.reload();
                } else {
                    toastr.error(res.message);
                }
            },
            error: function(){
                toastr.error('Something went wrong');
            }
        });
    }
});

</script>

</body>
</html>
