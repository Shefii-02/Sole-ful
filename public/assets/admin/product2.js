$(document).ready(function () {



    function scrollTop() {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    }

    $(".tabnav").click(function (e) {
        e.preventDefault();
        /*$("#tab-navigation ul li").removeClass("active");
        $(this).parent().addClass("active");
        var target = $(this).attr("href");
        $(".tab-panel").css("display","none");
        $(target).css("display","block");*/
    })

    $("body").delegate(".option-type", "change", function () {
        var selected = $(this).val();
        var elem = $(this).parent().parent().find('.add-option-value span');
        if (elem) { elem.html('Add ' + selected); }
    });

    $("body").delegate(".option-type", "change", function () {
        var type = $(this).val();
        var rand_name = $(this).data("random");
        var selector = $(`.option-value-${rand_name}`)

        // Predefined options for colors and sizes
        var colorOptions = `
            <option value="">Select Color</option>
            <option value="Red">Red</option>
            <option value="Green">Green</option>
            <option value="Blue">Blue</option>
            <option value="Yellow">Yellow</option>
            <option value="Black">Black</option>
            <option value="White">White</option>`;
        var sizeOptions = `
            <option value="">Select Size</option>
            <option value="S">Small (S)</option>
            <option value="M">Medium (M)</option>
            <option value="L">Large (L)</option>
            <option value="XL">Extra Large (XL)</option>
            <option value="XXL">Double Extra Large (XXL)</option>`;

        selector.each(function () {

            // Populate the dropdown based on the selected type
            if (type === "color") {
                $(this).html(colorOptions).show();
            } else if (type === "size") {
                $(this).html(sizeOptions).show();
            } else {
                $(this).hide();
            }

        });

    });

    let variants = [];
    let variant_options = [];
    let entered_variants = [];


    $(".option-type").each(function () {
        var curelem = $(this).val();

        var elems = $(this).parent().parent().find(".option-value");

        var elemarray = [];

        $(elems).each(function () {
            elemarray.push($(this).val());
        })

        variants.push({ 'option': curelem, 'values': elemarray });
    });

    //console.log(variants);

    getVariants(variants, 0, '');

    //getVariants(master, 0, '');

    function getVariants(opt, idx, prefix = null) {

        (opt[idx].values).forEach(function (item) {

            if (opt[idx + 1] != null) {
                getVariants(opt, idx + 1, prefix + (idx === 0 ? '' : ',') + opt[idx].option + ':' + item);
            }
            else {
                variant_options.push(prefix + (idx === 0 ? '' : ',') + opt[idx].option + ':' + item);
            }

        });

    }

    $("body").delegate(".show-options", "click", function () {
        $('#variation-options-modal').modal('show');
    })

    $("body").delegate(".option-select", "change", function () {

        if ($(this).val() == 'new-option') {
            $('#variation-options-modal').modal('show')
        }
        else {

            /*if($(this).val()!='') {
                $(".add-variant").css("display","inline-block");
            }*/

            $(this).parent().parent().find('.option-name').val($(this).find("option:selected").text()).trigger('change')
        }

    })

    $("#save-options").click(function (e) {
        var checker = {};
        var duplicated = false;

        $(".option-type").each(function () {
            var selection = $(this).val();
            if (checker[selection]) {
                //if the property is defined, then we've already encountered this value
                showError("Oops...", "<h4>Sorry, please fix...</h4>" + "<p style='color:red;'>Option type can't be used twice!</p>");
                duplicated = true;
                return false;
            } else {
                //first time we've seen this value, so let's define a property for it
                checker[selection] = true;
            }

            var xchecker = {};

            $(this).parent().parent().find(".option-value").each(function () {
                var xselection = $(this).val();
                if (xchecker[xselection]) {
                    //if the property is defined, then we've already encountered this value
                    showError("Oops...", "<h4>Sorry, please fix...</h4>" + "<p style='color:red;'>Duplicate values are not allowed!</p>");
                    duplicated = true;
                    return false;
                } else {
                    //first time we've seen this value, so let's define a property for it
                    xchecker[xselection] = true;
                }
            })



        });

        if (!duplicated) {

            variants = []
            variant_options = []

            $(".option-type").each(function () {
                var curelem = $(this).val();
                var elems = $(this).parent().parent().find(".option-value");
                var elemarray = [];

                $(elems).each(function () {
                    elemarray.push($(this).val());
                })

                variants.push({ 'option': curelem, 'values': elemarray });
            });

            //console.log(variants);

            getVariants(variants, 0, '');

            console.log(variant_options);

            $(".option-select").each(function () {
                var curval = $(this).val();
                $(this).html(getOptionSelection());
                $(this).prepend('<option value="">Select an Option</option>');
                $(this).val(curval);
            })

            //$(".option-select").html();

            $("#variation-options-modal").modal("hide");
            /*$(".option-select").html(getOptionSelection());
            $(".option-select").prepend('<option value="">Select an Option</option>');*/
            $(".option-select").trigger("change");
        }

        $('.option-select').each(function (index) {
            var selVal = $(this).data('selected');
            $(this).find(`option[value="` + selVal + `"]`).attr('selected', true);
        });
    });


    function variationListing() {
        var checker = {};
        var duplicated = false;

        $(".option-type").each(function () {
            var selection = $(this).val();

            if (checker[selection]) {
                //if the property is defined, then we've already encountered this value
                showError("Oops...", "<h4>Sorry, please fix...</h4>" + "<p style='color:red;'>Option type can't be used twice!</p>");
                duplicated = true;
                return false;
            } else {
                //first time we've seen this value, so let's define a property for it
                checker[selection] = true;
            }
        });

        if (!duplicated) {

            variants = []
            variant_options = []

            $(".option-type").each(function () {
                var curelem = $(this).val();

                var elems = $(this).parent().parent().find(".option-value");

                var elemarray = [];

                $(elems).each(function () {
                    elemarray.push($(this).val());
                })

                variants.push({ 'option': curelem, 'values': elemarray });
            });

            //console.log(variants);

            getVariants(variants, 0, '');

            console.log(variant_options);

            $(".option-select").each(function () {
                var curval = $(this).val();
                $(this).html(getOptionSelection());
                $(this).prepend('<option value="">Select an Option</option>');
                $(this).val(curval);
            })

            $("#variation-options-modal").modal("hide");
            //$(".option-select").html(getOptionSelection());
            //$(".option-select").prepend('<option value="">Select an Option</option>');
            //$(".option-select").trigger("change");
        }


        $('.option-select').each(function (index) {
            var selVal = $(this).data('selected');
            $(this).find(`option[value="` + selVal + `"]`).attr('selected', true);
        });
    }



    $("#has-variants").click(function () {
        var status = $(this).is(":checked");

        if (status) {
            $("#variation-options-modal").modal("show")
            $(".variants-no").css("display", "none");
            $(".variants-yes").css("display", "block");
        }
        else {
            $("#variation-options-modal").modal("hide")
            $(".variants-no").css("display", "block");
            $(".variants-yes").css("display", "none");
        }
    })




    $(".add-option").click(function (e) {
        e.preventDefault();
        var rand_name = Math.random().toString(36).substring(2, 9);
        var colorOptions = `
        <option value="">Select Color</option>
        <option value="Red">Red</option>
        <option value="Green">Green</option>
        <option value="Blue">Blue</option>
        <option value="Yellow">Yellow</option>
        <option value="Black">Black</option>
        <option value="White">White</option>`;
        var sizeOptions = `
            <option value="">Select Size</option>
            <option value="S">Small (S)</option>
            <option value="M">Medium (M)</option>
            <option value="L">Large (L)</option>
            <option value="XL">Extra Large (XL)</option>
            <option value="XXL">Double Extra Large (XXL)</option>`;

        $(`<div class="col-md-6 mb-3">
            <div class="box-div">
                <div class="row position-relative">
                    <a href="#" class="position-relative">
                        <span class="bi bi-x-circle-fill text-danger del-option fs-3"></span>
                    </a>
                    <div class="col-md-6">
                        <select class="form-control option-type option-type-`+ rand_name + `" data-random="` + rand_name + `" name="variant_options[` + rand_name + `]">
                            <option value="size">Size</option>
                            <option value="color">Color</option>
                        </select>
                    </div>
                    <div class="col-md-5 option-value-container" data-random="`+ rand_name + `">
                         <select data-random="`+ rand_name + `" name="variant_option_values[` + rand_name + `][]" class="form-control option-value option-value-` + rand_name + ` mb-2">
                           `+ sizeOptions + `
                        </select>
                        <a href="#" class="add-option-value mt-2" data-random="`+ rand_name + `">
                            <i class="bi bi-plus fs-3" style="font-size:20px;"></i> <span>Add Size</span>
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>`).insertBefore($(this).parent());
        //  <input type="text" class="form-control option-value" data-random="`+ rand_name + `" name="variant_option_values[` + rand_name + `][]"/>
        $(".option-select").trigger("change");
    })

    $("body").delegate(".add-option-value", "click", function (e) {
        var KeyVal = $(this).data('random');
        e.preventDefault();

        var colorOptions = `
        <option value="">Select Color</option>
        <option value="Red">Red</option>
        <option value="Green">Green</option>
        <option value="Blue">Blue</option>
        <option value="Yellow">Yellow</option>
        <option value="Black">Black</option>
        <option value="White">White</option>`;
        var sizeOptions = `
            <option value="">Select Size</option>
            <option value="S">Small (S)</option>
            <option value="M">Medium (M)</option>
            <option value="L">Large (L)</option>
            <option value="XL">Extra Large (XL)</option>
            <option value="XXL">Double Extra Large (XXL)</option>`;

        var optionType = $(`.option-type-` + KeyVal).val();

        if (optionType === "color") {
            var content = colorOptions;
        } else if (optionType === "size") {
            var content = sizeOptions;
        }

        if ($(this).prev().val() === '') {
            showError('Oops...', "<h4>Sorry, please fix...</h4>" + "<p style='color:red;'>Please enter value</p>");
        } else {
            $(`<a href="#" class="del-option-value"><span class="bi bi-x fs-3 text-danger"></span></a>
                <select data-random="`+ KeyVal + `" name="variant_option_values[` + KeyVal + `][]" class="form-control option-value  option-value-` + KeyVal + ` mb-2">
                `+ content + `
                </select>`).insertBefore($(this));
            // <input type="text" class="form-control option-value mt-2" name="variant_option_values[` + KeyVal + `][]" />
        }
    });

    $("body").delegate(".option-value", "change", function () {

        var checker = {};
        var duplicated = false;

        $(this).parent().find(".option-value").each(function () {
            var selection = $(this).val();
            if (checker[selection]) {
                //if the property is defined, then we've already encountered this value
                showError("Oops...", "<h4>Sorry, please fix...</h4>" + "<p style='color:red;'>Option value duplication not allowed!</p>");
                $(this).val('')
                duplicated = true;
                return false;
            } else {
                //first time we've seen this value, so let's define a property for it
                checker[selection] = true;
            }
        })

    })

    $("body").delegate(".del-option", "click", function (e) {
        e.preventDefault();
        $(this).parent().parent().parent().parent().remove()
    });

    $("body").delegate(".del-option-value", "click", function (e) {
        e.preventDefault();
        $(this).next().remove();
        $(this).remove();
    });

    $("body").delegate(".del-variant", "click", function (e) {
        e.preventDefault();
        let id = $(this).parent().find('.productVariant').attr('data-id');
        $('.id-' + id).remove();
        $(this).parent().parent().remove();
    });


    $(".add-variant").click(function (e) {
        e.preventDefault();

        var instore_checked = $("#platform-instore").is(":checked") ? 'checked' : '';
        var online_checked = $("#platform-online").is(":checked") ? 'checked' : '';
        var instore_show = $("#platform-instore").is(":checked") ? 'style="display:inline-block;"' : 'style="display:none;"';
        var online_show = $("#platform-online").is(":checked") ? 'style="display:inline-block;"' : 'style="display:none;"';
        var rand_name = Math.random().toString(36).substring(2, 9);

        var elem = $(`<div class="row mb-3">
            <a href="#" class="position-relative"><span class="bi bi-x-circle text-danger del-variant"></span></a>
            <div class="col-md-12">
                <div class="row productVariant" data-id="${rand_name}">
                    <div class="col-md-2">
                        <select class="form-control option-select" name="variants[`+ rand_name + `]" data-option="` + rand_name + `">
                            `+ getOptionSelection(rand_name) + `
                        </select>
                    </div>
                    <div class="col-md-2 form-group">
                        <input type="text" name="variants_sku[`+ rand_name + `]" value="" class="form-control option-sku pv-sku" placeholder="" />
                             <label class="form-group__label">SKU</label>
                    </div>
                    <div class="col-md-3 form-group">
                        <input type="text" name="variants_name[`+ rand_name + `]" value="" class="form-control option-name pv-name" placeholder="" />
                        <label class="form-group__label">Variant name</label>
                    </div>
                    
                    <div class="col-md-1 form-group">
                        <input type="text" name="variants_weight[`+ rand_name + `]" value="" class="form-control option-weight" placeholder="" />
                        <label class="form-group__label">Weight</label>
                    </div>
                    <div class="col-md-2 form-group">
                        <input type="text" name="variants_price[`+ rand_name + `]" value="1.00" class="form-control option-price pv-price" placeholder="" />
                         <label class="form-group__label">Price</label>
                    </div>
                    
                     <div class="col-md-2 form-group">
                        <input type="text"
                            name="variants_stock[`+ rand_name + `]"
                            value="0" class="form-control option-price"
                            placeholder="" />
                        <label class="form-group__label">Stock</label>
                    </div>
                </div>
            </div>
        </div>`);

        elem.insertBefore($(this));

    });

    function getOptionSelection() {

        let options_select = '';

        variant_options.forEach(function (item) {

            var parts = item.split(",");
            var line = '';

            parts.forEach(function (ln) {
                var lineparts = ln.split(":");
                line += lineparts[1] + " ";
            });

            options_select = options_select + '<option value="' + item + '">' + line.trim() + '</option>' + "\n";
        })

        return options_select + '<option value="new-option">Add/Edit Multiple Options</option>';
    }

    $("body").delegate("#select-all-cities", "click", function (e) {

        if ($(this).is(":checked")) {
            $(".city-select").attr("checked", "checked");
        }
        else {
            $(".city-select").removeAttr("checked");
        }

    });

    $(".add-image").click(function (e) {
        e.preventDefault();
        var rand_name = Math.random().toString(36).substring(2, 9);

        $(`<div class="col-md-6 mb-3">
                <div class="box-div">
                    <div class="row">
                        <div class="col-md-8">
                            <a href="#" class="del-image position-relative" data-id="`+ rand_name + `">
                                <span class="bi bi-x-circle text-danger fs-3"></span>
                            </a>
                            <input type="file"  class="product-image" data-img="img-`+ rand_name + `"  data-src="src-` + rand_name + `" />
                            <img src="/assets/img/noimage.png" style="width:200px;height:auto;" class="mt-3" id="img-`+ rand_name + `" />
                            <input type="hidden" name="product_images[`+ rand_name + `]"  id="src-` + rand_name + `" >
                        </div>
                        <div class="col-md-4">
                            <select class="form-control mb-2" name="product_images_type[`+ rand_name + `]">
                                <option value="Extra Image">Extra</option>
                                <option value="Main Image">Main</option>
                                <option value="Thumbnail">Thumbnail</option>
                            </select>
                            <div class="box-div overflow-auto" style="height:200px;">
                                <div class="product-images-variants" id="`+ rand_name + `">
                                    ` + getImageVariantsCheckboxes(rand_name) + `
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`).insertBefore($(this).parent());
    });


    $("body").delegate(".product-image", "change", function () {
        var img = $(this).data('img');
        var src = $(this).data('src');

        var preview = $(this).next();
        var file = $(this).get(0).files[0];
        if (file) {
            var reader = new FileReader();

            reader.onload = function (event) {
                console.log(event)
                // preview.attr("src", event.target.result);
                $('#' + img).attr("src", event.target.result);
                $('#' + src).val(event.target.result);

            }

            reader.readAsDataURL(file);
        }
    })



    $(".select-platform").click(function () {
        var platform = $(this).attr("data-platform");

        if ($(this).is(":checked")) {
            $("#nav-" + platform).css("display", "inline-block");
            $(".option-" + platform).attr("checked", "checked");
            $(".option-" + platform).parent().css("display", "inline-block");

        } else {
            $("#nav-" + platform).css("display", "none");
            $(".option-" + platform).removeAttr("checked");
            $(".option-" + platform).parent().css("display", "none");
        }

    })




    /********* IMAGES ***********/

    $("body").delegate(".del-image", "click", function (e) {
        e.preventDefault();
        $(this).parent().parent().parent().parent().remove();
        $("#product-images").append(`<input type="hidden" name="deleted_images[]" value="` + $(this).attr("data-id") + `" />`);
    })


    function getImageVariantsCheckboxes(rand_name = null) {

        var html = '';

        var selected = [];


        $("#" + rand_name).find("input[type=checkbox]").each(function () {
            if ($(this).is(":checked")) {
                selected.push($(this).val());
            }
        });


        entered_variants.forEach(function (item) {

            html = html +  `<div class="form-check form-switch">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    id="img-${rand_name}-${item.id}" 
                                    name="product_images_variant[${rand_name}][${item.id}]" 
                                    value="${item.sku}" 
                                    ${selected.includes(item.sku) ? 'checked' : ''}>
                                <label class="form-check-label" for="img-${rand_name}-${item.id}">
                                    ${item.name}
                                </label>
                            </div>`+ "\n";

            // html = html + `<div class="product-images-variant">
            //                     <div class="pretty p-switch p-fill">
            //                         <input type="checkbox"  />
            //                         <div class="state p-success">
            //                             <label class="control-label">`+ item.name + `</label>
            //                         </div>
            //                     </div>
            //                 </div>`+ "\n";


        })

        return html;
    }


    /***************** Show Error Alert ***************/

    function showError(title = 'Oops...', html = null) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: html,
        })
        return false;
    }


    /***************** TAB SWITCH ********************/

    $("#save-product-info, #save-product-info").click(function (e) {
        e.preventDefault();


        var validation_errors = false;


        if ($("#art_code").val() == '') {
            validation_errors = "A product ART code is required!<br/>" + "\n";
        }
        else {
            //check already existed
        }
        if ($("#product_no").val() == '') {
            validation_errors = "A product number  is required!<br/>" + "\n";
        }
        else {
            //check already existed
        }


        if ($("#product_name").val() == '') {
            validation_errors = "A product name is required!<br/>" + "\n";
        }





        if (validation_errors) {
            showError('Oops...', "<h4>Sorry, please fix...</h4>" + "<p style='color:red;'>" + validation_errors + '</p>');
            return false;
        }


        $("#tab-navigation li").removeClass("active");
        $("#product-info").css("display", "none");
        $("#nav-variants").addClass("active");
        $("#product-variants").css("display", "block");

        scrollTop();
    });

    $("#back-product-info, #back-product-info").click(function (e) {
        e.preventDefault();
        $("#tab-navigation li").removeClass("active");
        $("#product-variants").css("display", "none");
        $("#nav-info").addClass("active");
        $("#product-info").css("display", "block");

        scrollTop();
    });


    $("#save-product-variants, #save-product-variants").click(function (e) {
        e.preventDefault();



        entered_variants = [];
        var validation_errors = '';

        /**************** IF NO VARIANTS ****************/

        if (!$("#has-variants").is(":checked")) {

            if ($("input[name=product_sku_single]").val() == '') {
                validation_errors += 'A SKU (Stock Keeping Unit) is required' + "<br/>";
            }

            var pattern = /^[A-Z0-9]+$/i;

            if (!$("input[name=product_sku_single]").val().match(pattern)) {
                validation_errors += 'SKU must be Alphanumeric, no space or special characters allowed' + "<br/>";
            }
            else if ($("input[name=product_sku_single]").val() != '') {
                //check value already exist our db
            }


            if ($("input[name=product_price_single]").val() == '') {
                validation_errors += 'A price value is required' + "<br/>";
            }

            pattern = /[(0-9)+.?(0-9)]$/;

            if (!$("input[name=product_price_single]").val().match(pattern)) {
                validation_errors += 'Price must me numeric value (eg: 1.00)' + "<br/>";
            }

        } else {   /**************** IF MULTIPLE VARIANTS ****************/



            $(".option-sku").each(function (item) {
                var id = $(this).parent().parent().find('.option-sku').attr("name");

                if (id.includes("variants_sku[UID-")) {
                    id = id.replace("variants_sku[UID-", "").replace("]", "");
                }
                else {
                    id = id.replace("variants_sku[", "").replace("]", "");
                }

                var obj = { 'id': id, 'option': $(this).parent().parent().find('.option-select').val(), 'sku': $(this).parent().parent().find('.option-sku').val(), 'name': $(this).parent().parent().find('.option-name').val() }
                entered_variants.push(obj);
            })

            //console.log(entered_variants);

            var checker = {};

            $(".option-select").each(function () {


                var selection = $(this).val();

                if ($(this).val() == '' || $(this).val() == 'new-option') {
                    validation_errors += 'All variants must have an option selected' + "<br/>";
                    return false;
                }

                if (checker[selection]) {
                    //if the property is defined, then we've already encountered this value
                    validation_errors += $(this).find("option:selected").text() + " can't be used twice!" + "<br/>";
                    return false;
                } else {
                    //first time we've seen this value, so let's define a property for it
                    checker[selection] = true;
                }
            })

            checker = {}

            $(".option-sku").each(function () {

                var selection = $(this).val();


                var pattern = /^[A-Z0-9]+$/i;

                if (!$(this).val().match(pattern)) {
                    validation_errors += 'SKU must be Alphanumeric, no space or special characters allowed' + "<br/>";
                    return false;
                }
                else {
                    //check already used or not in our db
                }

                if (checker[selection]) {
                    //if the property is defined, then we've already encountered this value
                    validation_errors += 'SKU ' + $(this).val() + " can't be used twice!" + "<br/>";
                    return false;
                } else {
                    //first time we've seen this value, so let's define a property for it
                    checker[selection] = true;
                }
            })


            checker = {}

            $(".option-name").each(function () {

                if ($(this).val() == '') {
                    validation_errors += 'All variants must have a name' + "<br/>";
                    return false;
                }

                var selection = $(this).val();

                if (checker[selection]) {
                    //if the property is defined, then we've already encountered this value
                    validation_errors += 'Variant name ' + $(this).val() + " can't be used twice!" + "<br/>";
                    return false;
                } else {
                    //first time we've seen this value, so let's define a property for it
                    checker[selection] = true;
                }
            })

            $(".option-price").each(function () {
                if ($(this).val() == '') {
                    validation_errors += 'All variants must have a price' + "<br/>";
                    return false;
                }

                pattern = /[(0-9)+.?(0-9)]$/;

                if (!$(this).val().match(pattern)) {
                    validation_errors += 'All variants price must be numeric' + "<br/>";
                    return false;
                }
            })



        }

        if (validation_errors != '') {
            showError("Oops...", "<h4>Sorry, please fix...</h4>" + "<p style='color:red;'>" + validation_errors + '</p>');
            return false;
        }

        $(".product-images-variants").each(function () {
            var id = $(this).attr("id");
            $(this).html(getImageVariantsCheckboxes(id));
        });


        $("#tab-navigation li").removeClass("active");
        $("#product-variants").css("display", "none");

        $("#nav-images").addClass("active");
        $("#product-images").css("display", "block");

        scrollTop();

    });





    $("#back-product-variants, #back-product-variants").click(function (e) {
        e.preventDefault();
        $("#tab-navigation li").removeClass("active");
        $("#product-instore").css("display", "none");
        $("#nav-variants").addClass("active");
        $("#product-variants").css("display", "block");

        scrollTop();
    });


    $("#save-product-images, #save-product-images").click(function (e) {
        e.preventDefault();
        $("#tab-navigation li").removeClass("active");
        $("#product-images").css("display", "none");

        scrollTop();
    });

    $("#back-product-images, #back-product-images").click(function (e) {
        e.preventDefault();
        $("#tab-navigation li").removeClass("active");
        $("#product-images").css("display", "none");

        $("#nav-variants").addClass("active");
        $("#product-variants").css("display", "block");

        scrollTop();
    });

    $("#save-product-nutrition, #save-product-nutrition").click(function (e) {
        e.preventDefault();
        $("#product_form").submit();
        document.body.style.filter = 'grayscale(100%)';
    })


})