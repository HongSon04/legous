const app = {
    eventsHandler() {
        /** back button */
        const backBtns = document.querySelectorAll('.back-btn');
        backBtns.forEach(btn => {
            btn.onclick = () => {
                window.history.back();
            }
        });
        /* header onscroll */
        // const heroBanner = document.querySelector('.hero-banner__wrapper')
        const headers = document.querySelectorAll('.header')
        headers.forEach(header => {
            if (header) {
                header.classList.add('home-page');
                // const offsetHeight = heroBanner.offsetHeight;
                document.addEventListener('scroll', () => {
                    const scrollY = document.scrollY || document.documentElement.scrollTop
                    if (scrollY !== 0) {
                        header.style.transform = 'translateY(-100%)';
                    } else {
                        header.style.transform = 'translateY(0)';
                    }
                    if (scrollY > header.offsetHeight) {
                        header.classList.add('scrolled');
                        header.style.transform = 'translateY(0)';
                    } else {
                        header.classList.remove('scrolled');
                    }
                })
            }
        });

        /* header respon */
        const openBtns = document.querySelectorAll('.open-respon-btn');
        const closeBtns = document.querySelectorAll('.close-respon-btn');
        const responNav = document.querySelector('.header__nav-respon-full');
        // console.log(openBtn, closeBtn, responNav)
        // openBtn.onclick = () => {
        //     console.log('this button is clicked', openBtn)
        // }
        if (responNav && openBtns) {
            openBtns.forEach(openBtn => {
                openBtn.addEventListener('click', () => {
                    responNav.classList.toggle('open');
                })
            });
            closeBtns.forEach(closeBtn => {
                closeBtn.addEventListener('click', () => {
                    responNav.classList.toggle('open');
                })
            })
        }

        /* search box */
        const openSearchBoxBtns = document.querySelectorAll('.open-search-box__btn');
        const closeSearchBoxBtns = document.querySelectorAll('.close-search-box__btn');
        const searchBox = document.querySelector('.header__search-box');

        if (openSearchBoxBtns && closeSearchBoxBtns && searchBox) {
            openSearchBoxBtns.forEach(openSearchBox => {
                openSearchBox.addEventListener('click', () => {
                    searchBox.classList.toggle('open');
                })
            });
            closeSearchBoxBtns.forEach(closeSearchBox => {
                closeSearchBox.addEventListener('click', () => {
                    searchBox.classList.toggle('open');
                })
            })
        }


        /** product tabs */
        const tabs = document.querySelectorAll('.tab__item');
        const panels = document.querySelectorAll('.panel__item');
        if (tabs) {
            tabs.forEach((tab, i) => {
                if (tab.dataset.defaultactive == '1') {
                    tab.classList.add('active');
                    panels[i].classList.add('active');
                }
                tab.addEventListener('click', () => {
                    if (document.querySelector('.tab__item.active'))
                        document.querySelector('.tab__item.active').classList.remove('active');
                    if (document.querySelector('.panel__item.active'))
                        document.querySelector('.panel__item.active').classList.remove('active');

                    tab.classList.add('active');
                    panels[i].classList.add('active');
                })
            })
        }


        // hidden - show password
        const hiddenShowPasswordButtons = document.querySelectorAll(".hidden-show__password");
        if (hiddenShowPasswordButtons) {
            hiddenShowPasswordButtons.forEach((button) => {
                button.addEventListener("click", () => {
                    const input_password = button.closest(".form__group").querySelector(".form__input");
                    input_password.type = input_password.type === "password" ? "text" : "password";
                    button.querySelectorAll('.eye-icon').forEach((item) => {
                        item.classList.toggle("eye-active");
                    });
                    event.preventDefault();
                });
            });
        }
        /** shop filter */

        const optionLists = document.querySelectorAll('.filter-option__list');
        const filterBtns = document.querySelectorAll('.filter__list__btn');

        if (filterBtns) {
            filterBtns.forEach((btn) => {
                btn.onclick = () => {
                    const optionList = btn.parentElement.querySelector('.filter-option__list');
                    closeOtherOptionLists(optionList);
                    optionList.classList.toggle('active');
                };
            });
        }

        document.body.addEventListener('click', (event) => {
            const isDescendantOfOptionList = Array.from(optionLists).some((optionList) =>
                optionList.contains(event.target)
            );
            const isDescendantOfFilterBtn = Array.from(filterBtns).some((btn) =>
                btn.contains(event.target)
            );

            if (!isDescendantOfOptionList && !isDescendantOfFilterBtn) {
                optionLists.forEach((optionList) => {
                    optionList.classList.remove('active');
                });
            }
        });

        function closeOtherOptionLists(activeOptionList) {
            optionLists.forEach((optionList) => {
                if (optionList !== activeOptionList) {
                    optionList.classList.remove('active');
                }
            });
        }

        // close / open filter 
        const toggleFilterBtn = document.querySelector('.toggle-filter-btn');
        const filterList = document.querySelector('.filter__list');
        // console.log(toggleFilterBtn, filterList)

        if (filterList && toggleFilterBtn) {
            toggleFilterBtn.onclick = () => {
                filterList.classList.toggle('open');

                if (filterList.classList.contains('open')) {
                    toggleFilterBtn.querySelector('.btn__text').textContent = 'Ẩn filter';
                } else {
                    toggleFilterBtn.querySelector('.btn__text').textContent = 'Hiện filter';
                }

            }
        }

        /** mobile filter system  */
        const mobileFilterCloseBtn = document.querySelector('.mobile__filter__btn--close')
        const mobileFilterOpenBtn = document.querySelector('.mobile__filter__btn--open')

        const mobileFilter = document.querySelector('.mobile__filter');

        if (mobileFilter) {
            mobileFilterOpenBtn.onclick = () => {
                mobileFilter.classList.add('open');
            }
            mobileFilterCloseBtn.onclick = () => {
                mobileFilter.classList.remove('open');
            }
        }

        /** mobile top nav bar - member widget */
        const moreBtn = document.querySelector('.member-widget .more-btn');
        const optionList = document.querySelector('.member-widget .option__list');
        if (optionList) {
            moreBtn.onclick = () => {
                optionList.classList.toggle('open');
            }
        }

        /** toggle button handler */
        const toggleBtns = document.querySelectorAll('.toggle-btn');
        if (toggleBtns) {
            toggleBtns.forEach(btn => {
                btn.onclick = e => {
                    e.preventDefault();
                    btn.classList.toggle('active');
                    if (btn.classList.contains('active')) {
                        if (btn.classList.contains('love-btn')) {
                            if (btn.querySelector('.fal')) {
                                btn.querySelector('.fal').classList.remove('fal');
                            }
                            if (btn.querySelector('.fa-heart')) {
                                btn.querySelector('.fa-heart').classList.add('fa');
                            }
                        }
                    } else {
                        if (btn.querySelector('i').classList.contains('fa')) {
                            btn.querySelector('i').classList.remove('fa');
                            btn.querySelector('i').classList.add('fal');
                        }
                    }
                }
            });
        }

        /** product gallery handler  */
        const galleries = document.querySelectorAll('.product__gallery');

        if (galleries) {
            galleries.forEach(gallery => {
                const spotlight = gallery.querySelector('.gallery__spotlight > img');
                const thumbnails = gallery.querySelectorAll('.gallery__thumbnails__item > img');
                thumbnails.forEach(item => {
                    item.onclick = () => {
                        spotlight.src = item.src;
                    }
                });
            });
        }

        /** add coupon handler */
        const addCouponeBtn = document.querySelector('add-coupon-btn');

        /** mobile indicator */
        // const list = document.querySelectorAll(".list");

        // function activeLink() {
        //     list.forEach((item) => item.classList.remove("active"));
        //     this.classList.add("active");
        // }
        // list.forEach((item) => item.addEventListener("click", activeLink));


        // || quantity input start
        const [...qtyInput] = document.querySelectorAll('.qty__input')
        if (qtyInput) {
            const dataQty = document.querySelectorAll(".data-qty");
            qtyInput.forEach((input, index) => {
                const minusBtn = input.parentElement.querySelector('.minus-btn')
                const plusBtn = input.parentElement.querySelector('.plus-btn')
                const subTotal = minusBtn.parentElement.parentElement.querySelector('.cart__product__subtotal')
                const [...cartProduct] = document.querySelectorAll('.cart__product')
                minusBtn.onclick = e => {
                    e.preventDefault()
                    input.value <= 1 ? input.value = 1 : input.value--
                    if (subTotal) {
                        subTotal.innerText = `document.querySelectorAll{input.value * Number(subTotal.parentElement.parentElement.querySelector('.cart__product__price').innerText.split('').slice(1).join(''))}`
                    }
                    // this.calculatorCheck(cartProduct, input, index)
                    if (dataQty) {
                        dataQty.forEach(item => {
                            item.value = input.value;
                        });
                    }
                }
                plusBtn.onclick = e => {
                    e.preventDefault()
                    input.value++
                    if (subTotal) {
                        subTotal.innerText = `document.querySelectorAll{input.value * Number(subTotal.parentElement.parentElement.querySelector('.cart__product__price').innerText.split('').slice(1).join(''))}`
                    }
                    // this.calculatorCheck(cartProduct, input, index)
                    // || product quatity handler
                    if (dataQty) {
                        dataQty.forEach(item => {
                            item.value = input.value;
                        });
                    }
                }
                input.oninput = () => {
                    // this.calculatorCheck(cartProduct, input, index)
                }
            });
        }
        // || quantity input end

        
        // || coupon form show / hide hanlder start
        const couponBtn = document.querySelector('.coupon__open--toggle-btn')
        const couponForm = document.querySelector('.coupon__form')
        if (couponBtn && couponForm) {
            couponBtn.onclick = (e) => {
                e.preventDefault();
                couponForm.classList.toggle('active');
            }
        }
        // || coupon form show / hide hanlder end
        if (document.getElementById("checkAll")) {
            document.getElementById("checkAll").addEventListener("change", function () {
                var checkboxes = document.querySelectorAll('input[name^="product"]');
                for (var i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].checked = this.checked;
                }
            });
        }


        var productCheckboxes = document.querySelectorAll('input[name^="product"]');
        for (var i = 0; i < productCheckboxes.length; i++) {
            productCheckboxes[i].addEventListener("change", function () {
                var checkAllCheckbox = document.getElementById("checkAll");
                var allChecked = true;

                for (var j = 0; j < productCheckboxes.length; j++) {
                    if (productCheckboxes[j] !== checkAllCheckbox && !productCheckboxes[j].checked) {
                        allChecked = false;
                        break;
                    }
                }
                checkAllCheckbox.checked = allChecked;
            });
        }

        // || show / hide recipient form start
        // const recipientCheckbox = document.getElementById('openRecipientForm')
        // const recipientForm = document.getElementById('recipient__form');
        // recipientForm.style.display = 'none';

        // if (recipientCheckbox && recipientForm) {
        //     recipientCheckbox.onchange = () => {
        //         recipientCheckbox.checked ?
        //             recipientForm.style.display = 'block' :
        //             recipientForm.style.display = 'none';
        //     }
        // }
        // || show / hide recipient form end

    },
    functionalHandler() {

        let filterInputs = document.querySelectorAll('.filter__input');

        filterInputs.forEach(function (input) {
            let id = input.getAttribute('data-id-category');
            let urlParams = new URLSearchParams(window.location.search);
            let existingParams = Array.from(urlParams.entries());

            let filterCategory = urlParams.get('filterCategory');
            if (filterCategory) {
                filterCategory = filterCategory.split(',');
                if (filterCategory.includes(id)) {
                    input.checked = true;
                }
            } else {
                filterCategory = [];
            }

            input.addEventListener('click', function () {
                if (input.checked) {
                    if (!filterCategory.includes(id)) {
                        filterCategory.push(id);
                    }
                } else {
                    filterCategory = filterCategory.filter(item => item !== id);
                }

                // Remove existing filterCategory parameter
                existingParams = existingParams.filter(([param, value]) => param !== 'filterCategory');

                // Append updated filterCategory parameter
                if (filterCategory.length > 0) {
                    existingParams.push(['filterCategory', filterCategory.join(',')]);
                }

                // Construct the new URL
                let newUrl = window.location.pathname;

                if (existingParams.length > 0) {
                    let queryString = existingParams.map(([param, value]) => `${param}=${value}`).join('&');
                    newUrl += '?' + queryString;
                }

                newUrl += window.location.hash;

                // Redirect to the new URL
                window.location.href = newUrl;
            });
        });

        // filter by name
        let filterNameInputs = document.querySelectorAll('.filter__input--name');

        if (filterNameInputs) {
            filterNameInputs.forEach(function (input) {
                input.addEventListener('click', function () {
                    let urlParams = new URLSearchParams(window.location.search);
                    let filterName = urlParams.get('filterName') || '';

                    if (filterName === '1') {
                        filterName = '0';
                    } else {
                        filterName = '1';
                    }

                    urlParams.set('filterName', filterName);

                    let newUrl = window.location.origin + window.location.pathname + '?' + urlParams.toString() + window.location.hash;
                    window.location.href = newUrl;
                });

                // Check the input if filterName matches
                let urlParams = new URLSearchParams(window.location.search);
                let filterName = urlParams.get('filterName') || '';

                if (filterName === '0' && input.value === '0') {
                    input.checked = true;
                } else if (filterName === '1' && input.value === '1') {
                    input.checked = true;
                }

                // create filter toggle button for each filter
                function createFilterLabels(filterParams, toggleFilterListClass, labelCustomization) {
                    // Parse URL parameters
                    const urlParams = new URLSearchParams(window.location.search);

                    // Get the filter toggle list element
                    const toggleFilterList = document.querySelector(`.${toggleFilterListClass}`);

                    // Remove existing filter labels for the specified filter parameters
                    filterParams.forEach(filterParam => {
                        const existingFilterLabels = toggleFilterList.querySelectorAll(`.filter-${filterParam}-label`);
                        existingFilterLabels.forEach(label => {
                            toggleFilterList.removeChild(label);
                        });
                    });

                    // Iterate through the filter parameters
                    filterParams.forEach(filterParam => {
                        // Check if the filter parameter exists in the URL
                        const filterValue = urlParams.get(filterParam);
                        if (filterValue) {
                            // Create the filter label element
                            const filterLabel = document.createElement('li');
                            filterLabel.classList.add('filter-toggle__list-item', `filter-${filterParam}-label`);

                            const filterLink = document.createElement('a');
                            filterLink.href = '#';
                            filterLink.classList.add('filter-toggle__list-item', 'outline-btn', 'btn', 'rounded-100', 'v-center', 'ttc');

                            // Customize the filter label content based on the labelCustomization function
                            const filterText = document.createTextNode(labelCustomization(filterParam, filterValue));
                            filterLink.appendChild(filterText);

                            const filterIcon = document.createElement('i');
                            filterIcon.classList.add('fal', 'fa-times');
                            filterLink.appendChild(filterIcon);

                            filterLabel.appendChild(filterLink);

                            // Add event listener to remove the filter label when clicked
                            filterLink.addEventListener('click', function (event) {
                                event.preventDefault();

                                // Remove the filter label from the DOM
                                toggleFilterList.removeChild(filterLabel);

                                // Remove the filter parameter from the URL
                                urlParams.delete(filterParam);

                                // Generate the new URL without the filter parameter
                                const newUrl = `${window.location.origin}${window.location.pathname}?${urlParams.toString()}${window.location.hash}`;

                                // Redirect to the new URL
                                window.location.href = newUrl;
                            });

                            // Append the filter label to the filter toggle list
                            toggleFilterList.appendChild(filterLabel);
                        }
                    });
                }

                // Example usage with multiple filters, custom toggleFilterList class name, and label customization
                const filters = ['filterName', 'minPrice', 'maxPrice', 'filterCategory'];
                const toggleFilterListClass = 'filter-toggle__list';
                const labelCustomization = (filterParam, filterValue) => {
                    if (filterParam === 'minPrice') {
                        return `Giá thấp nhất: ${formatCurrencyVND(filterValue)}`;
                    } else if (filterParam === 'maxPrice') {
                        return `Giá cao nhất: ${formatCurrencyVND(filterValue)}`;
                    } else if (filterParam === 'filterName') {
                        if (filterValue == 0) {
                            return `Tên: A - Z`;
                        } else {
                            return `Tên: Z - A`;
                        }
                    } else if (filterParam === 'filterCategory') {
                        const cateIds = filterValue.split(',');
                        const categories = [
                            'Naruto',
                        	'Dragon Ball',
                        	'Jujustsu Kaisen',
                        	'Kimetsu no Yaiba',
                        	'Gundam',
                        	'Genshin Impact',
                        	'One Piece',
                        	'Thẻ bài',
                        	'Lego Xe',
                        	'Lego',
                        ];
                        const categoryNames = cateIds.map((id) => categories[id - 1]);
                        return `Danh mục: ${categoryNames.join(', ')}`;
                    } else {
                        return `Danh mục: `;
                    }
                };

                createFilterLabels(filters, toggleFilterListClass, labelCustomization);

                const listClass = 'filter-toggle__list--mobile';
                createFilterLabels(filters, listClass, labelCustomization);
            });

        }

        function formatCurrencyVND(value) {
            const formatter = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            });

            return formatter.format(value);
        }

        // filter by date 
        // Get the filter input elements
        const filterDateInputs = document.querySelectorAll('.filter__input--date');

        // Add event listeners to the filter inputs
        if (filterDateInputs) {
            filterDateInputs.forEach(input => {
                input.addEventListener('change', handleFilterChange);
            });
        }

        // Function to handle filter change
        function handleFilterChange(event) {
            const selectedFilters = Array.from(filterDateInputs)
                .filter(input => input.checked)
                .map(input => input.value);

            // Update the URL based on selected filters
            updateURL(selectedFilters);
        }

        // Function to update the URL based on selected filters
        function updateURL(selectedFilters) {
            // Get the base URL
            const baseURL = window.location.origin + window.location.pathname;

            // Create a URLSearchParams object to construct the query parameters
            const urlParams = new URLSearchParams();

            // Add existing query parameters to the URLSearchParams object
            const existingParams = new URLSearchParams(window.location.search);
            existingParams.forEach((value, key) => {
                urlParams.append(key, value);
            });

            // Add the selected filters to the URLSearchParams object
            selectedFilters.forEach(filter => {
                urlParams.set('dateFilter', filter);
            });

            // Get the final URL with updated query parameters
            const newURL = baseURL + '?' + urlParams.toString();

            // Redirect to the new URL
            window.location.href = newURL;

        }
        let urlParams = new URLSearchParams(window.location.search);
        const dateFilter = urlParams.get('dateFilter');

        if (dateFilter) {
            filterInputs.forEach(input => {
                if (input.value === dateFilter) {
                    input.checked = true;
                }
            });
        }
    },
    start() {
        this.eventsHandler();
        this.functionalHandler();
    }
}
app.start();
