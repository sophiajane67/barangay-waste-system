<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Collection Schedules - Barangay Waste Portal</title>
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
            <a href="login.php" class="text-xs sm:text-sm font-semibold text-white bg-forest hover:bg-forestLight px-3.5 py-2 rounded-lg sm:rounded-xl transition">Sign In</a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 w-full">
        <div class="mb-8">
            <div class="inline-flex px-3 py-1 rounded-lg bg-green-50 text-forest text-[11px] sm:text-xs font-bold uppercase tracking-wider mb-2">
                Public Timetable
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Garbage Collection Schedules</h1>
            <p class="text-slate-500 text-xs sm:text-sm mt-1">Check scheduled pickup times and categories for your zone</p>
        </div>

        <!-- Schedule Cards Grid -->
        <div id="schedule-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <div class="p-6 bg-white rounded-2xl border border-slate-200 text-center text-slate-500 text-sm">
                Loading schedules...
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-[11px] sm:text-xs text-slate-500 px-4">
        <p>&copy; 2026-2027 Barangay Waste Management System</p>
    </footer>

    <!-- Script -->
    <script>
        async function loadSchedules() {
            const container = document.getElementById('schedule-container');
            try {
                let response = await fetch('api/schedules/read.php');
                let result = await response.json();

                if (response.ok && result.schedules && result.schedules.length > 0) {
                    container.innerHTML = '';
                    result.schedules.forEach(s => {
                        container.innerHTML += `
                            <div class="bg-white p-5 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-xs space-y-3">
                                <div class="flex justify-between items-start">
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-green-100 text-forest">
                                        ${s.collection_day}
                                    </span>
                                    <span class="text-xs font-medium text-slate-500">
                                        ${s.collection_time}
                                    </span>
                                </div>
                                <h3 class="font-bold text-slate-900 text-base sm:text-lg">${s.area_name}</h3>
                                <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600">
                                    <span class="font-medium">Category:</span>
                                    <span class="bg-slate-100 px-2.5 py-1 rounded-lg text-slate-700">${s.category_name}</span>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    container.innerHTML = `
                        <div class="col-span-full p-8 bg-white rounded-2xl border border-slate-200 text-center text-slate-500 text-sm">
                            No collection schedules currently posted.
                        </div>
                    `;
                }
            } catch (error) {
                container.innerHTML = `
                    <div class="col-span-full p-8 bg-white rounded-2xl border border-slate-200 text-center text-red-600 text-sm">
                        Unable to load schedules. Please check connection.
                    </div>
                `;
            }
        }

        loadSchedules();
    </script>
</body>
</html>
