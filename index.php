<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Barangay Waste Management & Collection Monitoring System</title>
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

    <!-- Header / Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="index.php" class="flex items-center space-x-2.5">
                <div class="w-9 h-9 rounded-lg bg-forest flex items-center justify-center text-white font-bold text-xs tracking-wider shrink-0">
                    BW
                </div>
                <div class="truncate">
                    <span class="block font-bold text-slate-900 text-sm sm:text-base leading-tight truncate">Barangay Waste Portal</span>
                    <span class="block text-[10px] sm:text-xs text-slate-500 truncate">Official Monitoring System</span>
                </div>
            </a>
            <div class="flex items-center space-x-2 sm:space-x-3 shrink-0">
                <a href="login.php" class="px-3 py-2 text-xs sm:text-sm font-medium text-slate-700 hover:text-forest transition">Sign In</a>
                <a href="register.php" class="px-3.5 py-2 text-xs sm:text-sm font-semibold text-white bg-forest hover:bg-forestLight rounded-lg sm:rounded-xl shadow-xs transition">Register</a>
            </div>
        </div>
    </header>

    <!-- Main Hero -->
    <main class="flex-grow flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 md:py-16 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                <!-- Left Hero Text -->
                <div class="lg:col-span-7 space-y-4 sm:space-y-6 text-left">
                    <div class="inline-flex">
                        <span class="px-3 py-1 rounded-full text-[11px] sm:text-xs font-semibold bg-green-100 text-forest">
                            Zero-Budget Digital Governance
                        </span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Cleaner Community, <span class="text-fresh">Smarter Collection.</span>
                    </h1>
                    <p class="text-slate-600 text-sm sm:text-base md:text-lg leading-relaxed">
                        Access real-time garbage collection schedules, submit environmental issue reports, and monitor resolution progress transparently online.
                    </p>

                    <!-- Mobile Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-2 w-full sm:w-auto">
                        <a href="schedules.php" class="w-full sm:w-auto px-6 py-3.5 bg-forest hover:bg-forestLight text-white font-semibold text-sm rounded-xl shadow-xs transition text-center">
                            View Collection Schedules
                        </a>
                        <a href="login.php" class="w-full sm:w-auto px-6 py-3.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 font-semibold text-sm rounded-xl transition text-center">
                            Resident Portal
                        </a>
                    </div>
                </div>

                <!-- Right Cards -->
                <div class="lg:col-span-5 bg-white p-5 sm:p-8 rounded-2xl sm:rounded-3xl shadow-xs border border-slate-200/80 space-y-4 sm:space-y-6">
                    <h2 class="text-base sm:text-lg font-bold text-slate-900 border-b border-slate-100 pb-3">System Core Features</h2>
                    
                    <div class="flex items-start space-x-3.5">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-green-50 text-forest font-bold text-xs sm:text-sm flex items-center justify-center shrink-0">01</div>
                        <div>
                            <h3 class="font-semibold text-slate-900 text-sm sm:text-base">Dynamic Schedules</h3>
                            <p class="text-xs sm:text-sm text-slate-500">Exact collection days, times, and categories per zone.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3.5">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-green-50 text-forest font-bold text-xs sm:text-sm flex items-center justify-center shrink-0">02</div>
                        <div>
                            <h3 class="font-semibold text-slate-900 text-sm sm:text-base">Instant Issue Reporting</h3>
                            <p class="text-xs sm:text-sm text-slate-500">Report missed collections or illegal dumping with unique tracking IDs.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3.5">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-green-50 text-forest font-bold text-xs sm:text-sm flex items-center justify-center shrink-0">03</div>
                        <div>
                            <h3 class="font-semibold text-slate-900 text-sm sm:text-base">Live Status Updates</h3>
                            <p class="text-xs sm:text-sm text-slate-500">Track complaints from pending review to final resolution.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-4 sm:py-6 text-center text-[11px] sm:text-xs text-slate-500 px-4">
        <p>&copy; 2026-2027 Barangay Waste Management System | Academic Credit Project (ITP09)</p>
    </footer>

</body>
</html>
