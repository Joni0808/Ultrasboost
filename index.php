<!-- Made by https://michaelt.uk/ -->
<?php
include('config.php');

function convertMarkdownLinksToHtml($text) {
    $regex = '/\[(.*?)\]\((.*?)\)/'; // Findet [Linktext](URL)
    return preg_replace_callback($regex, function ($matches) {
        return '<a href="' . $matches[2] . '" target="_blank">' . $matches[1] . '</a>';
    }, $text);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title><?= $website_title ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= $website_icon ?>">
    <meta name="title" content="<?= $website_title ?>">
    <meta name="description" content="<?= $website_description ?>">
    <meta name="theme-color" coontent="<?= $website_color ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $website_url ?>">
    <meta property="og:title" content="<?= $website_title ?>">
    <meta property="og:description" content="<?= $website_description ?>">
    <meta property="og:image" content="<?= $website_banner ?>">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= $website_url ?>">
    <meta property="twitter:title" content="<?= $website_title ?>">
    <meta property="twitter:description" content="<?= $website_description ?>">
    <meta property="twitter:image" content="<?= $website_banner ?>">

    <script src="https://kit.fontawesome.com/11d13485d2.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <script src="./assets/js/particles.min.js"></script>
    <script src="https://cdn.sellix.io/static/js/embed.js"></script>
    <link href="https://cdn.sellix.io/static/css/embed.css" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        .notification-bar-container {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .notification-bar {
            background-color: #fe4a49;
            color: white;
            text-align: center;
            padding: 10px 0;
            font-size: 16px;
        }

        .close-notification {
            float: right;
            margin-right: 20px;
            cursor: pointer;
            font-weight: bold;
        }

        .icon-spacing {
            margin-right: 10px;
        }

        .stock-amount {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: #1DB954; /* Grün ähnlich dem Spotify-Logo */
            color: white;
            font-size: 12px;
            padding: 2px 5px;
            border-radius: 5px;
        }

    </style>
</head>

<body>
    <div class="notification-bar-container">
    <?php
    $currentDateTime = new DateTime();
    $currentDateTime->setTimezone(new DateTimeZone('Europe/Berlin'));

    foreach ($notifications as $notification) {
        $startDateTime = DateTime::createFromFormat('d.m.Y H:i', $notification['start_date'] . ' ' . $notification['start_time'], new DateTimeZone('Europe/Berlin'));
        $endDateTime = DateTime::createFromFormat('d.m.Y H:i', $notification['end_date'] . ' ' . $notification['end_time'], new DateTimeZone('Europe/Berlin'));
        
        if ($currentDateTime >= $startDateTime && $currentDateTime <= $endDateTime) {
            $messageWithLinks = convertMarkdownLinksToHtml($notification['message']);
            ?>
            <div class="notification-bar" style="background-color: <?= $notification['color'] ?? '#fe4a49'; ?>">
                <?php if (!empty($notification['icon'])) : ?>
                    <i class="<?= $notification['icon'] ?> icon-spacing" style="color: <?= $notification['icon_color'] ?? '#ffffff'; ?>;"></i>
                <?php endif; ?>
                <?= $messageWithLinks ?>
                <span class="close-notification" onclick="closeNotificationBar(this)">X</span>
            </div>
            <?php
        }
    }
    ?>
    </div>
    <header>
        <div id="dots"></div>

        <nav class="navbar navbar-dark navbar-expand-lg" data-aos="fade-down">
            <div class="container d-flex">
                <a class="navbar-brand" href="#">

                    <!-- Navigation Logoo -->
                    <img alt="Company logo" src="<?= $logo ?>">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav ms-auto text-center">

                        <!-- Navigation Links -->
                        <?php
                        foreach ($navlinks as $link => $location) :
                        ?>
                            <li class="nav-links">
                                <a href="<?= $location ?>"><?= $link ?></a>
                            </li>
                        <?php
                        endforeach;
                        ?>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="container text-center text-lg-start">
            <div class="row header-content" data-aos="fade-up">
                <div class="col-lg-6">
                    <div class="header-alert d-flex align-items-center gap-2 m-auto m-lg-0">
                        <img alt="Small lightning icon" src="./assets/img/icons/lightning.png">
                        <p><?= $alert ?></p>
                    </div>
                    <h1><?= $h1 ?></h1>
                    <p class="mb-5"><?= $description ?></p>

                    <div class="d-flex gap-3 justify-content-center justify-content-lg-start">
                        <a class="primary-button" href="#products">Get Started</a>
                        <a class="primary-button no-border" href="#about">Learn More</a>
                    </div>
                </div>

                <div class="col-lg-6 mt-5 mt-lg-0">
                    <img class="w-100 h-100 header-img" src="./assets/img/IMG_4320.png">
                </div>
            </div>
        </div>
    </header>

    <main>
        <?php if ($enable_features) : ?>
            <section id="about">
                <div class="container">
                    <div class="row" data-aos="fade-up">
                        <div class="col-12 text-center section-titles">
                            <h2><?= $features_title ?></h2>
                            <p><?= $features_description ?></p>
                        </div>
                    </div>

                    <div class="row">
                        <?php foreach ($features as $feature) : ?>
                            <div class="col-lg-4 mb-4" data-aos="fade-up">
                                <div class="feature-div">
                                    <div class="feature-icon">
                                        <img alt="Chart icon" src="<?= $feature['icon'] ?>">
                                    </div>
                                    <h3><?= $feature['title'] ?></h3>
                                    <p><?= $feature['description'] ?></p>
                                </div>
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                </div>
            </section>
        <?php endif ?>

        <section>
            <div class="container" id="products">
                <div class="row">
                    <div class="col-12 text-center section-titles z" data-aos="fade-up">
                        <h2>Explore Products</h2>
                        <p>Why wait to get started? View our products now!</p>
                        <p>Buy on our <a href="https://discord.gg/3weqh3eNqC" target="_blank">Discord</a> for cheaper prices! AND more/free Products!</p>
                    </div>
                </div>

                <div class="row" data-aos="fade-up">
                    <div id="categoryContainer" class="text-center mb-5"></div>

                    <?php foreach ($products['data']['products'] as $product) : ?>
                        <?php 
                        // Überspringt das Produkt, wenn es unlisted oder privat ist, oder wenn die Kategorie "all" ist.
                        if (!$displayUnlisted && $product['unlisted'] === true || $product['private'] === true || strtolower($product['categories'][0]['title']) === 'all') {
                            continue;
                        }
                        ?>
                        <div class="col-lg-4 mb-4" data-category="<?php if (!empty($product['categories'][0])) { echo $product['categories'][0]['title']; }; ?>">
                            <div class="product-div mb-3">
                                <?php if (!empty($product['image_attachment']['cloudflare_image_id'])) : ?>
                                    <img alt="Product image" src="<?= 'https://imagedelivery.net/95QNzrEeP7RU5l5WdbyrKw/' . $product['image_attachment']['cloudflare_image_id'] . '/shopitem' ?>">
                                <?php endif; ?>

                                <div class="product-body">
                                    <p class="product-title"><?= $product['title']; ?></p>
                                    <?php if (!empty($product['description'])): ?>
                                        <p class="product-description"><?= nl2br($product['description']); ?></p>
                                    <?php endif; ?>
                                    <a class="z mt-3 product-buy d-flex align-items-center justify-content-center gap-3 pointer" data-sellix-product="<?= $product['uniqid'] ?>">Purchase <div class="seperator"></div> <?= $currency . $product['price_display'] ?></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <script>
        function closeNotificationBar(element) {
            element.parentNode.style.display = 'none';
        }
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="./assets/js/index.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            var disclaimer = document.querySelector("img[alt='www.000webhost.com']");
            if(disclaimer) {
                disclaimer.remove();
            }
        });
    </script>
</body>
</html>