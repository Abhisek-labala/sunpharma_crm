@include('yogaeducator.header')

<div class="main-wrapper">
    @include('yogaeducator.Sidebar')

    <!-- Page Wrapper -->
    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">
            @include('yogaeducator.breadcum')

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            {{-- Success / Error Messages --}}
                            <div id="responseMessage"></div>

                            <form id="changePassword" method="POST">
                                @csrf

                                {{-- Current Password --}}
                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-2">Current Password</label>
                                    <div class="col-md-10 position-relative">
                                        <input type="password" maxlength="12" class="form-control"
                                            name="currentPassword" id="currentPassword" required>
                                        <span class="toggle-password" data-target="currentPassword"
                                            style="position:absolute; right:15px; top:10px; cursor:pointer;">👁️</span>
                                    </div>
                                </div>

                                {{-- New Password --}}
                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-2">New Password</label>
                                    <div class="col-md-10 position-relative">
                                        <input type="password" maxlength="12" class="form-control"
                                            name="newPassword" id="newPassword" required>
                                        <span class="toggle-password" data-target="newPassword"
                                            style="position:absolute; right:15px; top:10px; cursor:pointer;">👁️</span>
                                    </div>
                                </div>

                                {{-- Submit --}}
                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-2"></label>
                                    <div class="col-md-10">
                                        <button type="submit" id="submit"
                                            class="btn btn-primary thembutton">Submit</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('yogaeducator.footer')

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- Password Toggle --}}
<script>
    document.querySelectorAll('.toggle-password').forEach(function (eyeIcon) {
        eyeIcon.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            if (input) {
                input.type = input.type === 'password' ? 'text' : 'password';
                this.textContent = input.type === 'password' ? '👁️' : '🙈';
            }
        });
    });
</script>

{{-- AJAX Password Change --}}
<script>
    $("#changePassword").on("submit", function(e) {
        e.preventDefault();

        const currentPassword = $("#currentPassword").val().trim();
        const newPassword = $("#newPassword").val().trim();
        const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;

        // Client-side validation
        if (!currentPassword || !newPassword) {
            $("#responseMessage").html('<div class="alert alert-danger">Both current and new password fields are required.</div>');
            return;
        }
        if (currentPassword === newPassword) {
            $("#responseMessage").html('<div class="alert alert-danger">New password cannot be the same as the current password.</div>');
            return;
        }
        if (!passwordPattern.test(newPassword)) {
            $("#responseMessage").html('<div class="alert alert-danger">Password must be at least 8 characters long and include at least one letter, one number, and one special character.</div>');
            return;
        }

        // AJAX request
        $.ajax({
            url: "{{ route('yogaeducator.change-password-post') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                currentPassword: currentPassword,
                newPassword: newPassword
            },
            success: function(response) {
                $("#responseMessage").html('<div class="alert alert-success">' + response.message + '</div>');
                $("#changePassword")[0].reset();
            },
            error: function(xhr) {
                const errMsg = xhr.responseJSON?.message || "Something went wrong!";
                $("#responseMessage").html('<div class="alert alert-danger">' + errMsg + '</div>');
            }
        });
    });
</script>
