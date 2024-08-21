@extends('layouts.app')

@section('content')
    <div class="login-container">
        <div class="login-box">
            <h2>Login</h2>

            <div id="errorMessages" class="alert alert-danger" style="display: none;"></div>

            <form id="loginForm">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email"
                        required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        email,
                        password
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            // Handle validation errors
                            displayErrors(errorData.errors);
                            throw new Error('Validation failed');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Handle successful login
                    if(data.role == 'Admin') {
                        window.location.href = '/admin/invitations';
                    } else if(data.role == 'Client') {
                        window.location.href = '/client/tasks';
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        function displayErrors(errors) {
            const errorMessagesDiv = document.getElementById('errorMessages');
            errorMessagesDiv.style.display = 'block';
            errorMessagesDiv.innerHTML = '';

            const errorList = document.createElement('ul');

            Object.keys(errors).forEach(key => {
                const errorMessage = errors[key][0];
                const errorItem = document.createElement('li');
                errorItem.textContent = errorMessage;
                errorList.appendChild(errorItem);
            });

            errorMessagesDiv.appendChild(errorList);
        }
    </script>
@endpush
