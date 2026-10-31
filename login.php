<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Sign In - Barangay Waste Portal</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        forest: '#14532d',
                        forestLight: '#166534',
                        fresh: '#16a34a',
                        surface: '#f8fafc'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-surface text-slate-800 antialiased min-h-screen flex flex-col justify-between selection:bg-fresh selection:text-white">

    <!-- Header -->
    <header class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
            <a href="index.php" class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-lg bg-forest flex items-center justify-center text-white font-bold text-[11px] tracking-wider">BW</div>
                <span class="font-bold text-slate-900 text-sm sm:text-base">Barangay Portal</span>
            </a>
            <a href="register.php" class="text-xs sm:text-sm font-medium text-slate-600 hover:text-forest transition">Create Account</a>
        </div>
    </header>

    <!-- Login Container -->
    <main class="flex-grow flex items-center justify-center px-4 py-8 sm:py-12">
        <div class="w-full max-w-sm sm:max-w-md bg-white p-6 sm:p-8 rounded-2xl sm:rounded-3xl shadow-xs border border-slate-200/80">
            <div class="text-center mb-6 sm:mb-8">
                <div class="inline-flex px-3 py-1 rounded-lg bg-green-50 text-forest text-[11px] sm:text-xs font-bold uppercase tracking-wider mb-2 sm:mb-3">
                    Authentication
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Welcome Back</h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Please enter your credentials to access your account</p>
            </div>

            <!-- Alert Box -->
            <div id="alert-box" class="hidden mb-5 p-3.5 sm:p-4 rounded-xl text-xs sm:text-sm font-medium"></div>

            <form id="login-form" class="space-y-4 sm:space-y-5">
                <div>
                    <label class="block text-[11px] sm:text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Email Address</label>
                    <input type="email" id="email" required class="w-full px-3.5 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:bg-white focus:ring-2 focus:ring-forest focus:outline-none transition" placeholder="admin@barangay.gov">
                </div>
                <div>
                    <label class="block text-[11px] sm:text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Password</label>
                    <input type="password" id="password" required class="w-full px-3.5 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:bg-white focus:ring-2 focus:ring-forest focus:outline-none transition" placeholder="••••••••">
                </div>
                <button type="submit" class="w-full py-3.5 bg-forest hover:bg-forestLight text-white font-semibold text-sm rounded-xl shadow-xs transition duration-150">
                    Sign In
                </button>
            </form>

            <div class="mt-6 sm:mt-8 text-center text-xs sm:text-sm text-slate-500 border-t border-slate-100 pt-5 sm:pt-6">
                Don't have an account yet? <a href="register.php" class="text-fresh font-semibold hover:underline">Register here</a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-[11px] sm:text-xs text-slate-500 px-4">
        <p>&copy; 2026-2027 Barangay Waste Management System</p>
    </footer>

    <!-- Script -->
    <script>
        document.getElementById('login-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const alertBox = document.getElementById('alert-box');

            alertBox.classList.add('hidden');

            try {
                let response = await fetch('api/auth/login.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, password })
                });

                let result = await response.json();

                if (response.ok && result.status === 'success') {
                    alertBox.className = "mb-5 p-3.5 sm:p-4 rounded-xl text-xs sm:text-sm font-medium bg-green-50 border border-green-200 text-forest";
                    alertBox.innerText = "Login successful! Redirecting to dashboard...";
                    alertBox.classList.remove('hidden');

                    localStorage.setItem('user', JSON.stringify(result.user));

                    setTimeout(() => {
                        if (result.user.role === 'admin') {
                            window.location.href = 'admin/dashboard.php';
                        } else {
                            window.location.href = 'resident/dashboard.php';
                        }
                    }, 800);
                } else {
                    alertBox.className = "mb-5 p-3.5 sm:p-4 rounded-xl text-xs sm:text-sm font-medium bg-red-50 border border-red-200 text-red-700";
                    alertBox.innerText = result.message || "Invalid email or password.";
                    alertBox.classList.remove('hidden');
                }
            } catch (error) {
                alertBox.className = "mb-5 p-3.5 sm:p-4 rounded-xl text-xs sm:text-sm font-medium bg-red-50 border border-red-200 text-red-700";
                alertBox.innerText = "Connection error. Please check your local server.";
                alertBox.classList.remove('hidden');
            }
        });
    </script>
</body>
</html>
