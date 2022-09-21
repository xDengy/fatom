var animate = false;
var wScroll;

if (document.querySelector('#userPhoneCB')) {
    Inputmask({"mask": "+7(999)999-99-99"}).mask("#userPhoneCB");
}
if (document.querySelector('#userPhone')) {
    Inputmask({"mask": "+7(999)999-99-99"}).mask("#userPhone");
}
if (document.querySelector('#phone')) {
    Inputmask({"mask": "+7(999)999-99-99"}).mask("#phone");
}
if (document.querySelector('#modal_tel')) {
    Inputmask({"mask": "+7(999)999-99-99"}).mask("#modal_tel");
}

$(document).ready(function () {
    let search = document.querySelector('.navigation .search')
    search.querySelector('.search-btn').addEventListener('click', function () {
        search.querySelector('.search-form').style.display = 'block'
    })
    $(".modalList li").each(function (index) {
        $(this).find("label").attr("for", $(this).find("label").attr("for") + "_modal");
        $(this).find("input").attr("id", $(this).find("input").attr("id") + "_modal");
    });

    if ($("form.msearch2").length) {
        // mSearch2.Form.initialize("form.msearch2");
    }


    // input type number
    // Уменьшаем на 1
    $(document).on('click', '.input-number__minus', function () {
        let total = $(this).next();
        if (+total.val() > 1) {
            total.val(total.val() - 1);
        }
    });
    // Увеличиваем на 1
    $(document).on('click', '.input-number__plus', function () {
        let total = $(this).prev();
        total.val(+total.val() + 1);
    });
    // Запрещаем ввод текста
    document.querySelectorAll('.input-number__input').forEach(function (el) {
        el.addEventListener('input', function () {
            this.value = this.value.replace(/[^\d]/g, '');
        });
    });


    let li = document.querySelectorAll('.mobile-catalog .nav li.dropdown');
    for (let i = 0; i < li.length; i++) {
        let arrow = li[i].querySelector('.dropdown-arrow')
        if (arrow) {
            arrow.addEventListener('click', function () {
                li[i].querySelector('.dropdown-row').classList.toggle('drop');
            })
        }
    }
    let submen = document.querySelectorAll('div.submenu2')
    for (let i = 0; i < submen.length; i++) {
        submen[i].addEventListener('click', function () {
            submen[i].parentElement.parentElement.querySelector('.dropdown-row.drop').classList.remove('drop');
        })
    }


    jQuery(document).on('click', ".plus", function () {
        $(".tovar-quality input").val(+$(".tovar-quality input").val() + 1);
    });
    jQuery(document).on('click', ".minus", function () {

        if ($(".tovar-quality input").val() === "1") {
            return false
        } else {
            $(".tovar-quality input").val(+$(".tovar-quality input").val() - 1);
        }
    });


    wscr();
    mobmenu();

    /*
	if($("*").is(".parallax")) {
		$.stellar();
	}
	*/
    $("body").on("click", ".scroll", function (event) {
        elementClick = $(this).attr("href");
        destination = $(elementClick).offset().top;
        $("body,html").animate({scrollTop: destination}, 700);
        return false;
    });

    // if($("*").is(".decimal")) {
    // 	$(".decimal").inputmask({
    // 		'alias': 'decimal',
    // 		'mask': "9{1,3}[.9{0,1}]"
    // 	});
    // }
    //
    // if($("*").is(".integer")) {
    // 	$(".integer").inputmask("9{0,10}");
    // }

    $(".search .search-btn").click(function () {
        $(this).toggleClass("active");
        $(".search-form").fadeIn(100);
        return false;
    });

    $(document).mouseup(function (e) {
        var container = $(".search form");
        if (container.has(e.target).length === 0) {
            if ($(".search .search-btn").hasClass("active")) {
                $(".search .search-btn").removeClass("active")
                $(".search-form").fadeOut(100);
            }
        }
    });

    $(".out").on("click", ".mobmenu-toggle", function (event) {
        event.preventDefault();
        if (!animate) {
            animate = true;
            $(this).toggleClass("active");
            if ($(this).hasClass("active")) {
                $(".mobmenu").addClass("open");
                $("body").addClass("openmenu");
                $(".openmenu").css("padding-right", wScroll + "px");
                $(".header").css("margin-right", wScroll + "px");
                setTimeout(function () {
                    animate = false;
                }, 600);
            } else {
                $(".mobmenu").removeClass("open");
                $(".openmenu").css("padding-right", "0px");
                $(".header").css("margin-right", "0px");
                $("body").removeClass("openmenu");
                setTimeout(function () {
                    animate = false;
                }, 600);
            }
        }

        return false;
    });

    $(".out").on('click', '.mobmenu .dropdown-toggle', function (e) {
        $(this).parents(".dropdown").toggleClass("active");
        $(this).parents(".dropdown").find('.dropdown-menu').first().stop(true, true).animate({
            opacity: 'toggle',
            height: 'toggle'
        }, 300);
        return false;
    });

    if ($("*").is(".catalog-categories .open")) {
        $(".catalog-categories .open .category-list").show(0);
    }

    $(".catalog-categories").on("click", ".category-name a", function (event) {
        event.preventDefault();
        $(this).parents(".category").toggleClass("open");
        $(this).parents(".category").find(".category-list").slideToggle(300);
    });

    if ($("*").is(".catalog-filter .uislider")) {
        function refreshSwatch(slider, ui) {
            slider.parents(".uislider").find(".value.min input").val(ui.values[0]);
            slider.parents(".uislider").find(".value.max input").val(ui.values[1]);
            slider.parents(".uislider").find(".ui-slider-handle-min span").text(ui.values[0]);
            slider.parents(".uislider").find(".ui-slider-handle-max span").text(ui.values[1]);
        }

        $('.catalog-filter .uislider .uislider-container').each(function () {
            var slider = $(this);
            $(this).slider({
                range: true,
                step: slider.data("step"),
                min: slider.data("min"),
                max: slider.data("max"),
                values: [slider.data("min"), slider.data("max")],
                create: function () {
                    slider.parents(".uislider").find(".ui-slider-handle-min span").text(slider.slider("values", 0));
                    slider.parents(".uislider").find(".ui-slider-handle-max span").text(slider.slider("values", 1));
                },
                slide: function (event, ui) {
                    refreshSwatch(slider, ui);
                },
                change: function (event, ui) {
                    refreshSwatch(slider, ui)
                }
            });
        });

        $(".value.min input").change(function () {
            $(this).parents(".uislider").find(".uislider-container").slider("values", 0, $(this).val());
        });

        $(".value.max input").change(function () {
            $(this).parents(".uislider").find(".uislider-container").slider("values", 1, $(this).val());
        });
    }

    if ($("*").is(".catalog-filter .open")) {
        $(".catalog-filter .open .section-content").show(0);
    }

    $(".catalog-filter").on("click", ".section-name a", function (event) {
        event.preventDefault();
        $(this).parents(".section").toggleClass("open");
        $(this).parents(".section").find(".section-content").slideToggle(300);
    });

    $(".sidebar-buttons").on("click", ".btn-categories", function (event) {
        event.preventDefault();
        $(this).toggleClass("open");
        $(".sidebar-buttons .btn-filter").removeClass("open");
        $(".catalog-filter").slideUp(300);
        $(".catalog-categories").slideToggle(300);
    });

    $(".sidebar-buttons").on("click", ".btn-filter", function (event) {
        event.preventDefault();
        $(this).toggleClass("open");
        $(".sidebar-buttons .btn-categories").removeClass("open");
        $(".catalog-categories").slideUp(300);
        $(".catalog-filter").slideToggle(300);
    });

    $("body").on("click", ".selectlink", function (event) {
        $(this).parents("form").find("#file").click();
        return false;
    });

    $('.modal').on('show.bs.modal', function () {
        $(".cookie").css("padding-right", wScroll + "px");
        $(".header").css("right", wScroll + "px");
    });

    $('.modal').on('hidden.bs.modal', function () {
        $(".cookie").css("padding-right", 0);
        $(".header").css("right", 0);
    });

    $('a[data-target=".quick_buy"]').on('click', function () {
        let count = document.querySelector('.tovar-buy #product_price').value;
        let id = document.querySelector('.tovar-buy button.btn-red').getAttribute('data-id');
        let price = document.querySelector('.tovar-price span').textContent;
        price = parseInt(price.replace('От ', '').replace(' руб.', ""))
        if(!price) {
            price = 0
        }
        $('.modal.quick_buy .qb-input[name="product_id"]').val(id)
        $('.modal.quick_buy .qb-input[name="count"]').val(count)
        $('.modal.quick_buy .qb-input[name="price"]').val(price)
    })

    $(".out").on("click", ".catalog-products td:contains('Сделать заказ')", function (event) {
        event.preventDefault();
        var name = $("h1.title").text() + " - " + $(this).parents("tr").find("td:eq(0)").text() + ", " + $(this).parents("tr").find("td:eq(1)").text()
        $(".modal-order .product-name").text(name);
        $(".modal-order .product").val(name);
        $(".modal-order").modal('show');
    });

    if ($("*").is(".reviews")) {
        $(".reviews-carousel").slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            arrows: true,
            appendArrows: '.reviews .arrows',
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });
    }

    heights();
    itemHeightsAll();
});


$(window).on("load", function (e) {
    wscr();
    heights();
    itemHeightsAll();
});

$(window).resize(function () {
    setTimeout(function () {
        wscr();
        heights();
        itemHeightsAll();

        if ($("*").is(".parallax")) {
            $.stellar("destroy");
            $(".parallax").attr("style", "");
            $.stellar();
        }
    }, 600);

    // if ($("*").is("select")) {
    //     $("select").selectmenu("close");
    // }
});

$(window).scroll(function () {
    var scrolltop = $(this).scrollTop();
    if (scrolltop > 600) {
        $(".header").addClass("scrolled");
        $('.arrow-up').fadeIn();
    } else {
        $(".header").removeClass("scrolled");
        $('.arrow-up').fadeOut();
    }
});

let nav = document.querySelector(".mobile-catalog");
let header = document.querySelector('.mobmenu-toggle');
header.addEventListener('click', function () {
    let data = document.querySelector('div[dir="ltr"]');
    if (data.classList.contains('hide-header')) {
        data.classList.remove('hide-header');
    } else {
        data.classList.toggle('hide-header');
    }
})

let catalog = document.querySelector('div.catalog');
let mob = document.querySelector('.mobile-catalog');
let sub = document.querySelectorAll('.mobile-catalog__sub');
catalog.addEventListener('click', function () {
    let data = document.querySelector('div[dir="ltr"]');
    if (data.classList.contains('hide-subheader')) {
        data.classList.remove('hide-subheader');
    } else {
        data.classList.toggle('hide-subheader');
    }
    if (mob.classList.contains('show-mob')) {
        mob.classList.remove('show-mob');
        document.querySelector('body').style.overflow = 'auto'
    } else {
        mob.classList.toggle('show-mob');
        document.querySelector('body').style.overflow = 'hidden'
    }
    if (nav.classList.contains('show-nav')) {
        nav.classList.remove('show-nav');
        setTimeout(function () {
            nav.classList.remove('subs');
        }, 500)
    }
    for (let i = 0; i < sub.length; i++) {
        if (sub[i].classList.contains('show-mob')) {
            sub[i].classList.toggle('hide-mob');
            sub[i].classList.remove('show-mob');
            if (nav.classList.contains('show-nav')) {
                sub[i].classList.toggle('toRight');
            }
        } else {
            sub[i].classList.remove('hide-mob');
            sub[i].classList.toggle('show-mob');
        }
    }

})

let city = document.querySelector('a[data-target="#cfCity"]')
city.addEventListener('click', function () {
    let headerTop = document.querySelector('header')
    let dir = document.querySelector('div[dir="ltr"]')
    headerTop.classList.toggle('city')
    dir.classList.toggle('city')
    let dismiss = document.querySelector('button[data-dismiss="modal"]');
    dismiss.addEventListener('click', function () {
        headerTop.classList.remove('city')
        dir.classList.remove('city')
    })
    let cfCity = document.querySelector('#cfCity');
    cfCity.addEventListener('click', function () {
        headerTop.classList.remove('city')
        dir.classList.remove('city')
    })
})

let closeCatalog = document.querySelector('.mobile-catalog div.submenu1 svg');
closeCatalog.addEventListener('click', function () {
    if (mob.classList.contains('show-mob')) {
        mob.classList.remove('show-mob');
        document.querySelector('body').style.overflow = 'auto'
        for (let i = 0; i < sub.length; i++) {
            sub[i].classList.remove('show-mob');
            sub[i].classList.toggle('hide-mob');
        }
    }
})

// ++++++++++  ADD TO CART +++++++++++++++++
let toCartBtns = document.querySelectorAll('[data-add-to-cart]')
if (toCartBtns.length) {
    toCartBtns.forEach(btn => {
        btn.addEventListener('click', e => {
            let url = e.target.dataset.url;
            let id = e.target.dataset.id;
            let count = e.target.closest('.tovar-buy')?.querySelector(' [data-cart-count]')?.value || 1;
            url = `${url}?id=${id}&count=${count}`;
            fetch(url).then(resp => resp.json()).then(json => {
                updateCart(json)
            })
        })
    })
}

// ++++++++++  CHANGE CART COUNT IN CART +++++++++++++++++
let cartCountInputs = document.querySelectorAll('[data-cart-count]')
if (cartCountInputs.length) {
    cartCountInputs.forEach(input => {
        input.addEventListener('change', e => {
            let count = e.target.value
            let id = e.target.dataset.id
            let url = e.target.dataset.url
            url = `${url}?id=${id}&count=${count}`
            fetch(url).then(resp => resp.json()).then(json => {
                updateCartItem(json)
            })
        })
    })
}

let removeFromCartBtns = document.querySelectorAll('[data-cart-remove]')
if (removeFromCartBtns.length) {
    removeFromCartBtns.forEach(btn => {
        btn.addEventListener('click', e => {
            let url = e.target.dataset.url
            fetch(url).then(resp => resp.json()).then(json => {
                updateCart(json)
            })
            e.target.closest('tr').remove()
        })
    })
}

function updateCart(cart) {
    let cartEl = document.getElementById('msMiniCart')

    if (cart.count) {
        cartEl.classList.add('full')
        cartEl.querySelector('.ms2_total_count').innerText = cart.count
    } else {
        cartEl.classList.remove('full')
        cartEl.querySelector('.ms2_total_count').innerText = 0
        window.location.href = '/'
    }
}

function updateCartItem(item) {

    let cartEl = document.getElementById('msMiniCart')
    cartEl.querySelector('.ms2_total_count').innerText = item.count

    let row = document.getElementById(item.id)
    row.querySelector('.total .amount').innerText = item.total
}

function wscr() {
    if ($(document).height() > $(window).height()) {
        var block = $('<div>').css({'height': '50px', 'width': '50px'}),
            indicator = $('<div>').css({'height': '200px'});

        $('body').append(block.append(indicator));
        var w1 = $('div', block).innerWidth();
        block.css('overflow-y', 'scroll');
        var w2 = $('div', block).innerWidth();
        $(block).remove();
        wScroll = w1 - w2;
    } else {
        wScroll = 0;
    }
}

function mobmenu() {
    $(".out").append('<div class="mobmenu"><div class="container"></div></div>');
    $(".mobmenu > .container").append('<div class="mobmenu-search">' + $(".navigation .search-form").html() + '</div>');
    $(".mobmenu > .container").append('<div class="mobmenu-navigation">' + $(".navigation .menu").html() + '</div>');
    $(".mobmenu .mobmenu-navigation .active").removeClass("active");
    $(".mobmenu > .container").append('<div class="mobmenu-contacts"></div>');
    $(".mobmenu .mobmenu-contacts").append($(".header .header-contacts").html());

    $("body").append('<div class="lines"><span></span><span></span><span></span><span></span><span></span></div>');
}

function heights() {
    if (!$(".mobmenu-search .text").is(":focus")) {
        $(".mobmenu .mobmenu-navigation").css("min-height", $(".mobmenu .container").height() - $(".mobmenu .mobmenu-contacts").innerHeight() - $(".mobmenu .mobmenu-search").innerHeight() - 1);
    }

    if ($("*").is(".rotate")) {
        $('.rotate').each(function () {
            $(this).css("width", $(this).parent("div").height());
        });
    }

    if ($("*").is(".mainblock")) {
        if ($(".navigation").is(':visible')) {
            //$(".mainblock .banner").css("height", $(window).height() - $(".header").outerHeight() - $(".navigation").outerHeight());
        } else {
            $(".mainblock .banner").css("height", $(window).height() - $(".header").outerHeight());
        }

        $(".mainblock").css("padding-top", $(".header").outerHeight());
    } else {
        $(".out").css("padding-top", $(".header").outerHeight());
    }
};

function getName(control) {
    if (control.value != "")
        $(control).parents("form").find(".selectlink").addClass("selected");
    else
        $(control).parents("form").find(".selectlink").removeClass("selected");
}

function itemHeightsAll() {
    if ($("*").is(".pluses")) {
        itemHeights(".pluses .plus");
    }

    if ($("*").is(".articles")) {
        itemHeights(".articles .article");
    }
}

function itemHeights(item) {
    var maxHeight = 0;
    $(item).css("height", "auto");
    $(item).each(function () {
        if ($(this).height() > maxHeight) {
            maxHeight = $(this).height();
        }
    });
    $(item).height(maxHeight + 1);
}
