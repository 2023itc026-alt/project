<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Trip Planner | Explore the World</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #f39c12;
            --dark: #1a1a2e;
            --glass: rgba(255, 255, 255, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

       body {
    /* If the image fails, this dark blue will show instead */
    background-color: #1a1a2e; 
    
    /* Ensure there are no typos in the filename */
    background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), 
                      url('bh.JPG'); 
                      
    background-size: cover; 
    background-position: center; 
    background-attachment: fixed;
    height: 100vh; 
    color: white; 
    margin: 0;
    overflow: hidden;
}

        /* --- Navigation --- */
        nav {
            display: flex; justify-content: space-between; align-items: center;
            padding: 20px 50px; background: rgba(0, 0, 0, 0.3); backdrop-filter: blur(10px);
        }

        .logo { font-size: 24px; font-weight: 600; color: var(--primary); letter-spacing: 1px; }

        .auth-buttons button, .auth-buttons a {
            background: transparent; border: 1px solid white; color: white;
            padding: 8px 20px; margin-left: 10px; border-radius: 5px; cursor: pointer; transition: 0.3s;
            text-decoration: none; font-size: 14px;
        }

        .auth-buttons .login-btn { background: var(--primary); border: none; }
        .auth-buttons button:hover { opacity: 0.8; transform: translateY(-2px); }

        /* --- Hero Section --- */
        .hero {
            display: flex; flex-direction: column; align-items: center;
            justify-content: center; height: calc(100vh - 80px); text-align: center;
        }

        .hero h1 { font-size: 3rem; margin-bottom: 40px; text-shadow: 2px 2px 10px rgba(0,0,0,0.5); }

        .grid-container {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px; width: 90%; max-width: 1200px;
        }

        .card {
            background: var(--glass); backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.2); padding: 40px 20px;
            border-radius: 20px; cursor: pointer; transition: 0.4s ease;
            text-decoration: none; color: white;
        }

        .card:hover { background: rgba(255, 255, 255, 0.2); transform: translateY(-10px); border-color: var(--primary); }
        .card i { font-size: 40px; margin-bottom: 15px; display: block; font-style: normal; }
        .card h3 { font-size: 1.2rem; margin-bottom: 10px; color: var(--primary); }

        /* --- Modal Styling --- */
        .modal-overlay {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.7); z-index: 1000; justify-content: center; align-items: center;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background: white; color: #333; padding: 40px; border-radius: 15px;
            width: 100%; max-width: 400px; position: relative; box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .modal-content h2 { margin-bottom: 20px; }
        .modal-content input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 8px; }
        .modal-content button { width: 100%; padding: 12px; background: var(--primary); border: none; color: white; border-radius: 8px; cursor: pointer; font-weight: 600; margin-top: 10px; }
        .close-modal { position: absolute; top: 15px; right: 20px; cursor: pointer; font-size: 20px; }
        
        .modal-link { color: var(--primary); text-decoration: none; font-size: 13px; font-weight: 600; cursor: pointer; }
        .modal-footer { margin-top: 20px; text-align: center; font-size: 14px; }
    </style>
</head>
<body>

   <nav>
    <div class="logo">MY TRIP PLANNER</div>
  <div class="auth-buttons">
    <?php if(isset($_SESSION['user']) && isset($_SESSION['email'])): ?>
        <div style="display: flex; align-items: center; gap: 15px;">
            <img src="https://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($_SESSION['email']))); ?>?s=40&d=mp" 
                 alt="Profile" 
                 style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid var(--primary); object-fit: cover;">
            
            <a href="logout.php" style="background: #e74c3c; border:none; margin-left: 0;">Logout</a>
        </div>
    <?php else: ?>
        <button class="login-btn" onclick="openModal('loginModal')">Log In</button>
        <button onclick="openModal('signupModal')">Sign Up</button>
    <?php endif; ?>
</div>
</nav>

    <div class="hero">
        <h1>Where to next, Adventurer?</h1>
        <div class="grid-container">
            <div class="card"><i>📍</i><h3>Travel Planning</h3><p>Essential itineraries and route mapping.</p></div>
            <div class="card"><i>🚐</i><h3>Vehicles & Guides</h3><p>Meet our certified drivers and luxury fleet.</p></div>
            <div class="card"><i>🎁</i><h3>Trip Packages</h3><p>Explore curated all-inclusive bundles.</p></div>
            <div class="card"><i>ℹ️</i><h3>About Us</h3><p>The story behind our travel mission.</p></div>
        </div>
    </div>

    <div id="loginModal" class="modal-overlay">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('loginModal')">&times;</span>
            <h2>Login</h2>
            <form action="process.php" method="POST">
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="password" placeholder="Password" required>
                <div style="text-align: right;">
                    <span class="modal-link" onclick="closeModal('loginModal'); openModal('forgotModal')">Forgot Password?</span>
                </div>
                <button type="submit" name="login_submit">Sign In</button>
            </form>
            <div class="modal-footer">
                Don't have an account? <span class="modal-link" onclick="closeModal('loginModal'); openModal('signupModal')">Register Here</span>
            </div>
        </div>
    </div>

    <div id="signupModal" class="modal-overlay">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('signupModal')">&times;</span>
            <h2>Create Account</h2>
            <form action="process.php" method="POST">
                <input type="text" name="fullname" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="password" placeholder="Create Password" required>
                <button type="submit" name="signup_submit">Register</button>
            </form>
            <div class="modal-footer">
                Already a member? <span class="modal-link" onclick="closeModal('signupModal'); openModal('loginModal')">Login</span>
            </div>
        </div>
    </div>

    <div id="forgotModal" class="modal-overlay">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('forgotModal')">&times;</span>
            <h2>Reset Password</h2>
            <p style="font-size: 13px; margin-bottom: 10px;">Enter your email to receive a reset link.</p>
            <form action="process.php" method="POST">
                <input type="email" name="email" placeholder="Email Address" required>
                <button type="submit" name="forgot_submit">Send Link</button>
            </form>
            <div class="modal-footer">
                <span class="modal-link" onclick="closeModal('forgotModal'); openModal('loginModal')">Back to Login</span>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) { document.getElementById(id).style.display = 'flex'; }
        function closeModal(id) { document.getElementById(id).style.display = 'none'; }
        
        window.onload = function() {
            <?php if(!isset($_SESSION['user'])): ?>
                openModal('loginModal');
            <?php endif; ?>
        };

        window.onclick = function(event) {
            if (event.target.classList.contains('modal-overlay')) {
                event.target.style.display = "none";
            }
        }
    </script>
</body>
</html>