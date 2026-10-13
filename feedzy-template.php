<?php
/**
 * Card-grid template for FEEDZY RSS Feeds.
 */
?>
<style>
	
.feedzy-custom-template .rss_header h2 {
	display: none !important;
}
	
.feedzy-custom-template {
    --custom-purple: #63256f;
    --custom-blue: #294cff;
    --custom-border: #d9d9d9;
    --custom-text: #555;

    width: 100%;
    max-width: 100%;
    overflow: visible !important;
}

/* Header */
.feedzy-custom-template .rss_header {
    margin-bottom: 30px;
}

.feedzy-custom-template .rss_header h2 {
    margin: 0;
}

.feedzy-custom-template .rss_header h2 a {
    color: var(--custom-purple) !important;
    font-size: 28px;
    font-weight: 700;
    text-decoration: none;
}

.feedzy-custom-template .rss_header h2 span {
    display: block;
    color: var(--custom-purple);
    letter-spacing: 2px;
    font-size: 14px;
}

/* Grid */
.feedzy-custom-template ul.feedzy-default {
    display: grid !important;
    grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
    gap: 24px !important;

    width: 100% !important;
    max-width: none !important;

    margin: 0 auto !important;
    padding: 0 !important;

    list-style: none !important;
    box-sizing: border-box;
}

/* Remove old Feedzy clearfix elements */
.feedzy-custom-template ul.feedzy-default::before,
.feedzy-custom-template ul.feedzy-default::after {
    display: none !important;
    content: none !important;
}

/* Cards */
.feedzy-custom-template ul.feedzy-default > li,
.feedzy-custom-template ul.feedzy-default > li.rss_item,
.feedzy-custom-template ul.feedzy-default > li[class*="feedzy-rss-col"] {

    width: auto !important;
    min-width: 0 !important;
    max-width: none !important;

    display: flex !important;
    flex-direction: column;

    height: 100%;

    margin: 0 !important;

    /* CRITICAL */
    padding: 0 !important;

    border: 1px solid var(--custom-border);
    border-top: 4px solid var(--custom-blue);

    background: #fff;

    overflow: visible !important;

    box-sizing: border-box;
}

/* Image */
.feedzy-custom-template .rss_image {

    float: none !important;

    width: 100% !important;
    height: 240px !important;

    margin: 0 !important;
    padding: 0 !important;

    overflow: hidden;
}

.feedzy-custom-template .rss_image a {
    display: block;
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
}

.feedzy-custom-template .rss_image img {

    display: block;

    width: 100% !important;
    height: 100% !important;

    margin: 0 !important;
    padding: 0 !important;

    object-fit: cover !important;
    object-position: center center;
}

/* Title */
.feedzy-custom-template .title {
    display: block;
    padding: 16px 16px 0 16px;
}

.feedzy-custom-template .title a {
    color: var(--custom-purple) !important;

    font-size: 20px;
    font-weight: 700;
    line-height: 1.2;

    text-decoration: none;
}

.feedzy-custom-template .title a:hover {
    text-decoration: underline;
}

/* Content */
.feedzy-custom-template .rss_content {

    width: 100% !important;

    flex-grow: 1;

    box-sizing: border-box;

    padding: 0 16px 16px 16px !important;

    color: var(--custom-text);

    font-size: 14px;
    line-height: 1.6;
}

.feedzy-custom-template .rss_content small {
    display: block;
    margin-top: 8px;
}

.feedzy-custom-template .rss_content p {
    margin-top: 12px;
}

/* Tablet */
@media (max-width: 1200px) {
    .feedzy-custom-template ul.feedzy-default {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}

/* Mobile */
@media (max-width: 768px) {
    .feedzy-custom-template ul.feedzy-default {
        grid-template-columns: 1fr !important;
    }
}
</style>

<div class="feedzy-custom-template">
  <div class="<?php echo esc_attr( feedzy_feed_class() ); ?>">
    <?php if ( $feed_title['use_title'] ) { ?>
    <div class="rss_header">
      <h2>
        <a href="<?php echo esc_url( feedzy_feed_link() ); ?>" class="<?php echo esc_attr( $feed_title['rss_title_class'] ); ?>" rel="noopener"><?php echo wp_kses_post( feedzy_feed_title() ); ?></a>
        <span class="<?php echo esc_attr( $feed_title['rss_description_class'] ); ?>"><?php echo wp_kses_post( feedzy_feed_desc() ); ?></span>
      </h2>
    </div>
    <?php } ?>
    <ul class="feedzy-default">
      <?php foreach ( $feed_items as $item ) {
        // Base link for this post
        $base_link = feedzy_feed_item_link( $item );

        // UTM params – utm_content differs by click target
        $utm_common = array(
          'utm_source'   => 'example.com',
          'utm_medium'   => 'my-example-site',
          'utm_campaign' => 'rss-feed',
        );

        // Image click → utm_content=image
        $image_link = add_query_arg( array_merge( $utm_common, array( 'utm_content' => 'image' ) ), $base_link );

        // Headline click → utm_content=headline
        $headline_link = add_query_arg( array_merge( $utm_common, array( 'utm_content' => 'headline' ) ), $base_link );
      ?>
      <li <?php echo wp_kses_post( $item['itemAttr'] ); ?>>
        <?php if ( ! empty( $item['item_img'] ) && 'no' !== $sc['thumb'] ) { ?>
        <div class="<?php echo esc_attr( $item['item_img_class'] ); ?>">
          <a href="<?php echo esc_url( $image_link ); ?>" target="<?php echo esc_attr( $item['item_url_target'] ); ?>" rel="noopener <?php echo isset( $item['item_url_follow'] ) ? esc_attr( $item['item_url_follow'] ) : ''; ?>" title="<?php echo esc_attr( $item['item_url_title'] ); ?>">
            <?php add_filter( 'safecss_filter_attr_allow_css', '__return_true' ); echo wp_kses_post( feedzy_feed_item_image( $item ) ); remove_filter( 'safecss_filter_attr_allow_css', '__return_true' ); ?>
          </a>
        </div><?php } ?>
        <span class="title"><a href="<?php echo esc_url( $headline_link ); ?>" target="<?php echo esc_attr( $item['item_url_target'] ); ?>" rel="noopener <?php echo isset( $item['item_url_follow'] ) ? esc_attr( $item['item_url_follow'] ) : ''; ?>"><?php echo wp_kses_post( feedzy_feed_item_title( $item ) ); ?></a></span>
        <div class="<?php echo esc_attr( $item['item_content_class'] ); ?>" style="<?php echo esc_attr( $item['item_content_style'] ); ?>">
          <?php if ( ! empty( $item['item_meta'] ) ) { ?><small><?php echo wp_kses_post( feedzy_feed_item_meta( $item ) ); ?></small><?php } ?>
          <?php if ( ! empty( $item['item_description'] ) ) { ?><p><?php echo wp_kses_post( feedzy_feed_item_desc( $item ) ); ?></p><?php } ?>
        </div>
      </li>
      <?php } ?>
    </ul>
  </div>
</div>
```