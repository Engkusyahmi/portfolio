<?= $this->include('layout/header') ?>

<style>
/* Water Conservation Theme Register Page */
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
    font-family: 'Open Sans', sans-serif;
}

.auth-page-wrapper {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #0077be, #00a8e6);
    position: relative;
    overflow: hidden;
    padding: 20px 0;
}

/* Animated water background */
.auth-page-wrapper::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="%23ffffff"></path><path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="%23ffffff"></path></svg>') repeat-x;
    background-size: 1200px 120px;
    animation: wave 15s ease-in-out infinite;
    opacity: 0.3;
}

@keyframes wave {
    0%, 100% { transform: translateX(0) translateY(0); }
    25% { transform: translateX(-25px) translateY(-10px); }
    50% { transform: translateX(-50px) translateY(0); }
    75% { transform: translateX(-25px) translateY(10px); }
}

.register-box {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 40px;
    width: 100%;
    max-width: 500px;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    overflow-y: auto;
    max-height: 95vh;
    position: relative;
    z-index: 10;
    border: 1px solid rgba(255, 255, 255, 0.2);
    margin: 20px;
}

.register-box::before {
    content: "🌊";
    position: absolute;
    top: -20px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 40px;
    background: linear-gradient(135deg, #0077be, #00a8e6);
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.register-box h2 {
    text-align: center;
    color: #01579b;
    font-weight: 700;
    margin-bottom: 30px;
    margin-top: 20px;
    font-size: 28px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.register-box h2::after {
    content: "";
    display: block;
    width: 80px;
    height: 3px;
    background: linear-gradient(90deg, #0077be, #00a8e6);
    margin: 15px auto 0;
    border-radius: 2px;
}

/* Enhanced form styling */
.form-group {
    margin-bottom: 20px;
    position: relative;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #01579b;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-control {
    width: 100%;
    padding: 15px 20px;
    border: 2px solid #e3f2fd;
    border-radius: 12px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.9);
    color: #333;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: #0077be;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(0, 119, 190, 0.1);
    transform: translateY(-2px);
}

.form-control::placeholder {
    color: #90a4ae;
    font-style: italic;
}

/* Eye toggle styling - UPDATED for Register alignment */
.input-with-icon {
    position: relative;
    /* Ensure this container properly wraps the input and icon vertically */
    display: block; /* or flex, but block with padding on input is fine */
}

.input-with-icon input {
    /* Adjust padding-right to make space for the icon */
    padding-right: 50px;
    /* Ensure the input's height determines the container's height for centering */
    box-sizing: border-box; /* Important for consistent padding/height */
}

.input-with-icon .eye-icon {
    position: absolute;
    right: 15px; /* Adjust right position for better alignment */
    top: 0; /* Align to the top of the parent .input-with-icon */
    bottom: 0; /* Align to the bottom of the parent .input-with-icon */
    margin: auto 0; /* This will vertically center the icon */
    cursor: pointer;
    width: 20px; /* Adjusted icon size for consistency */
    height: 20px; /* Adjusted icon size for consistency */
    fill: #90a4ae;
    transition: all 0.3s ease;
    z-index: 2;
    display: none; /* Hidden by default, shown by JS */
}

.input-with-icon .eye-icon.active {
    display: block; /* Show when text is typed */
}

.input-with-icon .eye-icon:hover {
    fill: #0077be;
    transform: scale(1.1); /* Only scale on hover, remove translateY */
}

/* Enhanced button styling */
.btn-blue {
    background: linear-gradient(135deg, #0077be, #00a8e6);
    border: none;
    color: white;
    padding: 15px 30px;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 119, 190, 0.3);
}

.btn-blue::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-blue:hover {
    background: linear-gradient(135deg, #01579b, #0077be);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 119, 190, 0.4);
}

.btn-blue:hover::before {
    left: 100%;
}

.btn-blue:active {
    transform: translateY(-1px);
}

/* Alert styling */
.alert {
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    font-weight: 500;
    border: none;
}

.alert-danger {
    background: linear-gradient(135deg, #ffebee, #ffcdd2);
    color: #c62828;
    border-left: 4px solid #f44336;
}

.alert-success {
    background: linear-gradient(135deg, #e8f5e8, #c8e6c9);
    color: #2e7d32;
    border-left: 4px solid #4caf50;
}

/* Link styling */
.register-box p {
    text-align: center;
    margin-top: 25px;
    color: #546e7a;
    font-size: 14px;
}

.register-box p a {
    color: #0077be;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
}

.register-box p a::after {
    content: "";
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, #0077be, #00a8e6);
    transition: width 0.3s ease;
}

.register-box p a:hover {
    color: #01579b;
}

.register-box p a:hover::after {
    width: 100%;
}

/* Password strength indicator */
.password-strength {
    margin-top: 8px;
    height: 4px;
    background: #e0e0e0;
    border-radius: 2px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.password-strength-bar {
    height: 100%;
    width: 0%;
    transition: all 0.3s ease;
    border-radius: 2px;
}

.strength-weak { background: #f44336; width: 25%; }
.strength-fair { background: #ff9800; width: 50%; }
.strength-good { background: #2196f3; width: 75%; }
.strength-strong { background: #4caf50; width: 100%; }

.password-requirements {
    margin-top: 10px;
    font-size: 12px;
    color: #666;
}

.requirement {
    display: flex;
    align-items: center;
    margin-bottom: 4px;
}

.requirement.met {
    color: #4caf50;
}

.requirement::before {
    content: "✗";
    margin-right: 8px;
    color: #f44336;
    font-weight: bold;
}

.requirement.met::before {
    content: "✓";
    color: #4caf50;
}

/* Responsive design */
@media (max-width: 768px) {
    .register-box {
        margin: 15px;
        padding: 30px 25px;
        max-width: none;
    }
    
    .register-box h2 {
        font-size: 24px;
    }
    
    .form-control {
        padding: 12px 16px;
        font-size: 14px;
    }
    
    .btn-blue {
        padding: 12px 25px;
        font-size: 14px;
    }
    
    .form-group {
        margin-bottom: 18px;
    }
}

@media (max-width: 480px) {
    .auth-page-wrapper {
        padding: 10px 0;
    }
    
    .register-box {
        padding: 25px 20px;
        margin: 10px;
    }
    
    .register-box::before {
        width: 60px;
        height: 60px;
        font-size: 30px;
        top: -15px;
    }
    
    .register-box h2 {
        font-size: 20px;
        margin-top: 15px;
    }
    
    .form-group {
        margin-bottom: 15px;
    }
}

/* Loading animation */
.btn-blue.loading {
    pointer-events: none;
    opacity: 0.7;
}

.btn-blue.loading::after {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid transparent;
    border-top: 2px solid #ffffff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<div class="auth-page-wrapper">
    <div class="register-box">
        <h2>Join WaterWise</h2>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <strong>Error:</strong> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('message')): ?>
            <div class="alert alert-success">
                <strong>Success:</strong> <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('register') ?>" method="post" id="registerForm">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required class="form-control" placeholder="Choose a unique username" autocomplete="username">
            </div>

            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="fullname" required class="form-control" placeholder="Enter your full name" autocomplete="name">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required class="form-control" placeholder="Enter your email address" autocomplete="email">
            </div>

            <div class="form-group input-with-icon">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required class="form-control" placeholder="Create a strong password" autocomplete="new-password">
                <div class="password-strength">
                    <div class="password-strength-bar" id="strengthBar"></div>
                </div>
                <div class="password-requirements" id="requirements">
                    <div class="requirement" id="length">At least 8 characters</div>
                    <div class="requirement" id="uppercase">One uppercase letter</div>
                    <div class="requirement" id="lowercase">One lowercase letter</div>
                    <div class="requirement" id="number">One number</div>
                </div>
            </div>

            <div class="form-group input-with-icon">
                <label for="password_confirm">Confirm Password</label>
                <input type="password" id="password_confirm" name="password_confirm" required class="form-control" placeholder="Confirm your password" autocomplete="new-password">
                </div>

            <button type="submit" class="btn btn-blue btn-effect btn-block" id="registerBtn">
                Create Account
            </button>
        </form>

        <p>
            Already have an account? <a href="<?= base_url('login') ?>">Sign in here</a>
        </p>
    </div>
</div>

<script>
// Function to create the eye icon SVG element
function createEyeIcon(id) {
    const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    svg.setAttribute("class", "eye-icon");
    svg.setAttribute("viewBox", "0 0 24 24");
    svg.innerHTML = '<path d="M12 5c-7 0-11 7-11 7s4 7 11 7 11-7 11-7-4-7-11-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"/><circle cx="12" cy="12" r="2.5"/>';
    // Set initial styles directly or via class
    svg.style.fill = '#90a4ae';
    svg.style.transition = 'all 0.3s ease';
    svg.onclick = () => togglePassword(id, svg); // Pass both id and svg element
    return svg;
}

// Function to toggle password visibility
function togglePassword(id, icon) {
    const input = document.getElementById(id);
    if (input.type === "password") {
        input.type = "text";
        icon.style.fill = '#0077be';
        icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
    } else {
        input.type = "password";
        icon.style.fill = '#90a4ae';
        icon.innerHTML = '<path d="M12 5c-7 0-11 7-11 7s4 7 11 7 11-7 11-7-4-7-11-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"/><circle cx="12" cy="12" r="2.5"/>';
    }
}

// Function to handle dynamic eye icon visibility for a given input
function setupEyeIconToggle(inputId) {
    const input = document.getElementById(inputId);
    const inputContainer = input.parentElement;

    input.addEventListener('input', function() {
        let eyeIcon = inputContainer.querySelector('.eye-icon');

        if (this.value.length > 0) {
            if (!eyeIcon) {
                eyeIcon = createEyeIcon(inputId);
                inputContainer.appendChild(eyeIcon);
            }
            eyeIcon.classList.add('active');
        } else {
            if (eyeIcon) {
                eyeIcon.classList.remove('active');
            }
        }
    });
}

// Setup eye icon toggle for both password fields
setupEyeIconToggle('password');
setupEyeIconToggle('password_confirm');


// Password strength checker
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strengthBar = document.getElementById('strengthBar');
    const requirements = {
        length: password.length >= 8,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        number: /\d/.test(password)
    };
    
    // Update requirement indicators
    Object.keys(requirements).forEach(req => {
        const element = document.getElementById(req);
        if (requirements[req]) {
            element.classList.add('met');
        } else {
            element.classList.remove('met');
        }
    });
    
    // Calculate strength
    const metRequirements = Object.values(requirements).filter(Boolean).length;
    strengthBar.className = 'password-strength-bar';
    
    if (metRequirements === 1) {
        strengthBar.classList.add('strength-weak');
    } else if (metRequirements === 2) {
        strengthBar.classList.add('strength-fair');
    } else if (metRequirements === 3) {
        strengthBar.classList.add('strength-good');
    } else if (metRequirements === 4) {
        strengthBar.classList.add('strength-strong');
    }
});

// Form validation
document.getElementById('registerForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirm').value;
    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Passwords do not match!');
        return;
    }
    
    if (password.length < 8) {
        e.preventDefault();
        alert('Password must be at least 8 characters long!');
        return;
    }
    
    // Add loading state
    const btn = document.getElementById('registerBtn');
    btn.classList.add('loading');
    btn.textContent = 'Creating Account...';
});

// Add floating label effect
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
    });
    
    input.addEventListener('blur', function() {
        // Check if the input is empty or if it's a password field with an active eye icon
        const eyeIcon = this.parentElement.querySelector('.eye-icon');
        if (this.value === '' && (!eyeIcon || !eyeIcon.classList.contains('active'))) {
            this.parentElement.classList.remove('focused');
        }
    });
});
</script>

<?= $this->include('layout/footer') ?>