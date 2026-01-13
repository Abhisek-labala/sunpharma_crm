<!-- jQuery -->
<script src="{{ asset('js/bootstrap/jquery-3.7.1.min.js') }}" type="text/javascript"></script>

<!-- Bootstrap Core JS -->
<script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}" type="text/javascript"></script>

<!-- Custom JS -->
<script src="{{ asset('js/bootstrap/script.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
<script>
    $('#loginForm').on('submit', function (e) {
        e.preventDefault();
        if (!validateLogin()) {
            return; // stop AJAX if validation fails
        }
        const loginBtn = $('#loginButton');
        const originalText = loginBtn.html();
        loginBtn.prop('disabled', true).html('Logging in...');
        let form = $(this);
        let formData = form.serialize();

        $.ajax({
            url: "{{ route('login.submit') }}",
            method: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function (response) {
                toastr.success("Login successful! Redirecting...", "Success");

                setTimeout(function () {
                    window.location.href = response.redirect_to;
                }, 1500);
            },
            error: function (xhr) {
                loginBtn.prop('disabled', false).html(originalText);
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors; // ✅ fixed
                    const firstError = Object.values(errors)[0][0];
                    toastr.error(firstError, 'Validation Error');
                } else {
                    toastr.error("Login failed. Please try again.", 'Error');
                }
            }
        });
    });
    function validateLogin() {
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();

        if (email === '') {
            toastr.warning('Please enter your Email.');
            document.getElementById('email').focus();
            return false;
        }
        if (password === '') {
            toastr.warning('Please enter your Password.');
            document.getElementById('password').focus();
            return false;
        }

        if (password.length < 6) {
            toastr.warning('Password must be at least 6 characters long.');
            document.getElementById('password').focus();
            return false;
        }

        return true; // All good
    }
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.querySelector('.toggle-password');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.textContent = '🙈'; // Change icon to "hide"
        } else {
            passwordInput.type = 'password';
            toggleIcon.textContent = '👁️'; // Change icon to "view"
        }
    }
</script>
