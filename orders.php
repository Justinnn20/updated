<?php
session_start();
include "db_conn.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); 
    exit();
}

$user_id = $_SESSION['user_id'];

// 1. Fetch User Data[cite: 7]
$sql_user = "SELECT full_name, profile_pic FROM create_acc WHERE id = '$user_id'";
$res_user = mysqli_query($conn, $sql_user);
$user_data = mysqli_fetch_assoc($res_user);
$fullname = $user_data['full_name'];
$first_name = explode(' ', trim($fullname))[0];
$profile_pic = $user_data['profile_pic'] ?? "";

// 2. Fetch Orders - Direkta na sa order_type ang basehan[cite: 6, 7]
$sql_orders = "SELECT o.*, 
        (SELECT GROUP_CONCAT(m.image_url SEPARATOR ',') 
         FROM menu_items m 
         JOIN order_items oi ON m.name = oi.food_name 
         WHERE oi.order_id = o.id) as food_pics 
        FROM orders o 
        WHERE o.user_id = '$user_id' 
        ORDER BY o.created_at DESC";

$res_orders = mysqli_query($conn, $sql_orders);
$orders = [];
if ($res_orders) {
    while($row = mysqli_fetch_assoc($res_orders)) {
        $orders[] = $row;
    }
}

// 3. Fetch My Reviews[cite: 7]
$sql_my_reviews = "SELECT * FROM ratings WHERE user_id = '$user_id' ORDER BY date_submitted DESC";
$res_my_reviews = mysqli_query($conn, $sql_my_reviews);
$my_reviews = [];
if ($res_my_reviews) {
    while($row = mysqli_fetch_assoc($res_my_reviews)) {
        $my_reviews[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - Kainan ni Ate Kabayan</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="orders.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        .header-profile-desktop {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            height: 40px !important;
            padding: 4px 12px 4px 4px !important;
            background: rgba(255, 255, 255, 0.2) !important;
            border-radius: 50px !important;
            text-decoration: none !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
        }

        .profile-img-small {
            width: 35px !important;
            height: 35px !important;
            min-width: 35px !important;
            min-height: 35px !important;
            background: #fff !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            overflow: hidden !important;
            border: none !important;
            margin: 0 !important;
        }

        .profile-img-small i {
            color: #f39c12 !important;
            font-size: 18px !important;
        }

        .profile-img-small img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
        }

        .header-user-name {
            color: #fff !important;
            font-weight: 800 !important;
            font-size: 0.9rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }
        
        .modal-notes-box {
            font-size: 0.8rem;
            background: #fdf2e9;
            padding: 10px;
            border-radius: 8px;
            border-left: 4px solid #F4A42B;
            margin-top: 10px;
            font-style: italic;
        }

        /* Style para sa Confirm Button[cite: 6] */
        .btn-confirm-received {
            background: #27ae60 !important;
            color: white !important;
            border: none !important;
            padding: 10px !important;
            border-radius: 8px !important;
            font-weight: 800 !important;
            margin-bottom: 10px !important;
            cursor: pointer !important;
            width: 100% !important;
            transition: 0.3s !important;
            font-family: 'Poppins', sans-serif !important;
            text-transform: uppercase !important;
            font-size: 0.75rem !important;
        }
        .btn-confirm-received:hover {
            background: #219150 !important;
            transform: scale(1.02) !important;
        }
    </style>
</head>
<body>

<header>
    <div class="header-container">
        <a href="homepage.php" class="logo" style="text-decoration: none;">
            <div class="logo-circle"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1772298452/logo_ate_kabayan_jtfqeg.jpg" alt="Logo"></div>
            <h2>KAINAN NI ATE KABAYAN</h2>
        </a>
        <nav class="desktop-nav">
            <a href="homepage.php">Home</a>
            <a href="menu.php">Menu</a>
            <a href="orders.php" class="active">Orders</a>
            <a href="ratings.php">Reviews</a>
            <a href="About Us.php">About Us</a>
            <a href="Contactus.php">Contact</a>
        </nav>
        <div class="header-actions">
            <a href="Profile.php" class="header-profile-desktop" style="text-decoration: none; display: flex; align-items: center; gap: 10px;">
                <div class="profile-img-small">
                    <?php if (!empty($profile_pic)): ?> 
                        <img src="<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile"> 
                    <?php else: ?> 
                        <i class="fa-solid fa-user"></i> 
                    <?php endif; ?>
                </div>
                <span class="header-user-name" style="color: #fff; font-weight: bold;">HI, <?php echo strtoupper($first_name); ?>!</span>
            </a>
            <a href="cart.php" class="cart-icon-btn">
                <i class="fa-solid fa-shopping-cart"></i>
                <span class="badge" id="cart-badge">0</span>
            </a>
            <div class="hamburger-menu" id="hamburger-btn"><i class="fa-solid fa-bars"></i></div>
        </div>
    </div>
</header>

<nav class="side-nav" id="side-nav">
    <div class="nav-profile">
        <div class="close-btn" id="close-btn"><i class="fa-solid fa-xmark"></i></div>
        <div class="profile-info">
            <div class="profile-img">
                <?php if (!empty($profile_pic)): ?>
                    <img src="<?php echo htmlspecialchars($profile_pic); ?>" style="width:100%; border-radius:50%; aspect-ratio: 1/1; object-fit: cover;">
                <?php else: ?>
                    <i class="fa-solid fa-user"></i>
                <?php endif; ?>
            </div>
            <div class="profile-text">
                <h3><?php echo htmlspecialchars($fullname); ?></h3>
                <a href="Profile.php">(View Profile)</a>
            </div>
        </div>
    </div>
    <div class="nav-links">
        <a href="homepage.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="menu.php"><i class="fa-solid fa-utensils"></i> Menu</a>
        <a href="orders.php" class="active"><i class="fa-solid fa-file-lines"></i> Orders</a>
        <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i> Cart</a>
        <a href="reviews.php"><i class="fa-solid fa-star"></i> Reviews</a>
        <a href="About Us.php"><i class="fa-solid fa-book-open"></i> About Us</a>
        <a href="Contactus.php"><i class="fa-solid fa-phone"></i> Contact Us</a>
        <a href="logout.php" class="logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out</a>
    </div>
</nav>

<div class="overlay" id="overlay"></div>

<main class="orders-container">
    <aside class="sidebar">
        <button class="nav-btn active" onclick="showSection('active-orders', this)">Active Orders</button>
        <button class="nav-btn" onclick="showSection('previous-orders', this)">Previous Orders</button>
        <button class="nav-btn" onclick="showSection('my-reviews', this)">My Reviews</button>
        <button class="nav-btn" onclick="showSection('contact-us', this)">Contact Us</button>
    </aside>

    <section class="content-area">
        <div class="active-orders previous-orders">
            <div class="greeting-box">
                <h2>Kumusta, <?php echo $first_name; ?>!</h2>
                <p>Here's your orders at Kainan ni Ate Kabayan.</p>
            </div>

            <div id="order-list">
                <?php if(empty($orders)): ?>
                    <div class="empty-state"><p>Wala ka pang orders. <a href="menu.php">Order na!</a></p></div>
                <?php else: ?>
                    <?php foreach($orders as $order): 
                        $order_id = $order['id'];
                        $daily_no = $order['daily_order_no']; 
                        $status = trim($order['status']);
                        $total = $order['total_price'];
                        $date_str = date("F d, Y - g:i A", strtotime($order['created_at']));
                        
                        $type = $order['order_type'];
                        $delivery_fee = $order['delivery_fee'] ?? 0;
                        $cod_fee = ($order['payment_method'] == 'Cash' && $type == 'Delivery') ? 50 : 0;
                        $note = $order['delivery_note'] ?? "";

                        // Inalis ang pickup_sub_type logic dahil wala na ito sa database
                        $display_type = htmlspecialchars($type);

                        $is_finished = ($status == 'Completed' || $status == 'Delivered' || $status == 'Cancelled');
                        $section_class = ($is_finished) ? 'previous-orders' : 'active-orders';
                        
                        $img_list = !empty($order['food_pics']) ? explode(',', $order['food_pics']) : [];
                        $img_count = count($img_list);

                        $badge_class = 'status-pending';
                        if($status == 'Completed' || $status == 'Delivered') $badge_class = 'status-completed';
                        if($status == 'Cancelled') $badge_class = 'status-cancelled';
                    ?>
                    <div class="order-card <?php echo $section_class; ?>" style="<?php echo ($is_finished) ? 'display:none;' : 'display:flex;'; ?>">
                        
                        <div class="order-img-container" onclick="openBreakdown('<?php echo $order_id; ?>', '<?php echo $daily_no; ?>', '<?php echo $date_str; ?>', '<?php echo $total; ?>', '<?php echo $delivery_fee; ?>', '<?php echo $cod_fee; ?>', '<?php echo addslashes($note); ?>')">
                            <?php if($img_count <= 1): ?>
                                <img class="single-img" src="<?php echo (!empty($img_list[0])) ? $img_list[0] : 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1772299118/Goto_Overload_xupge7.png'; ?>">
                            <?php else: ?>
                                <div class="image-grid">
                                    <?php for($i=0; $i < min(4, $img_count); $i++): ?>
                                        <div class="grid-item-wrapper">
                                            <img class="grid-img" src="<?php echo $img_list[$i]; ?>">
                                            <?php if($i == 3 && $img_count > 4): ?>
                                                <div class="more-overlay">
                                                    <div class="more-count">+<?php echo ($img_count - 3); ?></div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="order-details">
                            <h3>Order ID: #<?php echo $daily_no; ?></h3>
                            <p><?php echo $date_str; ?></p>
                            <p>Type: <strong><?php echo $display_type; ?></strong></p>
                            <p><strong>Total: ₱<?php echo number_format($total, 2); ?></strong></p>
                            <button type="button" class="view-link-btn" onclick="openBreakdown('<?php echo $order_id; ?>', '<?php echo $daily_no; ?>', '<?php echo $date_str; ?>', '<?php echo $total; ?>', '<?php echo $delivery_fee; ?>', '<?php echo $cod_fee; ?>', '<?php echo addslashes($note); ?>')">View Details</button>
                        </div>
                        
                        <div class="order-actions">
                            <span class="status-badge <?php echo $badge_class; ?>"><?php echo $status; ?></span>
                            
                            <?php if($status == 'On the Way'): ?>
                                <button class="btn-confirm-received" onclick="confirmOrderReceived(<?php echo $order_id; ?>)">
                                    Confirm Received
                                </button>
                            <?php endif; ?>

                            <button class="btn-reorder">Reorder Now</button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div id="my-reviews-section" class="my-reviews" style="display:none;">
            <div class="greeting-box">
                <h2>Ang iyong Review History</h2>
                <p>Dito mo makikita ang lahat ng feedback na ibinahagi mo.</p>
            </div>

            <div id="reviews-list">
                <?php if(empty($my_reviews)): ?>
                    <div class="empty-state">
                        <p>Wala ka pang naisusulat na review. <a href="menu.php">Mag-review na!</a></p>
                    </div>
                <?php else: ?>
                    <?php foreach($my_reviews as $rev): 
                        $rating = $rev['rating'];
                        $comment = $rev['feedback']; 
                        $order_num = $rev['order_id'];
                        $date = date("F d, Y", strtotime($rev['date_submitted']));
                        $feedback_img = $rev['feedback_image'] ?? ""; 
                    ?>
                    <div class="review-card">
                        <div class="review-header">
                            <strong>Order #<?php echo $order_num; ?></strong>
                            <span class="review-date"><?php echo $date; ?></span>
                        </div>
                        <div class="star-rating">
                            <?php for($i=1; $i<=5; $i++) {
                                echo ($i <= $rating) ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>';
                            } ?>
                        </div>
                        <p class="review-comment">"<?php echo htmlspecialchars($comment); ?>"</p>
                        
                        <?php if (!empty($feedback_img)): ?>
                            <div class="review-photo-container" style="margin-top: 15px; display: flex;">
                                <img src="<?php echo htmlspecialchars($feedback_img); ?>" style="width: 120px; height: 120px; object-fit: cover; border-radius: 12px; border: 2px solid var(--primary-orange);">
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<div id="breakdownModal" class="modal-overlay">
    <div class="breakdown-card">
        <div class="breakdown-header">
            <span>Order Breakdown</span>
            <span class="close-modal" onclick="closeBreakdown()">&times;</span>
        </div>
        <div class="breakdown-content">
            <div class="modal-info-top">
                <p><strong>Order ID:</strong> <span id="modal-order-id">#</span></p>
                <p><strong>Date:</strong> <span id="modal-date"></span></p>
                <hr class="modal-divider">
            </div>
            
            <div id="modal-items-list"></div>
            
            <div class="computation-section">
                <div class="comp-row"><span>Subtotal:</span> <span id="modal-subtotal">₱0.00</span></div>
                <div class="comp-row"><span>VAT (12%):</span> <span id="modal-tax">₱0.00</span></div>
                <div class="comp-row" id="del-fee-row" style="display: none;"><span>Delivery Fee:</span> <span id="modal-del-fee">₱0.00</span></div>
                <div class="comp-row" id="cod-fee-row" style="display: none; color: #e67e22;"><span>COD Fee:</span> <span id="modal-cod-fee">₱50.00</span></div>
                <div class="comp-row" id="discount-row" style="color: #d9534f; display: none;"><span>Discount:</span> <span id="modal-discount">-₱0.00</span></div>
                <div class="total-row"><strong>Total Amount:</strong> <strong id="modal-total-display">₱0.00</strong></div>
                <div id="modal-notes-area" class="modal-notes-box" style="display: none;"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function showSection(sectionId, btn) {
        document.querySelectorAll('.active-orders, .previous-orders, .my-reviews').forEach(card => card.style.display = 'none');
        const targetSections = document.querySelectorAll('.' + sectionId);
        targetSections.forEach(section => {
            section.style.display = (sectionId === 'active-orders' || sectionId === 'previous-orders') ? 'none' : 'block';
        });

        if(sectionId === 'active-orders') {
            document.querySelector('.active-orders').style.display = 'block';
            document.querySelectorAll('.order-card.active-orders').forEach(c => c.style.display = 'flex');
            document.querySelectorAll('.order-card.previous-orders').forEach(c => c.style.display = 'none');
        } else if(sectionId === 'previous-orders') {
            document.querySelector('.previous-orders').style.display = 'block';
            document.querySelectorAll('.order-card.previous-orders').forEach(c => c.style.display = 'flex');
            document.querySelectorAll('.order-card.active-orders').forEach(c => c.style.display = 'none');
        } else if(sectionId === 'my-reviews') {
            document.getElementById('my-reviews-section').style.display = 'block';
        }

        document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    }

    // JS Function para sa Confirmation[cite: 6, 7]
    function confirmOrderReceived(id) {
        if(confirm("Natanggap mo na ba ang iyong order mula sa Kainan ni Ate Kabayan?")) {
            const formData = new FormData();
            formData.append('id', id);
            formData.append('action', 'complete_direct'); 

            fetch('update_kitchen_status.php', { 
                method: 'POST', 
                body: formData 
            })
            .then(res => res.text())
            .then(data => {
                if(data.trim() === "success") {
                    location.reload(); 
                } else {
                    alert("Error: " + data);
                }
            });
        }
    }

    function openBreakdown(id, dailyNo, date, total, delFee, codFee, note) {
        const modal = document.getElementById('breakdownModal');
        if(modal) {
            document.getElementById('modal-order-id').innerText = "#" + dailyNo;
            document.getElementById('modal-date').innerText = date;
            
            let grandTotal = parseFloat(total);
            let deliveryFee = parseFloat(delFee);
            let cashOnDelFee = parseFloat(codFee);
            
            let foodBase = grandTotal - deliveryFee - cashOnDelFee;
            let subtotal = foodBase / 1.12; 
            let tax = foodBase - subtotal;

            document.getElementById('modal-subtotal').innerText = "₱" + subtotal.toLocaleString(undefined, {minimumFractionDigits: 2});
            document.getElementById('modal-tax').innerText = "₱" + tax.toLocaleString(undefined, {minimumFractionDigits: 2});
            
            if(deliveryFee > 0) {
                document.getElementById('del-fee-row').style.display = 'flex';
                document.getElementById('modal-del-fee').innerText = "₱" + deliveryFee.toLocaleString(undefined, {minimumFractionDigits: 2});
            } else {
                document.getElementById('del-fee-row').style.display = 'none';
            }

            if(cashOnDelFee > 0) {
                document.getElementById('cod-fee-row').style.display = 'flex';
                document.getElementById('modal-cod-fee').innerText = "₱" + cashOnDelFee.toLocaleString(undefined, {minimumFractionDigits: 2});
            } else {
                document.getElementById('cod-fee-row').style.display = 'none';
            }

            if(note.trim() !== "") {
                document.getElementById('modal-notes-area').style.display = 'block';
                document.getElementById('modal-notes-area').innerHTML = "<strong>Rider Note:</strong> " + note;
            } else {
                document.getElementById('modal-notes-area').style.display = 'none';
            }

            document.getElementById('modal-total-display').innerText = "₱" + grandTotal.toLocaleString(undefined, {minimumFractionDigits: 2});
            
            modal.style.display = "flex";
            
            fetch('get_order_items.php?order_id=' + id)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('modal-items-list').innerHTML = html;
                });
        }
    }

    function closeBreakdown() {
        document.getElementById('breakdownModal').style.display = "none";
    }

    // --- BURGER MENU LOGIC ---
    document.getElementById('hamburger-btn').addEventListener('click', () => { 
        document.getElementById('side-nav').classList.add('active'); 
        document.getElementById('overlay').classList.add('active'); 
    });
    document.getElementById('close-btn').addEventListener('click', () => { 
        document.getElementById('side-nav').classList.remove('active'); 
        document.getElementById('overlay').classList.remove('active'); 
    });
    document.getElementById('overlay').addEventListener('click', () => { 
        document.getElementById('side-nav').classList.remove('active'); 
        document.getElementById('overlay').classList.remove('active'); 
    });

    // --- CART BADGE COUNT ---
    fetch('get_cart_count.php').then(r=>r.json()).then(d=>{
        const b=document.getElementById('cart-badge');
        if(b){b.innerText=d.total_qty||0;b.style.display=(d.total_qty>0)?'flex':'none';}
    }).catch(()=>{});
</script>
</body>
</html>