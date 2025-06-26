document.getElementById('signupTab').addEventListener('click', function() {
    window.location = "{{ route('registro') }}";
  });

  document.getElementById('switchToSignupLink').addEventListener('click', function() {
    window.location = "{{ route('registro') }}";
  });