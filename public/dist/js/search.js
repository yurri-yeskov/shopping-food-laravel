$(document).ready(function () {
    // Live Search
    $.fn.liveSearch = function (option) {
        return this.each(function () {
            this.timer = null;
            this.items = new Array();

            $.extend(this, option);

            $(this).attr('autocomplete', 'off');

            // Blur
            $(this).on('blur', function () {
                setTimeout(function (object) {
                    object.hide();
                }, 200, this);
            });

            // Keydown
            $(this).on('input', function (event) {
                this.request();
            });

            // Show
            this.show = function () {
                var pos = $('#search').position();

                $(this).parent().parent().siblings('ul.dropdown-menu').css({
                    top : ('65px'),
                    width: $('#search').width(),
                    left: ('200px')
                });

                $(this).parent().parent().siblings('ul.dropdown-menu').show();
            };

            // Hide
            this.hide = function () {
                $(this).parent().parent().siblings('ul.dropdown-menu').hide();
            };

            // Request
            this.request = function () {
                clearTimeout(this.timer);

                this.timer = setTimeout(function (object) {
                    object.source($(object).val(), $.proxy(object.response, object));
                }, 200, this);
            };

            // Response
            this.response = function (json) {
                html = '';

                if (json.length) {
                    for (i = 0; i < json.length; i++) {
                        this.items[json[i]['id']] = json[i];
                    }

                    var count = json.length;

                    for (i = 0; i < count; i++) {
                        html += '<li class="dropdown-item" data-value="' + json[i]['type'] + '-' + json[i]['id'] + '">';
                        html += '   <a href="' + json[i]['href'] + '">';
                        html += '       <div class="ajax-search">';
                        html += '           <div class="row">';
                        html += '               <div class="name" style="color: ' + json[i]['color'] + ';"><i class="fa ' + json[i]['icon'] + ' fa-lg fa-fw"></i>  ' + json[i]['name'] + '</div>';
                        html += '               <span class="type">' + json[i]['type'] + '</span>';
                        html += '           </div>';
                        html += '       </div>';
                        html += '   </a>';
                        html += '</li>';
                    }
                }

                if (html) {
                    this.show();
                } else {
                    this.hide();
                }

                $(this).parent().parent().siblings('ul.dropdown-menu').html(html);
            };

            $(this).parent().parent().after('<ul class="dropdown-menu" id="result-search" style="padding:2px 2px 2px 2px;"></ul>');
            $(this).parent().parent().siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));
        });
    };

    $('input[name=\'search\']').liveSearch({
        'source': function (request, response) {
            if (request != '' && request.length > 2) {
                $.ajax({
                    url     : url_search,
                    type    : 'GET',
                    dataType: 'JSON',
                    data    : 'keyword=' + $(this).val(),
                    success : function (json) {
                        response($.map(json, function (item) {
                            return {
                                id   : item.id,
                                name : item.name,
                                type : item.type,
                                color: item.color,
                                icon : item.icon,
                                href : item.href
                            }
                        }));
                    }
                });
            } else {
                $('#search > .dropdown-menu').hide();
            }
        }
    });

  });