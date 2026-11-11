<?php require_once 'connection.php'; ?>
<?php include 'header.php'; ?>
<!-- main area start  -->
<main>
    <!-- breadcrumb start -->
    <section class="breadcrumb position-bottom bg_img" data-background="assets/img/bg/page_title.png">
        <div class="container">
            <div class="breadcrumb__content text-center">
                <h2 class="breadcrumb__title">Blog</h2>
                <ul class="breadcrumb__list clearfix">
                    <li class="breadcrumb-item"><a href="index.php">Protinut</a></li>
                    <li class="breadcrumb-item">Blog</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- breadcrumb end -->

    <!-- blog start -->
    <section class="blog pt-115 pb-385">
        <div class="container">
            <div class="row mt-none-30">
                <div class="col-lg-8 mt-30">
                    <div class="blog-post-wrapper">
                        <?php
                        $search_query = "";
                        $where_clause = " WHERE 1=1 ";
                        if (isset($_GET['search']) && !empty($_GET['search'])) {
                            $search_query = mysqli_real_escape_string($link, $_GET['search']);
                            $where_clause .= " AND title LIKE '%$search_query%' ";
                        }
                        if (isset($_GET['cat']) && !empty($_GET['cat'])) {
                            $cat_id = (int)$_GET['cat'];
                            $where_clause .= " AND category_id = $cat_id ";
                            $cat_name_q = mysqli_query($link, "SELECT name FROM blog_categories WHERE id = $cat_id");
                            $cat_name_res = mysqli_fetch_assoc($cat_name_q);
                            echo "<h4 class='mb-40'>Category: '" . htmlspecialchars($cat_name_res['name'] ?? 'Unknown') . "'</h4>";
                        }
                        if ($search_query) {
                            echo "<h4 class='mb-40'>Search Results for: '" . htmlspecialchars($_GET['search']) . "'</h4>";
                        }
                        
                        $blog_res = mysqli_query($link, "SELECT * FROM blogs $where_clause ORDER BY id DESC");
                        if ($blog_res && mysqli_num_rows($blog_res) > 0) {
                            while ($blog = mysqli_fetch_assoc($blog_res)) {
                                $blog_image = $blog['image'] ?: 'assets/img/blog/post_01.jpg';
                                $blog_date = date('F d, Y', strtotime($blog['created_at']));
                                // Basic excerpt logic
                                $excerpt = substr(strip_tags($blog['content']), 0, 180) . '...';
                                ?>
                                <article class="single-post-item">
                                    <div class="post-thumbnail-wrapper">
                                        <a href="blog-single.php?id=<?php echo $blog['id']; ?>">
                                            <?php if ($blog['media_type'] == 'video'): ?>
                                                <div class="video-thumbnail-wrapper" style="position:relative; width:100%; height:100%;">
                                                    <video src="<?php echo htmlspecialchars($blog_image); ?>" muted loop playsinline onmouseover="this.play()" onmouseout="this.pause()" style="width:100%; height:100%; object-fit:cover; display:block;"></video>
                                                    <div class="play-btn" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-size:40px;color:#fff;pointer-events:none;"><i class="fas fa-play-circle"></i></div>
                                                </div>
                                            <?php else: ?>
                                                <img src="<?php echo htmlspecialchars($blog_image); ?>" alt="">
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                    <div class="post-content-wrapper">
                                        <ul class="post-meta ul_li">
                                            <li><span><i class="far fa-user"></i><span
                                                        class="author vcard"><?php echo htmlspecialchars($blog['author']); ?></span></span>
                                            </li>
                                            <li><a href="#!"><i class="far fa-comments"></i> Comments (0)</a></li>
                                            <li><span class="posted-on"><i class="far fa-clock"></i> <a
                                                        href="#!"><?php echo $blog_date; ?></a></span></li>
                                        </ul>
                                        <h3 class="post-title border_effect"><a
                                                href="blog-single.php?id=<?php echo $blog['id']; ?>"><?php echo htmlspecialchars($blog['title']); ?></a>
                                        </h3>
                                        <div class="post-excerpt">
                                            <p><?php echo htmlspecialchars($excerpt); ?></p>
                                        </div>
                                        <div class="post-read-more">
                                            <a class="thm-btn thm-btn--black"
                                                href="blog-single.php?id=<?php echo $blog['id']; ?>">Read More</a>
                                        </div>
                                    </div>
                                </article>
                            <?php }
                        } else {
                            echo "<article class='single-post-item'><p class='text-center'>No blog posts found.</p></article>";
                        } ?>
                    </div>
                </div>
                <div class="col-lg-4 mt-30">
                    <div class="blog-sidebar sidebar-area mt-none-40">
                        <div class="widget mt-40">
                            <h2 class="widget__title">Search</h2>
                            <form class="widget__search" action="#">
                                <input type="text" placeholder="Search...">
                                <button><i class="far fa-search"></i></button>
                            </form>
                        </div>
                        <div class="widget mt-40">
                            <h2 class="widget__title">Related Posts</h2>
                            <div class="widget__post">
                                <?php
                                $related_res = mysqli_query($link, "SELECT * FROM blogs ORDER BY id DESC LIMIT 4");
                                if ($related_res && mysqli_num_rows($related_res) > 0) {
                                    while ($related = mysqli_fetch_assoc($related_res)) {
                                        $rel_img = $related['image'] ?: 'assets/img/blog/post_03.jpg';
                                        $rel_date = date('d M/y', strtotime($related['created_at']));
                                        ?>
                                        <div class="widget__post-item ul_li">
                                            <div class="post-thumb">
                                                <a href="blog-single.php?id=<?php echo $related['id']; ?>"><img
                                                        src="<?php echo htmlspecialchars($rel_img); ?>" alt=""></a>
                                            </div>
                                            <div class="post-content">
                                                <div class="post-meta">
                                                    <a href="#!"><i
                                                            class="invite-text-gr-color far fa-user"></i>By <?php echo htmlspecialchars($related['author']); ?></a>
                                                    <a href="#!"><i
                                                            class="invite-text-gr-color far fa-calendar"></i><?php echo $rel_date; ?></a>
                                                </div>
                                                <h4 class="post-title border-effect-2"><a
                                                        href="blog-single.php?id=<?php echo $related['id']; ?>"><?php echo htmlspecialchars($related['title']); ?></a>
                                                </h4>
                                            </div>
                                        </div>
                                    <?php }
                                } else {
                                    echo "<p>No recent posts.</p>";
                                } ?>
                            </div>
                        </div>
                        <div class="widget mt-40">
                            <h2 class="widget__title">
                                <span>Explore Categories</span>
                            </h2>
                            <ul class="widget__category list-unstyled">
                                <?php
                                $categories_q = mysqli_query($link, "SELECT c.*, (SELECT COUNT(*) FROM blogs WHERE category_id = c.id) as blog_count FROM blog_categories c");
                                while ($cat = mysqli_fetch_assoc($categories_q)) {
                                    $active_cat = (isset($_GET['cat']) && $_GET['cat'] == $cat['id']) ? 'active_cat' : '';
                                    ?>
                                    <li><a href="blog.php?cat=<?php echo $cat['id']; ?>" class="<?php echo $active_cat; ?>"><?php echo htmlspecialchars($cat['name']); ?> <span>(<?php echo $cat['blog_count']; ?>)</span></a></li>
                                <?php } ?>
                                <li><a href="blog.php">All Categories</a></li>
                            </ul>
                        </div>

                        <div class="widget mt-40">
                            <h2 class="widget__title">
                                <span>Tags</span>
                            </h2>
                            <div class="tagcloud">
                                <a href="#!">energy</a>
                                <a href="#!">fitness</a>
                                <a href="#!">healthy</a>
                                <a href="#!">powders</a>
                                <a href="#!">nutrition</a>
                                <a href="#!">snacks</a>
                                <a href="#!">wellness</a>
                                <a href="#!">powders</a>
                                <a href="#!">diet</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- blog end -->
</main>
<!-- main area end  -->

<!-- footer strt -->
<footer class="position-top bg_img pb-70" data-background="assets/img/bg/footer_bg.png">
    <div class="container">
        <div id="contact" class="contact pb-100">
            <div class="row">
                <div class="col-lg-7">
                    <div class="xb-contact contact-mt--255">
                        <div class="contact-title mb-35">
                            <span><img src="assets/img/icon/directbox-notif.svg" alt="">Contact Us</span>
                            <h3>Do you have questions or went more <br> information?</h3>
                        </div>
                        <form class="contact-from" id="contactForm" action="contact_action.php" method="POST">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="xb-item--field">
                                        <span><img src="assets/img/icon/c_user.svg" alt=""></span>
                                        <input type="text" name="name" placeholder="Your Name" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="xb-item--field">
                                        <span><img src="assets/img/icon/c_mail.svg" alt=""></span>
                                        <input type="email" name="email" placeholder="Your Email" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="xb-item--field">
                                        <span><img src="assets/img/icon/c_call.svg" alt=""></span>
                                        <input type="text" name="phone" placeholder="+91 081 0256 023">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="xb-item--field">
                                        <span><img src="assets/img/icon/c_message.svg" alt=""></span>
                                        <textarea name="message" cols="30" rows="10" placeholder="Write Your Message..."
                                            required></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="thm-btn thm-btn--black" type="submit">Send Message</button>
                                    <div id="contactFeedback" class="mt-2" style="display:none;"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="contact-info contact-mt--255 mt-md-30">
                        <div class="xb-item--head">
                            <div class="xb-item--address">
                                <h3><img src="assets/img/icon/location.svg" alt="">our address</h3>
                                <p>100 Orchard st, New <br> York,NY 100025 USA</p>
                            </div>
                            <div class="xb-item--open">
                                <p>Monday - Friday <br>
                                    08:00AM - 05:00PM</p>
                                <a href="mailto:support@protinut.com"><img src="assets/img/icon/sms-tracking.svg"
                                        alt="">support@protinut.com</a>
                            </div>
                            <ul class="xb-item--social ul_li mt-30">
                                <li><a href="#!"><i class="fab fa-telegram-plane"></i></a></li>
                                <li><a href="#!"><i class="fab fa-whatsapp"></i></a></li>
                                <li><a href="#!"><i class="fab fa-facebook-f"></i></a></li>
                            </ul>
                        </div>
                        <div class="xb-item--cta" data-background="assets/img/bg/cta_bg.jpg">
                            <p>Our help desk is a vailable for you <br> every day, 07:00AM - 10:00PM</p>
                            <h3>+91 081 256 023</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-inner">
            <div class="footer-logo mb-25 text-center">
                <a href="index.php" class="site-logo-text">Protinut</a>
            </div>
            <div class="sec-title sec-title--white text-center mb-50">
                <h2 class="title">in a healthy body, healthy mind</h2>
            </div>
            <ul class="footer-nav ul_li_center">
                <li><a href="#!">all products</a></li>
                <li><a href="#!">track order</a></li>
                <li><a href="#!">my account</a></li>
                <li><a href="#!">gift cards</a></li>
                <li><a href="#!">our story</a></li>
                <li><a href="#!">careers</a></li>
                <li><a href="#!">contact</a></li>
            </ul>
            <div class="footer-bottom mt-50 ul_li_between">
                <div class="footer-copyright mt-30">
                    Copyright © 2024 Protinut All rights reserved.
                </div>
                <ul class="footer-links ul_li mt-30">
                    <li><a href="#!">terms of conditions</a></li>
                    <li><a href="#!">privacy pllicy</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!-- footer end -->


</div>

<!-- jquery include -->
<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/swiper.min.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/touchspin.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>
<script src="assets/js/jquery.inview.min.js"></script>
<script src="assets/js/jquery.easing.js"></script>
<script src="assets/js/scrollspy.js"></script>
<script src="assets/js/main.js"></script>

</body>


<!-- Mirrored from html.xpressbuddy.com/Protinut/blog.php by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 27 Feb 2026 11:44:56 GMT -->

</html>
