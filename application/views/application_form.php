<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Form</title>


    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">

    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .form-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            border-top: 5px solid #ff7a00;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
            animation: fadeIn 0.4s ease-in-out;
        }
        .form-title {
            font-size: 26px;
            font-weight: 600;
            color: #ff7a00;
            text-align: center;
            margin-bottom: 25px;
        }
        .form-label {
            color: #333;
            font-weight: 500;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 10px 12px;
        }
        .btn-submit {
            background: #ff7a00;
            color: white;
            font-size: 16px;
            font-weight: 600;
            padding: 12px;
            border-radius: 8px;
            border: none;
            transition: 0.3s;
        }
        .btn-submit:hover {
            background: #e86b00;
            box-shadow: 0 4px 12px rgba(255,122,0,0.4);
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(15px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>

<body>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

         
            <div class="form-card">
                <div class="form-title">Application Form</div>

                <form id="applicationForm">

                        <div class="mb-3">
                            <label class="form-label" for="name">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="email">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="mobile">Mobile Number</label>
                            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="10-digit mobile number" minlength="10" maxlength="10" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gender</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Male" required>
                                <label class="form-check-label" for="genderMale">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Female">
                                <label class="form-check-label" for="genderFemale">Female</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="genderOther" value="Other">
                                <label class="form-check-label" for="genderOther">Other</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="stateSelect">State</label>
                            <select name="state" id="stateSelect" class="form-select" required>
                                <option value="">Select State</option>
                              
                            </select>
                        </div>

                        <button type="submit" class="btn-submit w-100">Submit</button>
                    </form>

            </div>

        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/jquery-3.6.0.min.js'); ?>"></script>
<link rel="stylesheet" href="<?= base_url('assets/css/toastr.min.css'); ?>">

<!-- Toastr JS -->
<script src="<?= base_url('assets/js/toastr.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.validate.min.js'); ?>"></script>


<script>
  $(document).ready(function () {

  
    $.ajax({
        url: "<?= base_url('user/get_states'); ?>",
        type: "POST",
        dataType: "json",
        success: function(states) {
            var options = '<option value="">Select State</option>';
            $.each(states, function(index, state) {
                options += '<option value="'+state.state_code+'">'+state.state_name+'</option>';
            });
            $('#stateSelect').html(options);
        },
        error: function() {
            alert('Failed to fetch states.');
        }
    });

    
    $("#applicationForm").validate({
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
                error.insertAfter(element.closest('.mb-3')); 
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            var formData = $(form).serialize();

            $.ajax({
                url: "<?= base_url('user/save_application_data'); ?>",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function(res) {
                    if(res.status == 'success') {
                        toastr.success(res.message);   
                        form.reset();  
                        setTimeout(function(){
                            window.location.href = "<?= base_url('user'); ?>"; 
                        }, 1500);               
                    } else {
                        toastr.error(res.message);    
                    }
                },
                error: function() {
                    toastr.error("Something went wrong. Try again.");
                }
            });

            return false; 
        }
    });

});

</script>
</body>
</html>
