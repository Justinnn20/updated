<?php
session_start();
include "db_conn.php";

// 1. Check kung naka-login ang user
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); 
    exit();
}

$user_id = $_SESSION['user_id'];

// 2. Kunin ang lahat ng data mula sa 'create_acc'
$sql = "SELECT * FROM create_acc WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
    
    // Data variables
    $fullname    = $user_data['full_name']; 
    $email       = $user_data['email'];
    $contact     = $user_data['contact_number'] ?? ""; 
    $google_id   = $user_data['google_id'] ?? "";   
    $facebook_id = $user_data['facebook_id'] ?? ""; 
    
    $profile_pic = $user_data['profile_pic'] ?? ""; 
    $home_addr   = $user_data['address_home'] ?? "";
    $work_addr   = $user_data['address_work'] ?? "";

    // DISCOUNT DATA
    $discount_type   = $user_data['discount_type'] ?? "None"; 
    $discount_id     = $user_data['discount_id_no'] ?? "";
    $discount_id_pic = $user_data['discount_id_pic'] ?? ""; // New column for ID photo
} else {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - Kainan ni Ate Kabayan</title>
    <link rel="stylesheet" href="Profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>

    <style>
        /* CSS OVERRIDES */
        .avatar-big { overflow: visible !important; border: 2px solid #ddd; position: relative; cursor: pointer; }
        .avatar-big img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
        .camera-icon { bottom: 0 !important; right: 0 !important; width: 40px !important; height: 40px !important; border: 3px solid white !important; z-index: 10 !important; background: var(--highlight-orange); color: white; border-radius: 50%; display: flex; justify-content: center; align-items: center; position: absolute; }
        .edit-actions { display: flex; flex-direction: column; gap: 5px; margin-top: 10px; margin-bottom: 20px; }
        .edit-photo { font-size: 0.85rem; color: #F4A42B; text-decoration: none; font-weight: 600; cursor: pointer; }
        .edit-photo:hover { text-decoration: underline; }
        .btn-remove-photo { font-size: 0.8rem; color: #e74c3c; text-decoration: none; font-weight: 600; }
        textarea.address-box { width: 100%; min-height: 80px; resize: none; padding: 12px; background: var(--input-bg); border: 1.5px solid #FFE0B2; border-radius: 10px; outline: none; display: block; }
        .status-connected { color: #2ecc71; font-weight: 800; }

        /* DISCOUNT SECTION STYLING */
        .discount-row { display: flex; gap: 15px; margin-top: 10px; flex-wrap: wrap; }
        .discount-row .form-group { flex: 1; min-width: 200px; }
        select.discount-select { width: 100%; padding: 12px; border-radius: 10px; border: 1.5px solid #FFE0B2; background: var(--input-bg); outline: none; font-family: inherit; font-size: 1rem; }
        
        .id-upload-box { margin-top: 15px; padding: 15px; border: 2px dashed #FFE0B2; border-radius: 15px; text-align: center; background: #fffcf5; }
        .id-preview { width: 100%; max-width: 250px; height: 150px; object-fit: contain; margin-top: 10px; border-radius: 10px; display: none; border: 1px solid #ddd; }
        .id-preview.active { display: block; margin-left: auto; margin-right: auto; }

        /* MODALS */
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 9999; justify-content: center; align-items: center; }
        .custom-modal { background-color: #FEEBC8; padding: 30px; border-radius: 25px; width: 350px; text-align: center; box-shadow: 0 5px 20px rgba(0,0,0,0.3); border: none; }
        .photo-option-btn { width: 100%; padding: 15px; margin-bottom: 10px; border-radius: 15px; border: none; background: white; font-family: 'Poppins', sans-serif; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; transition: 0.3s; }
        .modal-btns { display: flex; justify-content: space-between; gap: 15px; margin-top: 10px; }
        .modal-btns button { flex: 1; padding: 12px; border-radius: 18px; border: none; font-weight: 800; font-size: 1.1rem; cursor: pointer; }

        /* DRAGGABLE PREVIEW */
        .confirm-preview-box { width: 180px; height: 180px; margin: 0 auto 20px; border-radius: 50%; overflow: hidden; border: 4px solid var(--highlight-orange); position: relative; background: #ccc; cursor: move; touch-action: none; }
        #confirm_image_preview { position: absolute; top: 0; left: 0; min-width: 100%; min-height: 100%; user-select: none; -webkit-user-drag: none; }
        .drag-hint { font-size: 0.75rem; color: #555; margin-bottom: 15px; display: block; }
    </style>
</head>
<body>

<header>
    <div class="header-container">
        <div class="logo">
            <div class="logo-circle"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1772298452/logo_ate_kabayan_jtfqeg.jpg" alt="Logo"></div>
            <h2>KAINAN NI ATE KABAYAN</h2>
        </div>
        <div class="header-actions">
            <a href="cart.php" class="cart-icon-btn"><i class="fa-solid fa-shopping-cart"></i><span class="badge" id="cart-badge">0</span></a>
            <div class="hamburger-menu" id="hamburger-btn"><i class="fa-solid fa-bars"></i></div>
        </div>
    </div>
</header>

<nav class="side-nav" id="side-nav">
    <div class="nav-profile">
        <div class="close-btn" id="close-btn"><i class="fa-solid fa-xmark"></i></div>
        <div class="profile-info">
            <div class="profile-img">
                <?php if (!empty($profile_pic)): ?> <img src="<?php echo htmlspecialchars($profile_pic); ?>" style="width:100%; border-radius:50%; aspect-ratio: 1/1; object-fit: cover;"> <?php else: ?> <i class="fa-solid fa-user"></i> <?php endif; ?>
            </div>
            <div class="profile-text"><h3><?php echo htmlspecialchars($fullname); ?></h3><a href="Profile.php">(View Profile)</a></div>
        </div>
    </div>
    <div class="nav-links">
        <a href="homepage.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="menu.php"><i class="fa-solid fa-utensils"></i> Menu</a>
        <a href="orders.php"><i class="fa-solid fa-file-lines"></i> Orders</a>
        <a href="About Us.php"><i class="fa-solid fa-book-open"></i> About Us</a>
        <a href="Contactus.php"><i class="fa-solid fa-phone"></i> Contact Us</a>
        <a href="logout.php" class="logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out</a>
    </div>
</nav>

<div class="overlay" id="overlay"></div>

<main class="profile-container">
    <h1 class="page-title">My Account</h1>

    <form action="update_profile.php" method="POST" enctype="multipart/form-data" id="profileUpdateForm">
        <section class="info-card">
            <div class="card-header"><i class="fa-solid fa-user"></i> <h2>Personal Information</h2></div>
            <div class="personal-flex">
                <div class="inputs-side">
                    <div class="form-group"><label>Full Name</label><input type="text" name="full_name" value="<?php echo htmlspecialchars($fullname); ?>"></div>
                    <div class="form-group"><label>Email Address</label><input type="email" value="<?php echo htmlspecialchars($email); ?>" readonly style="background:#eee;"></div>
                    <div class="form-group"><label>Phone Number</label><input type="text" name="contact_number" value="<?php echo htmlspecialchars($contact); ?>"></div>
                </div>

                <div class="photo-side">
                    <div class="avatar-big" onclick="showPhotoOptions()" style="cursor:pointer;">
                        <?php if (!empty($profile_pic)): ?> <img id="profile_display" src="<?php echo htmlspecialchars($profile_pic); ?>"> <?php else: ?> <i class="fa-solid fa-user" id="user_icon" style="font-size: 4rem;"></i> <img id="profile_display" style="display:none;"> <?php endif; ?>
                        <div class="camera-icon"><i class="fa-solid fa-camera"></i></div>
                    </div>
                    <input type="file" name="profile_pic" id="profile_pic_input" style="display:none;" accept="image/*" onchange="previewImage(this)">
                    <input type="file" name="profile_pic_camera" id="profile_pic_camera" style="display:none;" accept="image/*" capture="user" onchange="previewImage(this)">
                    
                    <div class="edit-actions">
                        <span class="edit-photo" onclick="showPhotoOptions()">Change Photo</span>
                        <?php if (!empty($profile_pic)): ?> <a href="update_profile.php?remove_photo=1" class="btn-remove-photo" onclick="return confirm('Sigurado ka bang gusto mong burahin ang profile picture?')">Remove Photo</a> <?php endif; ?>
                    </div>
                    <button type="submit" name="btn_save_profile" class="btn-save">Save Changes</button>
                </div>
            </div>
        </section>

        <section class="info-card">
            <div class="card-header"><i class="fa-solid fa-house"></i> <h2>Saved Addresses</h2></div>
            <div class="address-item"><strong>Home Address</strong><textarea name="address_home" class="address-box"><?php echo htmlspecialchars($home_addr); ?></textarea></div>
            <div class="address-item" style="margin-top:15px;"><strong>Work Address</strong><textarea name="address_work" class="address-box"><?php echo htmlspecialchars($work_addr); ?></textarea></div>
        </section>

        <section class="info-card">
            <div class="card-header"><i class="fa-solid fa-id-card"></i> <h2>Discount Verification</h2></div>
            <div class="discount-row">
                <div class="form-group">
                    <label>ID Type</label>
                    <select name="discount_type" class="discount-select" id="discount_type" onchange="toggleDiscountFields()">
                        <option value="None" <?php if($discount_type=="None") echo "selected"; ?>>None (Regular)</option>
                        <option value="Senior" <?php if($discount_type=="Senior") echo "selected"; ?>>Senior Citizen</option>
                        <option value="PWD" <?php if($discount_type=="PWD") echo "selected"; ?>>PWD</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>ID Number</label>
                    <input type="text" name="discount_id_no" id="discount_id_no" value="<?php echo htmlspecialchars($discount_id); ?>" placeholder="Enter ID Number" <?php if($discount_type=="None") echo "disabled"; ?>>
                </div>
            </div>

            <div id="id_photo_section" style="<?php echo ($discount_type == 'None') ? 'display:none;' : ''; ?>">
                <div class="id-upload-box">
                    <p style="font-weight: 600; font-size: 0.9rem;">Upload Physical ID Photo for Verification</p>
                    <input type="file" name="discount_id_pic" id="discount_id_pic_input" accept="image/*" onchange="previewID(this)" style="margin-top: 10px;">
                    <img id="id_preview_img" src="<?php echo !empty($discount_id_pic) ? htmlspecialchars($discount_id_pic) : ''; ?>" class="id-preview <?php echo !empty($discount_id_pic) ? 'active' : ''; ?>">
                </div>
            </div>
        </section>
        
        <input type="hidden" name="link_google" id="link_google_id">
        <input type="hidden" name="link_fb" id="link_fb_id">
        <input type="hidden" name="fb_name" id="fb_name">
        <input type="hidden" name="fb_email" id="fb_email">
        <input type="hidden" name="social_pic_url" id="social_pic_url">
    </form>

    <div class="security-grid">
        <section class="info-card">
            <div class="card-header"><h2>Social Connections</h2></div>
            <div class="social-row"><span>Google</span><?php if (!empty($google_id)): ?><span class="status-connected">Connected</span><?php else: ?><button class="btn-connect" onclick="googleConnect()">Connect</button><?php endif; ?></div>
            <div class="social-row"><span>Facebook</span><?php if (!empty($facebook_id)): ?><span class="status-connected">Connected</span><?php else: ?><button class="btn-connect" onclick="fbConnect()">Connect</button><?php endif; ?></div>
        </section>
        <section class="info-card">
            <div class="card-header"><h2>Account Actions</h2></div>
            <div class="delete-logout-btns">
                <button type="button" class="btn-outline-logout" onclick="window.location.href='logout.php'">Log Out</button>
                <button type="button" class="btn-red-delete" onclick="showDeleteModal()">Delete Account</button>
            </div>
        </section>
    </div>
</main>

<div class="modal-overlay" id="photoModalOverlay">
    <div class="custom-modal">
        <p>Change Profile Photo</p>
        <button class="photo-option-btn" onclick="openGallery()"><i class="fa-solid fa-image"></i> Gallery</button>
        <button class="photo-option-btn" onclick="openCamera()"><i class="fa-solid fa-camera"></i> Take a Photo</button>
        <?php if (!empty($facebook_id)): ?><button class="photo-option-btn" onclick="syncFBPhoto()"><i class="fa-brands fa-facebook" style="color:#1877F2;"></i> Sync from Facebook</button><?php endif; ?>
        <button class="photo-option-btn" style="color:red; margin-top:10px;" onclick="closePhotoOptions()">Cancel</button>
    </div>
</div>

<div class="modal-overlay" id="confirmPhotoOverlay">
    <div class="custom-modal">
        <p>Adjust Profile Picture</p>
        <small class="drag-hint">I-drag ang picture para i-center</small>
        <div class="confirm-preview-box" id="drag_area">
            <img id="confirm_image_preview" src="" style="top:0; left:0;">
        </div>
        <div class="modal-btns">
            <button class="btn-modal-cancel" style="background:white; color:black;" onclick="cancelPhotoSelection()">Cancel</button>
            <button class="btn-modal-yes" style="background:#2ecc71; color:white;" onclick="confirmAndUpload()">Confirm</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="deleteModalOverlay">
    <div class="custom-modal">
        <p>Are you sure you want to <span style="color:red;">DELETE</span> your account permanently?</p>
        <div class="modal-btns">
            <button class="btn-modal-cancel" onclick="closeDeleteModal()">Cancel</button>
            <button class="btn-modal-yes" style="background:red; color:white;" onclick="proceedDelete()">Yes</button>
        </div>
    </div>
</div>

<script>
// --- DISCOUNT LOGIC ---
function toggleDiscountFields() {
    const type = document.getElementById('discount_type').value;
    const idInput = document.getElementById('discount_id_no');
    const photoSection = document.getElementById('id_photo_section');
    
    if (type === 'None') {
        idInput.disabled = true; idInput.value = '';
        photoSection.style.display = 'none';
    } else {
        idInput.disabled = false;
        photoSection.style.display = 'block';
    }
}

function previewID(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('id_preview_img');
            img.src = e.target.result;
            img.classList.add('active');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// --- PHOTO MODAL LOGIC ---
function showPhotoOptions() { document.getElementById('photoModalOverlay').style.display = 'flex'; }
function closePhotoOptions() { document.getElementById('photoModalOverlay').style.display = 'none'; }
function openGallery() { closePhotoOptions(); document.getElementById('profile_pic_input').click(); }
function openCamera() { closePhotoOptions(); document.getElementById('profile_pic_camera').click(); }

let isDragging = false;
let startX, startY, initialLeft, initialTop;
const previewImg = document.getElementById('confirm_image_preview');
const dragArea = document.getElementById('drag_area');

function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewImg.style.top = "0px"; previewImg.style.left = "0px";
            document.getElementById('confirmPhotoOverlay').style.display = 'flex';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Drag Events
dragArea.addEventListener('mousedown', (e) => { e.preventDefault(); isDragging = true; startX = e.clientX; startY = e.clientY; initialLeft = parseInt(previewImg.style.left) || 0; initialTop = parseInt(previewImg.style.top) || 0; });
window.addEventListener('mousemove', (e) => { if (!isDragging) return; let dx = e.clientX - startX; let dy = e.clientY - startY; previewImg.style.left = (initialLeft + dx) + "px"; previewImg.style.top = (initialTop + dy) + "px"; });
window.addEventListener('mouseup', () => { isDragging = false; });
dragArea.addEventListener('touchstart', (e) => { isDragging = true; startX = e.touches[0].clientX; startY = e.touches[0].clientY; initialLeft = parseInt(previewImg.style.left) || 0; initialTop = parseInt(previewImg.style.top) || 0; }, {passive:true});
dragArea.addEventListener('touchmove', (e) => { if (!isDragging) return; let dx = e.touches[0].clientX - startX; let dy = e.touches[0].clientY - startY; previewImg.style.left = (initialLeft + dx) + "px"; previewImg.style.top = (initialTop + dy) + "px"; }, {passive:true});
dragArea.addEventListener('touchend', () => { isDragging = false; });

function cancelPhotoSelection() { document.getElementById('profile_pic_input').value = ""; document.getElementById('profile_pic_camera').value = ""; document.getElementById('confirmPhotoOverlay').style.display = 'none'; }
function confirmAndUpload() { document.getElementById('profileUpdateForm').submit(); }

// --- SOCIALS & DELETE ---
function googleConnect() { google.accounts.id.prompt(); }
function handleSocialLink(response) { const payload = JSON.parse(atob(response.credential.split(".")[1])); document.getElementById('link_google_id').value = payload.sub; document.getElementById('profileUpdateForm').submit(); }
window.fbAsyncInit = function() { FB.init({ appId: '3396938717141397', cookie: true, xfbml: true, version: 'v18.0' }); };
function fbConnect() { FB.login(function(response) { if (response.status === 'connected') { FB.api('/me', {fields: 'name,email'}, function(userData) { document.getElementById('link_fb_id').value = response.authResponse.userID; document.getElementById('profileUpdateForm').submit(); }); } }, {scope: 'public_profile,email'}); }
function syncFBPhoto() { closePhotoOptions(); const fbId = "<?php echo $facebook_id; ?>"; if (fbId) { document.getElementById('social_pic_url').value = 'https://graph.facebook.com/' + fbId + '/picture?type=large'; document.getElementById('profileUpdateForm').submit(); } }

function showDeleteModal() { document.getElementById('deleteModalOverlay').style.display = 'flex'; }
function closeDeleteModal() { document.getElementById('deleteModalOverlay').style.display = 'none'; }
function proceedDelete() { window.location.href = 'delete_account.php'; }

window.onclick = function(e) { if (e.target.className === 'modal-overlay') { closePhotoOptions(); closeDeleteModal(); document.getElementById('confirmPhotoOverlay').style.display = 'none'; } }
</script>
<script src="Profile.js"></script>
</body>
</html>