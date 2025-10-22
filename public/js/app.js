(function () {
  // console.log('Form validation loaded');

  // Basic validation for register form
  const registerForm = document.getElementById("form-register");
  if (registerForm) {
    registerForm.addEventListener("submit", function (e) {
      const username = document.getElementById("username").value;
      const email = document.getElementById("email").value;
      const password = document.getElementById("password").value;
      const confirmPass = document.getElementById("confirm_password").value;

      // Basic checks
      if (username.length < 3) {
        alert("Username must be at least 3 characters");
        e.preventDefault();
        return false;
      }

      if (password.length < 8) {
        alert("Password must be at least 8 characters");
        e.preventDefault();
        return false;
      }

      if (password !== confirmPass) {
        alert("Passwords do not match");
        e.preventDefault();
        return false;
      }

      // Email validation - basic check
      if (!email.includes("@")) {
        alert("Please enter a valid email");
        e.preventDefault();
        return false;
      }
    });
  }

  // Login form validation
  const loginForm = document.getElementById("form-login");
  if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
      const username = document.getElementById("username").value;
      const password = document.getElementById("password").value;

      if (!username || !password) {
        alert("Please complete all fields");
        e.preventDefault();
        return false;
      }
    });
  }
})();
