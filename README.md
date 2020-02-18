# Codilar magento2-banner-slider
A magento 2 module to show banners within a slider. The smart way

The module comes with 4 types of banners which you can add to your sliders.
1. __Local image__ (upload or select from wysiwyg gallery)
2. __External image__ (URL)
3. __YouTube video__ (URL)
4. __Custom HTML__ (WYSIWYG editor provided)

But feel free to extend the module to make more types if you want!

### Also easily create different resource maps, to facilitate showing different kinds of banners for different screen resolutions (like mobile, desktop, tablet, and TV)!

## Steps to install

1. __Via Composer__ `composer require codilar/magento2-banner-slider` (__Recommended__)

2. __Manually__ Clone or download [this repository](https://github.com/Codilar/magento2-banner-slider) and put it in `app/code/Codilar/BannerSlider`

## Steps to create a slider
1. Login to your Admin panel
2. Go to `Content > Banner Slider > Manage Sliders` and create a new slider
3. Go to `Content > Banner Slider > Manage Resource Maps` to create a new resource type (it takes three parameters, the title, and the min width, and max width which you can leave blank for ignoring)
4. Go to `Content > Banner Slider > Manage Banners` to add a new banner. Assign the banner to the slider created in step 2 and resource map created in step 3
5. Done!

## How to use the slider
1. Widget support
2. REST API support
3. GraphQL API support
