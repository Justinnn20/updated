<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kainan ni Ate Kabayan - Menu</title>
    
    <link rel="stylesheet" href="menu-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans+Code:ital,wght@0,300..800;1,300..800&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Pacifico&family=Patrick+Hand&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    
<header>
    <div class="header-container">
        <div class="logo">
            <div class="logo-circle">
                <img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1772298452/logo_ate_kabayan_jtfqeg.jpg" alt="Logo">
            </div>
            <h2>KAINAN NI ATE KABAYAN</h2>
        </div>
        
        <div class="header-actions">
            <a href="cart.html" class="cart-icon-btn">
                <i class="fa-solid fa-shopping-cart"></i>
                <span class="badge" id="cart-badge">0</span>
            </a>
            <div class="hamburger-menu" id="hamburger-btn">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
    </div>
</header>

<nav class="side-nav" id="side-nav">
    <div class="nav-profile">
        <div class="close-btn" id="close-btn">
            <i class="fa-solid fa-xmark"></i>
        </div>
        <div class="profile-info">
            <div class="profile-img">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="profile-text">
                <h3>Juan Dela Cruz</h3>
                <a href="Profile.php">(View Profile)</a>
            </div>
        </div>
    </div>

    <div class="nav-links">
        <a href="homepage.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="menu.php" class="active"><i class="fa-solid fa-utensils"></i> Menu</a>
        <a href="orders.php"><i class="fa-solid fa-file-lines"></i> Orders</a>
        <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i> Cart</a>
        <a href="reviews.php"><i class="fa-solid fa-star"></i> Reviews</a>
        <a href="About Us.php"><i class="fa-solid fa-book-open"></i> About Us</a>
        <a href="Contactus.php"><i class="fa-solid fa-phone"></i> Contact Us</a>
        <a href="logout.php" class="logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out</a>
    </div>
</nav>

<div class="overlay" id="overlay"></div>

    <main>
        <section class="top-bar">
            <div class="search-container">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="searchInput" placeholder="Search Menu">
            </div>
            
            <a href="ratings.html" class="rating-badge" style="text-decoration: none; color: inherit; cursor: pointer;">
                <div class="stars">
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                </div>
                <span>5.0 (100+ Ratings)</span>
            </a>
            
        </section>

        <section class="categories-section">
            <div class="category-wrapper" id="categoryContainer">
                </div>
        </section>

        <div class="menu-grid" id="menuGrid">

            <div class="menu-card" data-category="silog">
                    <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1772298630/PorkSilog_wpfoym.png" alt="Porksilog"></div>
                    <div class="card-details">
                        <div class="card-header"><h3>PORKSILOG</h3><span class="price">₱130</span></div>
                        <p class="desc">Crispy porkchop with sinangag rice and fried egg.</p>
                        <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        <div class="card-actions">
                            <button class="btn-add-cart" onclick="addToCart('Porksilog', 130, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1772298630/PorkSilog_wpfoym.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                            <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                        </div>
                    </div>
                </div>

            <div class="menu-card" data-category="goto">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1772299118/Goto_Overload_xupge7.png" alt="Goto Overload"></div>
                <div class="card-details">
                    <div class="card-header"><h3>GOTO OVERLOAD</h3><span class="price">₱150</span></div>
                    <p class="desc">Sabaw na may overload twalya, balat, isaw, at karne with rice.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Goto Overload', 150, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1772299118/Goto_Overload_xupge7.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="lugaw">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1772298989/Lugaw_overload_ch9swb.png" alt="Lugaw Overload"></div>
                <div class="card-details">
                    <div class="card-header"><h3>LUGAW OVERLOAD</h3><span class="price">₱150</span></div>
                    <p class="desc">UNLI lugaw na may itlog, lechon kawali, twalya, at isaw.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Lugaw Overload', 150, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1772298989/Lugaw_overload_ch9swb.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="silog">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1772299033/LiempoSilog_zpdtmk.png" alt="Liemposilog"></div>
                <div class="card-details">
                    <div class="card-header"><h3>LIEMPOSILOG</h3><span class="price">₱155</span></div>
                    <p class="desc">Grilled Liempo with sinangag rice and fried egg.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Liemposilog', 155, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1772299033/LiempoSilog_zpdtmk.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="sizzling">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1772299076/Sisig_Barkada_nztbzh.png" alt="Sisig Barkada"></div>
                <div class="card-details">
                    <div class="card-header"><h3>SISIG BARKADA</h3><span class="price">₱185</span></div>
                    <p class="desc">Sizzling pork sisig with egg for sharing barkada.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Sisig Barkada', 185, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1772299076/Sisig_Barkada_nztbzh.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="chow">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1772299423/Siomai_Chowfan_cq4la2.png" alt="Siomai Chowfan"></div>
                <div class="card-details">
                    <div class="card-header"><h3>SIOMAI CHOWFAN</h3><span class="price">₱95</span></div>
                    <p class="desc">Crispy fried siomai with special chowfan rice.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        <div class="card-actions">
                            <button class="btn-add-cart" onclick="addToCart('Siomai Chowfan', 95, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1772299423/Siomai_Chowfan_cq4la2.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="chow">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773500981/Bacon_Chowfan_zd0aeg.png" alt="Bacon Chowfan"></div>
                <div class="card-details">
                    <div class="card-header"><h3>BACON CHOWFAN</h3><span class="price">₱95</span></div>
                    <p class="desc">Bacon & Cheese Dip with special chowfan rice.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Bacon Chowfan', 95, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773500981/Bacon_Chowfan_zd0aeg.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="silog">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501327/BangSilog_rxgqco.png" alt="Bangsilog"></div>
                <div class="card-details">
                    <div class="card-header"><h3>BANGSILOG</h3><span class="price">₱130</span></div>
                    <p class="desc">Fried Milkfish with sinangag rice and fried egg.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Bangsilog', 130, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501327/BangSilog_rxgqco.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="sizzling">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501424/Sizzling_Sisig_ue3yxv.png" alt="Sizzling Sisig"></div>
                <div class="card-details">
                    <div class="card-header"><h3>SIZZLING SISIG</h3><span class="price">₱155</span></div>
                    <p class="desc">Sizzling pork sisig with egg (Solo).</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Sizzling Sisig', 155, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501424/Sizzling_Sisig_ue3yxv.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="goto">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501345/Goto_Regular_i0txky.png" alt="Goto Regular"></div>
                <div class="card-details">
                    <div class="card-header"><h3>GOTO REGULAR</h3><span class="price">₱85</span></div>
                    <p class="desc">Goto soup with beef & rice.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Goto Regular', 85, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501345/Goto_Regular_i0txky.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="chow">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501410/Shanghai_Chowfan_wdpfdy.png" alt="Shanghai Chowfan"></div>
                <div class="card-details">
                    <div class="card-header"><h3>SHANGHAI CHOWFAN</h3><span class="price">₱95</span></div>
                    <p class="desc">Fried Shanghai with special chowfan rice.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Shanghai Chowfan', 95, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501410/Shanghai_Chowfan_wdpfdy.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="silog">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501385/LongSilog_iu8d5f.png" alt="Longsilog"></div>
                <div class="card-details">
                    <div class="card-header"><h3>LONGSILOG</h3><span class="price">₱130</span></div>
                    <p class="desc">Longganisa with sinangag rice and fried egg.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Longsilog', 130, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501385/LongSilog_iu8d5f.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="lugaw">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501386/Lugaw_isaw_pmetcz.png" alt="Lugaw Isaw"></div>
                <div class="card-details">
                    <div class="card-header"><h3>LUGAW ISAW</h3><span class="price">₱95</span></div>
                    <p class="desc">Lugaw with Isaw toppings.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Lugaw Isaw', 95, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501386/Lugaw_isaw_pmetcz.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="chow">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501333/Chicken_Nuggets_Chowfan_nbpekz.png" alt="Nuggets Chowfan"></div>
                <div class="card-details">
                    <div class="card-header"><h3>NUGGETS CHOWFAN</h3><span class="price">₱95</span></div>
                    <p class="desc">Chicken Nuggets with special chowfan rice.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Nuggets Chowfan', 95, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501333/Chicken_Nuggets_Chowfan_nbpekz.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="silog">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501429/Tocilog_s7rshn.png" alt="Tocilog"></div>
                <div class="card-details">
                    <div class="card-header"><h3>TOCILOG</h3><span class="price">₱130</span></div>
                    <p class="desc">Tocino with sinangag rice and fried egg.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Tocilog', 130, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501429/Tocilog_s7rshn.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="silog">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501426/Tapsilog_mc2zul.png" alt="Tapsilog"></div>
                <div class="card-details">
                    <div class="card-header"><h3>TAPSILOG</h3><span class="price">₱130</span></div>
                    <p class="desc">Tapa with sinangag rice and fried egg.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Tapsilog', 130, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501426/Tapsilog_mc2zul.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="lugaw">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501388/Lugaw_lechon_aipeog.png" alt="Lugaw Lechon"></div>
                <div class="card-details">
                    <div class="card-header"><h3>LUGAW LECHON</h3><span class="price">₱95</span></div>
                    <p class="desc">Lugaw with Crispy Lechon Kawali.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Lugaw Lechon', 95, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501388/Lugaw_lechon_aipeog.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="sizzling">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501416/Sizzling_Hungarian_dcilaa.png" alt="Sizzling Hungarian"></div>
                <div class="card-details">
                    <div class="card-header"><h3>SIZZLING HUNGARIAN</h3><span class="price">₱140</span></div>
                    <p class="desc">Hungarian sausage with java rice and gravy.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Sizzling Hungarian', 140, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501416/Sizzling_Hungarian_dcilaa.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="chow">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501409/Sausage_Chowfan_vct1bg.png" alt="Sausage Chowfan"></div>
                <div class="card-details">
                    <div class="card-header"><h3>SAUSAGE CHOWFAN</h3><span class="price">₱95</span></div>
                    <p class="desc">Mini crispy sausages with special chowfan rice.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Sausage Chowfan', 95, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501409/Sausage_Chowfan_vct1bg.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="sizzling">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501423/Sizzling_Liempo_fl7ofr.png" alt="Sizzling Liempo"></div>
                <div class="card-details">
                    <div class="card-header"><h3>SIZZLING LIEMPO</h3><span class="price">₱180</span></div>
                    <p class="desc">Sizzling liempo with java rice and chili gravy.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Sizzling Liempo', 180, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501423/Sizzling_Liempo_fl7ofr.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="carte">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501436/Tokwat_Lechon_l69imm.png" alt="Tokwat Lechon"></div>
                <div class="card-details">
                    <div class="card-header"><h3>TOKWA'T LECHON</h3><span class="price">₱120</span></div>
                    <p class="desc">Lechon kawali with tokwa and vinegar sauce.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Tokwat Lechon', 120, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501436/Tokwat_Lechon_l69imm.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="carte">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501411/Shanghai_etsffk.png"></div>
                <div class="card-details">
                    <div class="card-header"><h3>SHANGHAI</h3><span class="price">₱135</span></div>
                    <p class="desc">Lumpiang Shanghai with sinangag rice and fried egg.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Shanghai', 135, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501411/Shanghai_etsffk.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="carte">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501333/Buttered_Chicken_dqy0sx.png" alt="Buttered Chicken"></div>
                <div class="card-details">
                    <div class="card-header"><h3>BUTTERED CHICKEN</h3><span class="price">₱220</span></div>
                    <p class="desc">Fried Chicken coated in butter sauce.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Buttered Chicken', 220, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501333/Buttered_Chicken_dqy0sx.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="drinks">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501328/Bottled_Water_cs2k5g.png" alt="Bottled Water"></div>
                <div class="card-details">
                    <div class="card-header"><h3>BOTTLED WATER</h3><span class="price">₱20</span></div>
                    <p class="desc">Clean and mineral distilled water.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Bottled Water', 20, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501328/Bottled_Water_cs2k5g.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="drinks">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501376/Lemon_Cucumber_Juice_taon1v.png" alt="Lemon Cucumber"></div>
                <div class="card-details">
                    <div class="card-header"><h3>LEMON CUCUMBER</h3><span class="price">₱25</span></div>
                    <p class="desc">Freshly squeezed Lemon and Cucumber Juice.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Lemon Cucumber', 25, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501376/Lemon_Cucumber_Juice_taon1v.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="drinks">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501339/Coke_Misskona_mzsigp.png" alt="Coke Mismo"></div>
                <div class="card-details">
                    <div class="card-header"><h3>COCA-COLA</h3><span class="price">₱30</span></div>
                    <p class="desc">Original Coca-cola Mismo.</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Coke Mismo', 30, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501339/Coke_Misskona_mzsigp.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="addons">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501430/Toge_yzxfqw.png" alt="Lumpiang Toge"></div>
                <div class="card-details">
                    <div class="card-header"><h3>LUMPIANG TOGE</h3><span class="price">₱20</span></div>
                    <p class="desc">Crispy Lumpiang Toge</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Lumpiang Toge', 20, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501430/Toge_yzxfqw.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="addons">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501434/Tokwa_hcyope.png" alt="Tokwa"></div>
                <div class="card-details">
                    <div class="card-header"><h3>TOKWA</h3><span class="price">₱20</span></div>
                    <p class="desc">Crispy Tofu best partner of Lugaw</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Tokwa', 20, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501434/Tokwa_hcyope.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="addons">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501339/Fried_Egg_t0hgu9.png" alt="Fried Egg"></div>
                <div class="card-details">
                    <div class="card-header"><h3>FRIED EGG</h3><span class="price">₱15</span></div>
                    <p class="desc">Fried Egg</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Fried Egg', 15, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501339/Fried_Egg_t0hgu9.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="addons">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501395/Plain_Rice_cdrzuz.png" alt="Plain Rice"></div>
                <div class="card-details">
                    <div class="card-header"><h3>PLAIN RICE</h3><span class="price">₱15</span></div>
                    <p class="desc">Perfectly Cooked Plain Rice</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Plain Rice', 15, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501395/Plain_Rice_cdrzuz .png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="addons">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501341/Fried_Rice_fxh3p9.png" alt="Fried Rice"></div>
                <div class="card-details">
                    <div class="card-header"><h3>FRIED RICE</h3><span class="price">₱20</span></div>
                    <p class="desc">Delicious Sinangag Rice</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Fried Rice', 20, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501341/Fried_Rice_fxh3p9.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="addons">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501334/Chowfan_Rice_vexnpl.png" alt="Chowfan Rice"></div>
                <div class="card-details">
                    <div class="card-header"><h3>CHOWFAN RICE</h3><span class="price">₱50</span></div>
                    <p class="desc">Best Chowfan Rice in the World</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Chowfan Rice', 50, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501334/Chowfan_Rice_vexnpl.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>

            <div class="menu-card" data-category="addons">
                <div class="card-img-container"><img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501328/Boiled_Egg_nzcnsg.png" alt="Boiled Egg"></div>
                <div class="card-details">
                    <div class="card-header"><h3>BOILED EGG</h3><span class="price">₱15</span></div>
                    <p class="desc">Perfectly Cooked Boiled Egg</p>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <div class="card-actions">
                        <button class="btn-add-cart" onclick="addToCart('Boiled Egg', 15, 'https://res.cloudinary.com/dn38jxbeh/image/upload/v1773501328/Boiled_Egg_nzcnsg.png')">Add to Cart! <i class="fa-solid fa-cart-shopping"></i></button>
                        <button class="btn-fav"><i class="fa-regular fa-heart"></i></button>
                    </div>
                </div>
            </div>
            </div> 
    </main>

    <div id="toast">Item added to cart!</div>
<footer id="contact">
        <div class="footer-content">
            <div class="footer-section contact-info">
                <img src="https://res.cloudinary.com/dn38jxbeh/image/upload/v1772298452/logo_ate_kabayan_jtfqeg.jpg" alt="Kainan ni Ate Kabayan Logo" class="footer-logo">
                <div class="details">
                    <p><i class="fas fa-clock"></i> OPEN DAILY (10AM - 3AM)</p>
                    <p><i class="fas fa-phone-alt"></i> (0921) 910 6057</p>
                    <p><i class="fas fa-map-marker-alt"></i> 1785 Evangelista St., Bangkal, Makati City</p>
                </div>
            </div>

            <div class="footer-section sitemap">
                <h3>SITEMAP</h3>
                <ul>
                    <li><a href="homepage.php">Home</a></li>
                    <li><a href="menu.php">Menu</a></li>
                    <li><a href="homepage.php#reserve">Reserve a Table</a></li>
                    <li><a href="About Us.php">About Us</a></li>
                    <li><a href="Contactus.php">Contact Us</a></li>
                </ul>
            </div>

            <div class="footer-section social-media">
                <h3>SOCIAL MEDIA</h3>
                <ul>
                    <li><a href="https://www.facebook.com/kainanniatekabayan"><i class="fab fa-facebook-f"></i> Kainan ni Ate Kabayan</a></li>
                    <li><a href="https://www.instagram.com/kainanniatekabayan/"><i class="fab fa-instagram"></i> @Kainan ni Ate Kabayan</a></li>
                    <li><a href="https://share.google/I9ubNtooj7WKodVWl"><i class="fab fa-google"></i> Kainan ni Ate Kabayan</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>© 2022 Kainan ni Ate Kabayan. All Right Reserved.</p>
        </div>
    </footer>   

    <script src="menu.js"></script>
</body>
</html>