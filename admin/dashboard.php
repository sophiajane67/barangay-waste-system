<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Admin Dashboard - Barangay Waste Management</title>
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-lg bg-forest flex items-center justify-center text-white font-bold text-[11px] tracking-wider">AD</div>
                <div>
                    <span class="block font-bold text-slate-900 text-sm sm:text-base leading-tight">Admin Portal</span>
                    <span class="block text-[10px] text-slate-500" id="admin-greeting">System Administrator</span>
                </div>
            </div>
            <button onclick="logout()" class="px-3.5 py-2 text-xs sm:text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">
                Sign Out
            </button>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 w-full space-y-8">

        <!-- Stat Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
            <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Reports</span>
                <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1" id="stat-total-reports">0</div>
            </div>
            <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Active Schedules</span>
                <div class="text-2xl sm:text-3xl font-extrabold text-forest mt-1" id="stat-total-schedules">0</div>
            </div>
            <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Pending Issues</span>
                <div class="text-2xl sm:text-3xl font-extrabold text-amber-600 mt-1" id="stat-pending-reports">0</div>
            </div>
        </div>

        <!-- Section: Create Collection Schedule -->
        <section class="bg-white p-6 sm:p-8 rounded-2xl sm:rounded-3xl shadow-xs border border-slate-200/80">
            <div class="mb-6">
                <span class="px-3 py-1 rounded-lg bg-green-50 text-forest text-[11px] sm:text-xs font-bold uppercase tracking-wider">
                    Schedule Management
                </span>
                <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight mt-1">Add Collection Schedule</h2>
                <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Post garbage pickup days and assigned categories per zone</p>
            </div>

            <!-- Schedule Alert Box -->
            <div id="schedule-alert" class="hidden mb-5 p-3.5 sm:p-4 rounded-xl text-xs sm:text-sm font-medium"></div>

            <form id="schedule-form" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-[11px] sm:text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Zone / Area Name</label>
                        <input type="text" id="area_name" required class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:bg-white focus:ring-2 focus:ring-forest focus:outline-none transition" placeholder="Poblacion Zone 2">
                    </div>
                    <div>
                        <label class="block text-[11px] sm:text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Collection Day</label>
                        <select id="collection_day" required class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:bg-white focus:ring-2 focus:ring-forest focus:outline-none transition">
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] sm:text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Time</label>
                        <input type="time" id="collection_time" required class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:bg-white focus:ring-2 focus:ring-forest focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[11px] sm:text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Waste Category</label>
                        <select id="schedule_category_id" required class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:bg-white focus:ring-2 focus:ring-forest focus:outline-none transition">
                            <option value="1">Biodegradable Waste</option>
                            <option value="2">Non-Biodegradable / Recyclable</option>
                            <option value="3">Special / Hazardous Waste</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="px-6 py-3 bg-forest hover:bg-forestLight text-white font-semibold text-sm rounded-xl shadow-xs transition duration-150">
                    Post New Schedule
                </button>
            </form>
        </section>

        <!-- Section: All Resident Waste Reports -->
        <section class="space-y-4">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">Barangay Waste Reports</h3>
                    <p class="text-slate-500 text-xs sm:text-sm">Manage incoming resident issues and complaints</p>
                </div>
                <button onclick="loadAllData()" class="px-3.5 py-2 text-xs font-semibold text-forest bg-green-50 hover:bg-green-100 rounded-lg transition">
                    Refresh All Data
                </button>
            </div>

            <!-- Reports List -->
            <div id="all-reports-container" class="grid grid-cols-1 gap-4">
                <div class="p-6 bg-white rounded-2xl border border-slate-200 text-center text-slate-500 text-sm">
                    Loading reports data...
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-[11px] sm:text-xs text-slate-500 px-4 mt-8">
        <p>&copy; 2026-2027 Barangay Waste Management System</p>
    </footer>

    <!-- Script Logic -->
    <script>
        let userSession = JSON.parse(localStorage.getItem('user'));
        if (!userSession || userSession.role !== 'admin') {
            if (!userSession) {
                window.location.href = '../login.php';
            }
        } else {
            document.getElementById('admin-greeting').innerText = userSession.full_name;
        }

        function logout() {
            localStorage.removeItem('user');
            window.location.href = '../login.php';
        }

        async function loadAllData() {
            loadReports();
            loadSchedulesCount();
        }

        async function loadReports() {
            const container = document.getElementById('all-reports-container');
            try {
                let response = await fetch('../api/reports/read.php');
                let result = await response.json();

                if (response.ok && result.reports && result.reports.length > 0) {
                    document.getElementById('stat-total-reports').innerText = result.count;
                    let pending = result.reports.filter(r => r.status === 'Pending').length;
                    document.getElementById('stat-pending-reports').innerText = pending;

                    container.innerHTML = '';
                    result.reports.forEach(r => {
                        let statusColor = r.status === 'Pending' ? 'bg-amber-100 text-amber-800' : 'bg-green-100 text-forest';
                        container.innerHTML += `
                            <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-3">
                                <div class="flex flex-wrap justify-between items-center gap-2">
                                    <div class="flex items-center space-x-2">
                                        <span class="px-2.5 py-0.5 rounded text-xs font-bold uppercase tracking-wider bg-slate-100 text-slate-700">
                                            ${r.reference_no}
                                        </span>
                                        <span class="px-2.5 py-0.5 rounded text-xs font-bold ${statusColor}">
                                            ${r.status}
                                        </span>
                                    </div>
                                    <span class="text-xs text-slate-400">Filed by: ${r.resident_name}</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-base">${r.category_name}</h4>
                                    <p class="text-xs sm:text-sm text-slate-600 mt-1">${r.description}</p>
                                </div>
                                <div class="pt-2 border-t border-slate-100 flex flex-wrap justify-between items-center text-xs text-slate-500 gap-2">
                                    <span>Location: ${r.location}</span>
                                    <span>Date: ${r.created_at}</span>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    container.innerHTML = `
                        <div class="p-6 bg-white rounded-2xl border border-slate-200 text-center text-slate-500 text-sm">
                            No reports found in the system.
                        </div>
                    `;
                }
            } catch (error) {
                container.innerHTML = `
                    <div class="p-6 bg-white rounded-2xl border border-slate-200 text-center text-red-600 text-sm">
                        Failed to load reports. Please check your connection.
                    </div>
                `;
            }
        }

        async function loadSchedulesCount() {
            try {
                let response = await fetch('../api/schedules/read.php');
                let result = await response.json();
                if (response.ok && result.schedules) {
                    document.getElementById('stat-total-schedules').innerText = result.count;
                }
            } catch (error) {}
        }

        // Add Schedule Event
        document.getElementById('schedule-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const area_name = document.getElementById('area_name').value;
            const collection_day = document.getElementById('collection_day').value;
            const collection_time = document.getElementById('collection_time').value;
            const category_id = document.getElementById('schedule_category_id').value;
            const alertBox = document.getElementById('schedule-alert');

            alertBox.classList.add('hidden');

            try {
                let response = await fetch('../api/schedules/create.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ area_name, collection_day, collection_time, category_id })
                });

                let result = await response.json();

                if (response.ok && result.status === 'success') {
                    alertBox.className = "mb-5 p-3.5 sm:p-4 rounded-xl text-xs sm:text-sm font-medium bg-green-50 border border-green-200 text-forest";
                    alertBox.innerText = result.message || "Schedule added successfully!";
                    alertBox.classList.remove('hidden');

                    document.getElementById('schedule-form').reset();
                    loadAllData();
                } else {
                    alertBox.className = "mb-5 p-3.5 sm:p-4 rounded-xl text-xs sm:text-sm font-medium bg-red-50 border border-red-200 text-red-700";
                    alertBox.innerText = result.message || "Unable to add schedule.";
                    alertBox.classList.remove('hidden');
                }
            } catch (error) {
                alertBox.className = "mb-5 p-3.5 sm:p-4 rounded-xl text-xs sm:text-sm font-medium bg-red-50 border border-red-200 text-red-700";
                alertBox.innerText = "Connection error. Please check your local server.";
                alertBox.classList.remove('hidden');
            }
        });

        // Initial Load
        loadAllData();
    </script>
</body>
</html>
