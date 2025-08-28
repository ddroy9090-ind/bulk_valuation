<?php include 'includes/common-header.php' ?>

<div class="container-fluid cms-layout">
    <div class="row h-100">

        <!-- Sidebar -->
        <?php include 'includes/sidebar.php' ?>

        <!-- Main Content -->
        <div class="col content" id="content">
            <!-- Top Navbar -->
            <?php include 'includes/topbar.php' ?>

            <!-- Dashboard Content -->
            <div class="p-2">
                <!-- Reports Library Section -->
                <section class="reports-wrapper">
                    <div class="container">

                        <!-- Title -->
                        <div class="row mb-3">
                            <div class="col-lg-8">
                                <div class="report-library">
                                    <h1 class="report-title">Analytics Dashboard</h1>
                                    <p>Track your valuation report performance and business insights</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="container-fluid" id="dashboard-section">
                    <div class="row g-3 mb-2">
                        <div class="col-6 col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <span class="stat-title">Total Reports</span>
                                    <img src="assets/icons/report.png" class="icon-stat" alt="Report">
                                    <div class="stat-value">1,247</div>
                                    <div class="stat-change">+12% from last month</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <span class="stat-title">Revenue</span>
                                    <img src="assets/icons/dollar-symbol.png" class="icon-stat" alt="Revenue">
                                    <div class="stat-value">$45,231</div>
                                    <div class="stat-change">+8% from last month</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <span class="stat-title">Active Clients</span>
                                    <img src="assets/icons/user.png" class="icon-stat" alt="Client">
                                    <div class="stat-value">89</div>
                                    <div class="stat-change">+3 new this month</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <span class="stat-title">Avg. Report Value</span>
                                    <img src="assets/icons/grow-up.png" class="icon-stat" alt="Value">
                                    <div class="stat-value">$2.1M</div>
                                    <div class="stat-change">+5% from last month</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-2 align-items-stretch reports-wrapper">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column">
                                    <!-- Heading Top -->
                                    <div class="section-title mb-3 d-flex align-items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="text-danger">
                                            <path d="M3 3v16a2 2 0 0 0 2 2h16"></path>
                                            <path d="M18 17V9"></path>
                                            <path d="M13 17V5"></path>
                                            <path d="M8 17v-3"></path>
                                        </svg>
                                        Monthly Report Generation
                                    </div>

                                    <!-- Content Center -->
                                    <div
                                        class="chart-placeholder flex-grow-1 d-flex flex-column justify-content-center align-items-center text-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="mb-2">
                                            <path d="M3 3v16a2 2 0 0 0 2 2h16"></path>
                                            <path d="M18 17V9"></path>
                                            <path d="M13 17V5"></path>
                                            <path d="M8 17v-3"></path>
                                        </svg>
                                        <div>Chart visualization coming soon</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column">
                                    <!-- Heading Top -->
                                    <div class="section-title mb-3 d-flex align-items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-trending-up w-5 h-5 text-danger"
                                            data-lov-id="src/pages/Analytics.tsx:106:18" data-lov-name="TrendingUp"
                                            data-component-path="src/pages/Analytics.tsx" data-component-line="106"
                                            data-component-file="Analytics.tsx" data-component-name="TrendingUp"
                                            data-component-content="%7B%22className%22%3A%22w-5%20h-5%20text-primary%22%7D">
                                            <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                            <polyline points="16 7 22 7 22 13"></polyline>
                                        </svg>
                                        Revenue Trend
                                    </div>

                                    <!-- Content Center -->
                                    <div
                                        class="chart-placeholder flex-grow-1 d-flex flex-column justify-content-center align-items-center text-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="mb-2">
                                            <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                            <polyline points="16 7 22 7 22 13"></polyline>
                                        </svg>
                                        <div>Chart visualization coming soon</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row g-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="section-title">
                                        <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png"
                                            class="section-icon" alt>
                                        Recent Activity
                                    </div>
                                    <div class="activity-list">
                                        <div class="activity-item">
                                            <span class="activity-dot"></span>
                                            <span class="activity-details">
                                                <span style="color:#e93838;">Generated 5 reports for ABC
                                                    Properties</span>
                                                <p class="activity-meta">2 hours ago &bull; New York</p>
                                            </span>
                                        </div>
                                        <div class="activity-item">
                                            <span class="activity-dot"></span>
                                            <span class="activity-details">
                                                <span style="color:#e93838;">Completed valuation for 123 Main St</span>
                                                <p class="activity-meta">4 hours ago &bull; Los Angeles</p>
                                            </span>
                                        </div>
                                        <div class="activity-item">
                                            <span class="activity-dot"></span>
                                            <span class="activity-details">
                                                <span style="color:#e93838;">New client registration: John Smith</span>
                                                <p class="activity-meta">6 hours ago &bull; Chicago</p>
                                            </span>
                                        </div>
                                        <div class="activity-item">
                                            <span class="activity-dot"></span>
                                            <span class="activity-details">
                                                <span style="color:#e93838;">Bulk upload processed: 25 properties</span>
                                                <p class="activity-meta">1 day ago &bull; Miami</p>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include 'includes/common-footer.php' ?>