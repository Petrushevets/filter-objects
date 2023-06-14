(function ($) {
    'use strict';

    class Filter {
        constructor() {
            this.categories = [];
            this.status = '';
            this.filter = $('.filter');
            this.categoryElement = $('.category-item');
            this.statusElement = $('.status');
            this.clearElement = $('.filter-clear');
            this.objectsContainer = $('#objects');
            this.action = 'filter';
            this.filterObject = {
                url: filter_object.ajaxurl
            };

            this.bindEvents();
        }

        bindEvents() {
            this.categoryElement.on('click', () => this.handlerCategory());
            this.statusElement.on('click', () => this.handlerStatus());
            this.clearElement.on('click', () => this.clearFilter());
        }

        handlerCategory() {
            $(event.currentTarget).toggleClass('active');

            this.setCategories();
            this.setStatus();
            this.fetchData();

        }

        handlerStatus() {
            this.statusElement.removeClass('active');
            $(event.currentTarget).addClass('active');

            this.setCategories();
            this.setStatus();
            this.fetchData();
        }

        setCategories() {
            this.categories = this.categoryElement
                .filter('.active')
                .map((index, element) => $(element).data('term-slug'))
                .get();
        }

        setStatus() {
            this.status = this.filter.find('.status.active').data('status');
        }

        fetchData() {
            const data = {
                terms: this.categories,
                status: this.status,
                action: this.action
            };

            console.log(data)

            this.addParametersToUrl(data);

            $.ajax({
                url: this.filterObject.url,
                type: 'POST',
                dataType: 'json',
                data: data,
                success: (response) => this.renderData(response.data)
            });
        }

        addParametersToUrl(data) {
            const url = new URL(window.location);
            url.searchParams.set('status', data.status);

            if (data.terms.length > 0) {
                url.searchParams.set('categories', data.terms.join(','));
            } else {
                url.searchParams.delete('categories');
            }

            history.pushState(null, null, url);
        }

        renderData(data) {
            let html = '';

            if (typeof data === 'string') {
                html += data;
            } else {
                $.each(data, (key, value) => {
                    html += `<div class="object-item"><a href="${value.link}">${value.title}</a></div>`;
                });
            }

            this.objectsContainer.html(html);
        }

        clearFilter() {
            this.categories = [];
            this.status = 'all';
            this.filter.find('.active').removeClass('active');
            this.filter.find('li[data-status=all]').addClass('active');

            this.fetchData();
        }
    }

    new Filter();
})(jQuery);