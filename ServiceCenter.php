<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Center | Kainan ni Ate Kabayan</title>
    <link rel="stylesheet" href="Dashboard.css">
    <link rel="stylesheet" href="ServiceCenter.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Sidebar (Pareho sa ibang admin pages) -->
        <aside class="sidebar">
            <div class="logo-box">
                <img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1772298452/logo_ate_kabayan_jtfqeg.jpg" alt="Logo">
            </div>
            <nav>
                <a href="Dashboard.html"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
                <a href="MenuManagement.html"><i class="fa-solid fa-utensils"></i> Menu Management</a>
                <a href="StaffActivity.html"><i class="fa-solid fa-users"></i> Staff & Activity</a>
                <a href="ServiceCenter.html" class="active"><i class="fa-solid fa-headset"></i> Service Center</a>
                <a href="Sales&Promotion.html"><i class="fa-solid fa-tags"></i> Sales & Promotion</a>
                <a href="System&IntegrationsSettings.html"><i class="fa-solid fa-gear"></i> Settings</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main>
            <header>
                <div class="admin-title">
                    <img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1772298452/logo_ate_kabayan_jtfqeg.jpg" alt="Logo" class="mini-logo">
                    KAINAN NI ATE KABAYAN | <span>ADMIN</span>
                </div>
                <div class="header-icons">
                    <i class="fa-solid fa-comment-dots"></i>
                    <i class="fa-solid fa-bell"></i>
                    <i class="fa-solid fa-bars"></i>
                </div>
            </header>

            <section class="content">
                <div class="service-grid">
                    
                    <!-- TABLE RESERVATION TRACKER -->
<div class="card service-card animate-pop">
    <div class="card-header-orange">
        <i class="fa-solid fa-calendar-days"></i>
        <h3>TABLE RESERVATION TRACKER</h3>
    </div>
    <div class="card-inner">
        <p class="subtitle">Today's Active Bookings (April 17, 2026)</p>
        <div class="quick-filters">
            <span>Quick Filters:</span>
            <!-- Added onclick events -->
            <button class="filter-pill pending" onclick="filterReservations('Pending')">Pending Confirmation</button>
            <button class="filter-pill seated" onclick="filterReservations('Seated')">Seated</button>
            <button class="filter-pill all" onclick="filterReservations('All')">All</button>
        </div>
        <div class="table-list-container">
            <table>
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Time</th>
                        <th>Pax</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody id="reservation-list">
                    <!-- Dynamic Rows -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- CUSTOMER FEEDBACK HUB -->
<div class="card service-card animate-pop">
    <!-- ... header ... -->
    <div class="card-inner">
        <p class="hub-tagline">MGA BUSOG NA NGITI!</p>
        <div class="reviews-queue">
            <h4 class="section-label">Reviews Queue</h4>
            <div id="feedback-queue">
                <!-- Interactive Review Cards -->
            </div>
        </div>
        <div class="recently-published">
            <h4 class="section-label">RECENTLY PUBLISHED</h4>
            <div class="mini-card-grid" id="published-grid">
                <!-- Approved Cards -->
            </div>
        </div>
    </div>
</div>

<!-- CONTACT INQUIRY INBOX -->
<div class="card service-card animate-pop">
    <!-- header -->
    <div class="card-inner">
        <div class="inbox-header">
            <h4 class="section-label">NEW MESSAGES</h4>
            <span class="badge-red" id="inbox-badge">0 new</span>
        </div>
        <div class="inbox-table-container">
            <table>
                <thead>
                    <tr><th>Sender</th><th>Subject</th><th>Date</th><th>Status</th></tr>
                </thead>
                <tbody id="inquiry-list" class="clickable-rows">
                    <!-- Clickable Rows -->
                </tbody>
            </table>
        </div>
        <div class="reply-section">
            <h4 class="section-label">REPLY-IN MESSAGE</h4>
            <div class="reply-form">
                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" id="reply-subject" readonly>
                </div>
                <div class="form-group">
                    <label>Customer Inquiry</label>
                    <textarea id="customer-inquiry" readonly></textarea>
                </div>
                <div class="form-group">
                    <label>Admin Reply</label>
                    <textarea id="admin-reply" placeholder="Reply......................."></textarea>
                </div>
                <button class="btn-send-reply" onclick="sendAdminReply()">Send Reply</button>
            </div>
        </div>
    </div>
</div>

                </div>
            </section>
        </main>
    </div>
    <script src="ServiceCenter.js"></script>
</body>
</html>