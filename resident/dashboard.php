<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Resident Portal - Barangay Waste Management</title>
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
                <div class="w-8 h-8 rounded-lg bg-forest flex items-center justify-center text-white font-bold text-[11px] tracking-wider">RD</div>
                <div>
                    <span class="block font-bold text-slate-900 text-sm sm:text-base leading-tight">Resident Portal</span>
                    <span class="block text-[10px] text-slate-500" id="user-greeting">Welcome</span>
                </div>
            </div>
            <button onclick="logout()" class="px-3.5 py-2 text-xs sm:text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">
                Sign Out
            </button>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 w-full space-y-8">

        <!-- Section: Submit New Waste Report -->
        <section class="bg-white p-6 sm:p-8 rounded-2xl sm:rounded-3xl shadow-xs border border-slate-200/80">
            <div class="mb-6">
                <span class="px-3 py-1 rounded-lg bg-green-50 text-forest text-[11px] sm:text-xs font-bold uppercase tracking-wider">
                    Issue Reporting
                </span>
                <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight mt-1">Submit a Waste Concern</h2>
                <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Report illegal dumping, overflowing bins, or missed collection</p>
            </div>

            <!-- Report Alert Box -->
            <div id="report-alert" class="hidden mb-5 p-3.5 sm:p-4 rounded-xl text-xs sm:text-sm font-medium"></div>

            <form id="report-form" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] sm:text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Waste Category</label>
                        <select id="category_id" required class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:bg-white focus:ring-2 focus:ring-forest focus:outline-none transition">
                            <option value="1">Missed Garbage Collection</option>
                            <option value="2">Overflowing Garbage</option>
                            <option value="3">Improper Waste Disposal</option>
                            <option value="4">Illegal Dumping</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] sm:text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Specific Location / Zone</label>
                        <input type="text" id="location" required class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:bg-white focus:ring-2 focus:ring-forest focus:outline-none transition" placeholder="Zone 4 Main Road">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] sm:text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Description Details</label>
                    <textarea id="description" rows="3" required class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:bg-white focus:ring-2 focus:ring-forest focus:outline-none transition" placeholder="Describe the issue clearly..."></textarea>
                </div>
                <button type="submit" class="px-6 py-3 bg-forest hover:bg-forestLight text-white font-semibold text-sm rounded-xl shadow-xs transition duration-150">
                    Submit Waste Report
                </button>
            </form>
        </section>

        <!-- Section: Track Submitted Reports -->
        <section class="space-y-4">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">Your Submitted Reports</h3>
                    <p class="text-slate-500 text-xs sm:text-sm">Track real-time resolution status of your complaints</p>
                </div>
                <button onclick="loadResidentReports()" class="px-3.5 py-2 text-xs font-semibold text-forest bg-green-50 hover:bg-green-100 rounded-lg transition">
                    Refresh List
                </button>
            </div>

            <!-- Reports List Container -->
            <div id="reports-container" class="grid grid-cols-1 gap-4">
                <div class="p-6 bg-white rounded-2xl border border-slate-200 text-center text-slate-500 text-sm">
                    Loading your reports...
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
        // Check session storage
        let userSession = JSON.parse(localStorage.getItem('user'));
        if (!userSession || userSession.role !== 'resident') {
            // Fallback for testing: if admin is testing resident dashboard, allow or redirect
            if (!userSession) {
                window.location.href = '../login.php';
            }
        } else {
            document.getElementById('user-greeting').innerText = userSession.full_name;
        }

        function logout() {
            localStorage.removeItem('user');
            window.location.href = '../login.php';
        }

        // Load reports for this user
        async function loadResidentReports() {
            const container = document.getElementById('reports-container');
            const userId = userSession ? userSession.id : 1; // Default to ID 1 for testing

            try {
                let response = await fetch(`../api/reports/read.php?resident_id=${userId}`);
                let result = await response.json();

                if (response.ok && result.reports && result.reports.length > 0) {
                    container.innerHTML = '';
                    result.reports.forEach(r => {
                        let statusColor = r.status === 'Pending' ? 'bg-amber-100 text-amber-800' : 'bg-green-100 text-forest';
                        container.innerHTML += `
                            <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                <div class="space-y-1.5">
                                    <div class="flex items-center space-x-2">
                                        <span class="px-2.5 py-0.5 rounded text-xs font-bold uppercase tracking-wider bg-slate-100 text-slate-700">
                                            ${r.reference_no}
                                        </span>
                                        <span class="px-2.5 py-0.5 rounded text-xs font-bold ${statusColor}">
                                            ${r.status}
                                        </span>
                                    </div>
                                    <h4 class="font-bold text-slate-900 text-base">${r.category_name}</h4>
                                    <p class="text-xs sm:text-sm text-slate-600">${r.description}</p>
                                    <div class="text-xs text-slate-400">Location: ${r.location} | Submitted: ${r.created_at}</div>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    container.innerHTML = `
                        <div class="p-6 bg-white rounded-2xl border border-slate-200 text-center text-slate-500 text-sm">
                            You have not submitted any waste reports yet.
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

        // Handle Report Submission
        document.getElementById('report-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const category_id = document.getElementById('category_id').value;
            const location = document.getElementById('location').value;
            const description = document.getElementById('description').value;
            const resident_id = userSession ? userSession.id : 1;
            const alertBox = document.getElementById('report-alert');

            alertBox.classList.add('hidden');

            try {
                let response = await fetch('../api/reports/create.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ resident_id, category_id, description, location })
                });

                let result = await response.json();

                if (response.ok && result.status === 'success') {
                    alertBox.className = "mb-5 p-3.5 sm:p-4 rounded-xl text-xs sm:text-sm font-medium bg-green-50 border border-green-200 text-forest";
                    alertBox.innerText = `Report submitted successfully! Reference No: ${result.reference_no}`;
                    alertBox.classList.remove('hidden');

                    document.getElementById('report-form').reset();
                    loadResidentReports();
                } else {
                    alertBox.className = "mb-5 p-3.5 sm:p-4 rounded-xl text-xs sm:text-sm font-medium bg-red-50 border border-red-200 text-red-700";
                    alertBox.innerText = result.message || "Unable to submit report.";
                    alertBox.classList.remove('hidden');
                }
            } catch (error) {
                alertBox.className = "mb-5 p-3.5 sm:p-4 rounded-xl text-xs sm:text-sm font-medium bg-red-50 border border-red-200 text-red-700";
                alertBox.innerText = "Connection error. Please check your local server.";
                alertBox.classList.remove('hidden');
            }
        });

        // Initial load
        loadResidentReports();
    </script>
</body>
</html>
