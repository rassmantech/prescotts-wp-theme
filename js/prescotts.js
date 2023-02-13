/**
 * Prescotts
 *
 * Globally used public facing JS. Anything here should be used on multiple types of pages
 * Use the prescotts namespace when possible to avoid conflicts and preserve scope.
 */
var prescotts = {
    init: function() {
        prescotts.mobileNav();
        prescotts.openFirstBrand();
        prescotts.sidebarBrandNav();
        prescotts.addSpanToIntlBrands();
        prescotts.equalHeights();
        prescotts.stickyQuote();
        prescotts.tableSorter();
        prescotts.exchangeRows();
        prescotts.modalWindow();
        prescotts.updateListeners();
        prescotts.listeners();
        prescotts.formatPhoneInput();
        prescotts.exchangeFormRegionFilter();
        prescotts.exchangeFormExchangeFilter();
        prescotts.testimonialsCarousel();
    },
    listeners: function() {
        jQuery(window).resize(function() {
            prescotts.equalHeights();
            prescotts.stickyQuote();
        });
        jQuery(window).scroll(function() {
            prescotts.stickyQuote();
        });
    },
    mobileNav: function() {
        jQuery("#mobilenav").mmenu({
            navbar: {
                title: false
            },
            offCanvas: {
                position: 'right',
                zposition: 'front'
            }
        });
    },
    openFirstBrand: function() {
        jQuery('ul.products li:first-child').addClass('open');
        jQuery('ul.products li:first-child ul').show();
    },
    sidebarBrandNav: function() {
        jQuery('ul.products > li > a').click(function() {
            jQuery(this).next('ul').slideToggle();
            jQuery(this).parent().toggleClass('open');
        });
    },
    addSpanToIntlBrands: function() {
        jQuery('.intl-icon.brand').each(function() {
            jQuery(this).find('a').wrapInner('<span></span>');
        });
    },
    equalHeights: function() {
        if (jQuery(window).width() > 480) {
            jQuery('.intl-icon .fl-callout-title-link').height('auto');
            var tallestHeight = 0;
            jQuery('.intl-icon').each(function() {
                var currentHeight = jQuery(this).find('.fl-callout-title-link').height();
                if (currentHeight > tallestHeight) {
                    tallestHeight = currentHeight;
                }
            });
            jQuery('.fl-callout-title-link').height(tallestHeight);
        } else {
            jQuery('.intl-icon .fl-callout-title-link').height('auto');
        }
    },
    stickyQuote: function() {
        if (jQuery('.stick-here')[0]) {
            if (jQuery(window).width() > 1068) {
                var window_top = jQuery(window).scrollTop();
                var top = jQuery('.stick-here').offset().top;
                if (window_top > top) {
                    jQuery('.product-cta-wrap').addClass('stick');
                    jQuery('.stick-here').height(jQuery('.product-cta').outerHeight());
                    jQuery('.product-cta-wrap').height(jQuery('.product-cta').outerHeight());
                    var ctaOffset = jQuery('.stick-here').offset();
                    jQuery('.product-cta').css('left', ctaOffset.left);
                    jQuery('.product-cta').width(jQuery('.stick-here').width());
                } else {
                    jQuery('.product-cta-wrap').removeClass('stick');
                    jQuery('.product-cta').css('left', '0');
                    jQuery('.product-cta').css('width', 'auto');
                    jQuery('.product-cta-wrap').css('height', 'auto');
                    jQuery('.stick-here').css('height', 'auto');
                }
            } else {
                jQuery('.product-cta-wrap').removeClass('stick');
                jQuery('.product-cta-wrap').css('height', 'auto');
                jQuery('.stick-here').css('height', 'auto');
                jQuery('.product-cta').css('width', 'auto');
            }
        }
    },
    testimonialsCarousel: function() {
        if (jQuery('.testimonials-carousel')[0]) {
            jQuery('.testimonials-carousel .slider').slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true
            });
        }
    },
    qrScanner: function() {},
    exchangeRows: function() {
        jQuery('#parts').on('click', '.add', function() {
            var currentNumber = jQuery(this).parent().parent().data('part');
            var newNumber = (currentNumber + 1);
            // Clone set
            var clonedSet = $(this).parent().parent().clone().attr('data-part', newNumber);
            // Update numbers on child elements
            clonedSet.find('#partQty').attr('name', 'partQty' + newNumber);
            clonedSet.find('#partNumber').attr('name', 'partNumber' + newNumber);
            clonedSet.find('#partNumber').val('');
            clonedSet.find('#partDescription').attr('name', 'partDescription' + newNumber);
            clonedSet.find('#partDescription').val('');
            // Append cloned set to wrapper div
            clonedSet.appendTo('#parts');
        });
        jQuery('#parts').on('click', '.remove', function() {
            jQuery(this).parent().parent().remove();
        });
    },
    modalWindow: function() {
        function openModal() {
            jQuery('#modal').addClass('open');
            jQuery('#modal-overlay').addClass('modal-open');
            jQuery('body').addClass('noscroll');
        }
        jQuery('.exchange-table .update').click(function(e) {
            e.preventDefault();
            openModal();
            var status = jQuery(this).closest('tr').children('.status').text();
            status = status.trim();
            var id = jQuery(this).closest('tr').data('id');
            switch (status) {
                case 'Shipped':
                    jQuery('#modal-content').html('<h2>Update Exchange Status</h2><a class="button" data-status="Shipped Back" href="#">Parts Shipped Back</a><a class="button" data-status="Received" href="#">Parts Received</a><a class="button" data-status="Complete" href="#">Exchange Complete</a>');
                    break;
                case 'Shipped Back':
                    jQuery('#modal-content').html('<h2>Update Exchange Status</h2><a class="button" data-status="Received" href="#">Parts Received</a><a class="button" data-status="Complete" href="#">Exchange Complete</a>');
                    break;
                case 'Received':
                    jQuery('#modal-content').html('<h2>Update Exchange Status</h2><a class="button" data-status="Complete" href="#">Exchange Complete</a>');
                    break;
                case 'Complete':
                    jQuery('#modal-content').html('<h2>Update Exchange Status</h2><a class="button" data-status="Shipped" href="#">Parts Shipped</a><a class="button" data-status="Shipped Back" href="#">Parts Shipped Back</a><a class="button" data-status="Received" href="#">Parts Received</a>');
                    break;
            }
            prescotts.modalListeners(id)
        });
        jQuery('#modal .close').click(function(e) {
            e.preventDefault();
            jQuery(this).parent().removeClass();
            jQuery('#modal-overlay').removeClass();
            jQuery('body').removeClass('noscroll');
        });
    },
    tableSorter: function() {
        if (jQuery('.exchange-table#list')[0]) {
            jQuery('.exchange-table#list').tablesorter({
                headers: {
                    '.sort-disabled': {
                        sorter: false
                    }
                }
            });
        }
    },
    modalListeners: function(id) {
        jQuery('#modal-content .button').each(function() {
            jQuery(this).off().on('click', function() {
                if (jQuery(this).hasClass('closeBtn')) {
                    jQuery('#modal').removeClass();
                    jQuery('#modal-overlay').removeClass();
                    jQuery('body').removeClass('noscroll');
                } else {
                    var status = jQuery(this).data('status');
                    prescotts.updateExchangeStatus(status, id)
                }
            });
        });
    },
    updateListeners: function() {
        var currentStatus = jQuery('#exchange-update').data('status');
        jQuery('#exchange-update .button').each(function() {
            if (jQuery(this).data('status') == currentStatus) {
                jQuery(this).addClass('current');
            }
            jQuery(this).on('click', function(e) {
                e.preventDefault();
                var id = jQuery(this).parent().data('id');
                var status = jQuery(this).data('status');
                prescotts.updateExchangeStatus(status, id)
            });
        });
    },
    updateExchangeStatus: function(status, id) {
        var num = jQuery('#order-id').text();
        jQuery.ajax({
            type: 'post',
            url: ajax_object.ajax_url,
            data: {
                'action': 'prescott_update_exchange_status',
                'data': {
                    'status': status,
                    // 'security': ajax_object.ajax_nonce,
                    'id': id
                }
            },
            success: function(data) {
                var alert = confirm('Exchange # ' + num + ' has been updated.');
                if (alert) {
                    location.reload();
                };
            },
        })
    },
    exchangeFormListener: function() {
        var loc = window.location.href;
        setTimeout(function() {
            window.onbeforeunload = null;
            window.location.href = loc + '/active/';
        }, 10);
    },
    exchangeFormRegionFilter: function() {
        jQuery('.region-filter').on('change', function() {
            jQuery('.exchange-filter').val('all');
            var region = jQuery(this).val();
            if (region === 'all') {
                jQuery('.exchange-table > tbody > tr').removeClass('exchange-hidden').addClass('exchange-visible');
            } else {
                jQuery('.exchange-table > tbody > tr').removeClass('exchange-visible').addClass('exchange-hidden');
                jQuery('.exchange-table > tbody > tr').filter('tr[data-region=' + region + ']').removeClass('exchange-hidden').fadeIn(300).addClass('exchange-visible');
            }
        })
    },
    exchangeFormExchangeFilter: function() {
        jQuery('.exchange-filter').on('change', function() {
            jQuery('.region-filter').val('all');
            var exchange = jQuery(this).val();
            if (exchange === 'all') {
                jQuery('.exchange-table > tbody > tr').removeClass('exchange-hidden').addClass('exchange-visible');
            } else {
                jQuery('.exchange-table > tbody > tr').removeClass('exchange-visible').addClass('exchange-hidden');
                jQuery('.exchange-table > tbody > tr').filter(function(ind) {
                    var dataId = jQuery(this).data('id');
                    dataId = dataId.split("-").pop();
                    return (dataId === exchange);
                }).removeClass('exchange-hidden').fadeIn(300).addClass('exchange-visible');
            }
        })
    },
    formatPhoneInput: function() {
        jQuery('input[type="tel"]').on('keydown', function(e) {
            if (e.keyCode != (8 || 46)) {
                var val = jQuery(this).val();
                if (val) {
                    var len = val.length;
                    if (len === 3) {
                        jQuery(this).val(val + '-');
                    }
                    if (len === 7) {
                        jQuery(this).val(val + '-');
                    }
                }
            }
        })
    },
}
// Init
jQuery('document').ready(function() {
    prescotts.init();
});
