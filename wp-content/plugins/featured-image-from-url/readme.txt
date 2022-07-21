=== Plugin Name ===
Contributors: marceljm
Donate link: https://donorbox.org/fifu
Tags: featured, image, url, video, woocommerce
Requires at least: 5.3
Tested up to: 6.0.1
Stable tag: 4.0.3
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Use an external image/video as featured image/video of a post or WooCommerce product.

== Description ==

### WordPress plugin for external featured images, videos and more

Since 2015 FIFU has helped thousands of websites worldwide to save money on storage, processing and copyright.

If you are tired of wasting time and resources with thumbnail regeneration, image optimization and never-ending imports, this plugin is for you.

#### FEATURED IMAGE
Use an external image as featured image of your post, page or custom post type.

* External featured image
* Unsplash image search
* Default featured image
* Hide featured media
* Featured image in content
* Auto set image title
* Save image dimensions
* Featured image column
* **[PRO]** Disable right-click
* **[PRO]** Save in the media library
* **[PRO]** Unsplash image size
* **[PRO]** Same height
* **[PRO]** Hover effects
* **[PRO]** Replace not found image
* **[PRO]** Image validation
* **[PRO]** Page redirection

#### AUTOMATIC FEATURED MEDIA

* Auto set featured media from post content
* **[PRO]** Auto set featured image using post title and search engine
* **[PRO]** Auto set featured image using ISBN and books API
* **[PRO]** Auto set screenshot as featured image
* **[PRO]** Auto set featured media using web page address
* **[PRO]** Auto set featured image from Unsplash using tags

#### PERFORMANCE

* CDN + optimized thumbnails
* Lazy load

#### SOCIAL

* Social tags
* **[PRO]** Media RSS tags
* **[PRO]** bbPress features

#### AUTOMATION

* WP-CLI integration
* **[PRO]** WP All Import add-on
* **[PRO]** WooCommerce import
* **[PRO]** WP REST API
* **[PRO]** WooCommerce REST API
* **[PRO]** Schedule metadata generation

#### WOOCOMMERCE

* External product image
* Lightbox and zoom
* Category image on grid
* **[PRO]** External image gallery
* **[PRO]** External video gallery
* **[PRO]** Auto set category images
* **[PRO]** Variable product
* **[PRO]** Variation image
* **[PRO]** Variation image gallery
* **[PRO]** Save images in the media library
* **[PRO]** FIFU product gallery
* **[PRO]** Fast Buy

#### FEATURED VIDEO
Supports videos from YouTube, Vimeo, Imgur, 9GAG, Cloudinary, Tumblr, Publitio, JW Player, VideoPress, Sprout and media library.

* **[PRO]** Featured video
* **[PRO]** Video thumbnail
* **[PRO]** Play button
* **[PRO]** Minimum width
* **[PRO]** Video controls
* **[PRO]** Mouseover autoplay
* **[PRO]** Autoplay
* **[PRO]** Loop
* **[PRO]** Mute
* **[PRO]** Background video
* **[PRO]** Gallery icon

#### ELEMENTOR WIDGETS

* Featured image 
* **[PRO]** Featured video

#### WORDPRESS WIDGETS

* **[PRO]** Featured media 
* **[PRO]** Featured grid
* **[PRO]** Product gallery

#### OTHERS

* **[PRO]** Quick edit
* **[PRO]** Featured slider 
* **[PRO]** Featured shortcode
* **[PRO]** FIFU shortcodes

#### INTEGRATION FUNCTION FOR DEVELOPERS

* fifu_dev_set_image($post_id, $image_url)
* **[PRO]** fifu_dev_set_image_list($post_id, $image_url_list)
* **[PRO]** fifu_dev_set_video($post_id, $video_url)
* **[PRO]** fifu_dev_set_category_image($term_id, $image_url)
* **[PRO]** fifu_dev_set_category_video($term_id, $video_url)

#### FIFU CLOUD (beta)

* Cloud storage (never lose an image again)
* Global CDN (images loaded much faster)
* Optimized thumbnails (processed in the cloud)
* Pay-as-you-go (per stored image)
* Smart crop (detects people and objects before cropping)
* Hotlink protection (sites can't embed your images)

#### LINKS

* **<a href="https://fifu.app/">FIFU PRO</a>**
* **<a href="https://tastewp.com/new?pre-installed-plugin-slug=featured-image-from-url&redirect=admin.php%3Fpage%3Dfeatured-image-from-url&ni=true">Dummy site for testing</a>**
* **<a href="https://referral.fifu.app/">Affiliate Program</a>**
* **<a href="https://chrome.google.com/webstore/detail/fifu-scraper/pccimcccbkdeeadhejdmnffmllpicola">Google Chrome extension</a>**

#### FIFU, the best WordPress plugin for...
Featured Image, Figurë e Zgjedhur, Image mise en avant, Uitgelichte afbeelding, وێنەی تایبەت, Obrazek wyróżniający, Tugna tameẓlit, Beitragsbild, გამორჩეული სურათი, Utvald bild, 特色图片, تصویر ویژه, Framhevet bilde, Artikkelikuva, Ilustračný obrázok, Imaxe destacada, Ảnh đại diện, Prikazna slika, Imagine reprezentativă, Imagen destacada, 특성 이미지, Delwedd Nodwedd, รูปประจำเรื่อง, Immagine in evidenza, 特選圖片, Imagem destacada, Imagem de destaque, Избранное изображение, アイキャッチ画像, Pśinoskowy wobraz, Öne çıkan görsel, Přinoškowy wobraz, Uitgelichte Afbeelding


== Installation ==

### INSTALL FIFU FROM WITHIN WORDPRESS

1. Visit the plugins page within your dashboard and select 'Add New';
1. Search for 'Featured Image from URL';
1. Activate FIFU from your Plugins page;

### INSTALL FIFU MANUALLY

1. Upload the 'featured-image-from-url' folder to the /wp-content/plugins/ directory;
1. Activate the FIFU plugin through the 'Plugins' menu in WordPress;


== Frequently Asked Questions ==

= Why isn't preview button working? =

* Your image URL is invalid. Take a look at FIFU Settings > Getting started.

= Does FIFU save the images in the media library? =

* No. Only the PRO version is capable of doing this, but it is optional. The plugin was designed to work with external images.

= Why the featured image is being displayed twice? =

* You enabled "Featured Image in Content" option unnecessarily.

= Why the featured image is not being displayed? =

* Please check if "Hide Featured Media" option is unduly enabled.

= Why are there no changes after changing the settings? =

* Try to clean your cache.

= Is any action necessary before removing FIFU?

* Access settings and clean the metadata.

= What's the metadata created by FIFU?

* Database registers that help WordPress components to work with the external images. FIFU can generate the metadata of ~50,000 image URLs per minute.

= What are the disadvantages of the external images?

* No image optimization or thumbnails by default. You can fix that with CDN + Optimized Thumbnails feature (performance settings).

= What are the advantages of the external images?

* You save money on storage, processing and copyright. And you can have extremely fast import processes.

= Is it legal to embed images without permission?

* Yes, it is. Click [here](https://www.globalbankingandfinance.com/embedding-images-the-legal-way-to-steal/) to know more.

= Do external images affect SEO?

* No, they don't. Click [here](https://www.searchenginejournal.com/does-using-a-cdn-improve-ranking/) to know more.


== Screenshots ==

1. Featured image

2. Unsplash image search

3. Featured video

4. Image gallery for WooCommerce products

5. Image gallery for WooCommerce product variations

6. Quick edit

7. Elementor widgets

8. Settings: featured image

9. Settings: featured video

10. Settings: featured slider

11. Settings: shortcode

12. Settings: automatic

13. Settings: social

14. Settings: performance

15. Settings: WooCommerce

16. Settings: WP All Import

17. Settings: REST API

18. Settings: Admin

19. Settings: Metadata

20. integration functions for developers

21. FIFU Cloud


== Changelog ==

= 4.0.3 =
* New FIFU Shortcode: for featured slider.

= 4.0.2 =
* New option: FIFU Product Gallery > videos before images; fix: Default Featured Image > Post types; FIFU Cloud: more details about how it can improve or replace other plugin features.

= 4.0.1 =
* Enhancement: security (validation, sanitization and escaping of option values).

= others =
* [more](https://fifu.app/changelog)


== Upgrade Notice ==

= 4.0.3 =
* New FIFU Shortcode: for featured slider.
