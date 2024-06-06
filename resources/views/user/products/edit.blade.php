@extends('layouts.app')

@section('content')
    <h1>Edit Product</h1>
    <form action="{{ route('user.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" required>{{ $product->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="image">Current Image</label><br>
            @if ($product->image)
                <img id="currentImage" src="{{ asset($product->image) }}" alt="Current Image" style="max-width: 300px;">
            @else
                <p>No image available</p>
            @endif
        </div>
        <div class="form-group">
            <label for="image">Select Image</label>
            <input type="file" name="image" id="image" class="form-control-file" onchange="previewImage()">
        </div>

        <!-- Category Selection -->
        <div class="form-group">
            <label for="main-category">Main Category:</label>
            <select id="main-category" name="main_category" class="form-control" required>
                <option value="">Select Main Category</option>
                @foreach ($mainCategories as $category)
                    <option value="{{ $category->id }}"
                        {{ $selectedMainCategory && $selectedMainCategory->id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group" id="sub-category-container"
            style="{{ $selectedSubCategory ? 'display: block;' : 'display: none;' }}">
            <label for="sub-category">Sub Category:</label>
            <select id="sub-category" name="sub_category" class="form-control">
                <option value="">Select Sub Category</option>
                @if ($selectedSubCategory)
                    @foreach ($selectedMainCategory->children ?? [] as $subCategory)
                        <option value="{{ $subCategory->id }}"
                            {{ $selectedSubCategory->id == $subCategory->id ? 'selected' : '' }}>
                            {{ $subCategory->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="form-group" id="sub-sub-category-container"
            style="{{ $selectedSubSubCategory ? 'display: block;' : 'display: none;' }}">
            <label for="sub-sub-category">Sub Sub Category:</label>
            <select id="sub-sub-category" name="sub_sub_category" class="form-control">
                <option value="">Select Sub Sub Category</option>
                @if ($selectedSubSubCategory)
                    @foreach ($selectedSubCategory->children ?? [] as $subSubCategory)
                        <option value="{{ $subSubCategory->id }}"
                            {{ $selectedSubSubCategory->id == $subSubCategory->id ? 'selected' : '' }}>
                            {{ $subSubCategory->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="form-group" id="gender-category-container"
            style="{{ $selectedSubCategory && $selectedSubCategory->id == 60 ? 'display: block;' : 'display: none;' }}">
            <label for="gender-category">Gender:</label>
            <select id="gender-category" name="gender_category" class="form-control">
                <option value="">Select Gender</option>
                @if ($selectedGenderCategory)
                    @foreach ($selectedGenderCategory->children ?? [] as $gender)
                        <option value="{{ $gender->id }}"
                            {{ in_array($gender->id, $productCategories) ? 'selected' : '' }}>
                            {{ $gender->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="form-group" id="size-category-container"
            style="{{ $selectedSubCategory && $selectedSubCategory->id == 60 ? 'display: block;' : 'display: none;' }}">
            <label for="size-category">Size:</label>
            <select id="size-category" name="size_category" class="form-control">
                <option value="">Select Size</option>
                @if ($selectedSizeCategory)
                    @foreach ($selectedSizeCategory->children ?? [] as $size)
                        <option value="{{ $size->id }}"
                            {{ in_array($size->id, $productCategories) ? 'selected' : '' }}>
                            {{ $size->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="form-group">
            <label for="category">Type of Product</label><br>
            <input type="radio" name="product_type" id="product_sale" value="1"
                {{ $product->product_type == 1 ? 'checked' : '' }} required> <label for="product_sale">To Sale</label>
            <input type="radio" name="product_type" id="product_rent" value="2"
                {{ $product->product_type == 2 ? 'checked' : '' }} required> <label for="product_rent">To Rent</label>
        </div>
        <div class="form-group" id="price_field"
            style="{{ $product->product_type == 1 ? 'display: block;' : 'display: none;' }}">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}">
        </div>
        <div class="form-group" id="price_per_day_field"
            style="{{ $product->product_type == 2 ? 'display: block;' : 'display: none;' }}">
            <label for="price_per_day">Price Per Day</label>
            <input type="number" name="price_per_day" id="price_per_day" class="form-control"
                value="{{ $product->price_per_day }}">
        </div>
        <div class="form-group" id="availability_fields"
            style="{{ $product->product_type == 2 ? 'display: block;' : 'display: none;' }}">
            <label for="availability_from">Availability From</label>
            <input type="date" name="availability_from" id="availability_from" class="form-control"
                value="{{ $product->available_from ? $product->available_from->format('Y-m-d') : '' }}">
            <label for="availability_to">Availability To</label>
            <input type="date" name="availability_to" id="availability_to" class="form-control"
                value="{{ $product->available_to ? $product->available_to->format('Y-m-d') : '' }}">
        </div>
        <div class="form-group" id="rental_availability"
            style="{{ $product->product_type == 2 ? 'display: block;' : 'display: none;' }}">
            <label for="rental_available">Rental Availability</label><br>
            <input type="checkbox" name="rental_available" id="rental_available" value="1"
                {{ $product->rental_available ? 'checked' : '' }}>
        </div>
        <div class="form-group">
            <label for="stock_quantity">Stock Quantity</label>
            <input type="number" name="stock_quantity" id="stock_quantity" class="form-control"
                value="{{ $product->stock_quantity }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="{{ route('user.products.manage') }}" class="btn btn-secondary">Cancel</a>
    </form>

    <!-- Ensure jQuery is included before your script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var mainCategorySelect = document.getElementById('main-category');
            var subCategorySelect = document.getElementById('sub-category');
            var subSubCategorySelect = document.getElementById('sub-sub-category');
            var genderCategorySelect = document.getElementById('gender-category');
            var sizeCategorySelect = document.getElementById('size-category');

            var subCategoryContainer = document.getElementById('sub-category-container');
            var subSubCategoryContainer = document.getElementById('sub-sub-category-container');
            var genderCategoryContainer = document.getElementById('gender-category-container');
            var sizeCategoryContainer = document.getElementById('size-category-container');

            function resetDropdowns(dropdown, container) {
                dropdown.innerHTML = '<option value="">Select</option>';
                container.style.display = 'none';
            }

            function loadSubcategories(parentId, targetId, containerId, selectedValue = null) {
                if (parentId) {
                    $.ajax({
                        url: '{{ route('subcategories') }}',
                        type: 'GET',
                        data: {
                            parent_id: parentId
                        },
                        success: function(data) {
                            const target = document.getElementById(targetId);
                            target.innerHTML = '<option value="">Select</option>';
                            data.forEach(function(subcategory) {
                                target.innerHTML += '<option value="' + subcategory.id + '"' +
                                    (selectedValue && selectedValue == subcategory.id ?
                                        ' selected' : '') + '>' +
                                    subcategory.name + '</option>';
                            });
                            document.getElementById(containerId).style.display = 'block';
                        }
                    });
                } else {
                    resetDropdowns(document.getElementById(targetId), document.getElementById(containerId));
                }
            }

            mainCategorySelect.addEventListener('change', function() {
                const mainCategoryId = this.value;
                loadSubcategories(mainCategoryId, 'sub-category', 'sub-category-container');

                // Reset sub-sub-category
                resetDropdowns(subSubCategorySelect, subSubCategoryContainer);

                // Reset gender and size categories
                resetDropdowns(genderCategorySelect, genderCategoryContainer);
                resetDropdowns(sizeCategorySelect, sizeCategoryContainer);
            });

            subCategorySelect.addEventListener('change', function() {
                const subCategoryId = this.value;
                if (subCategoryId == 60) { // Assuming 60 is the ID for Kledij under BABY
                    loadSubcategories(62, 'gender-category', 'gender-category-container');
                    loadSubcategories(66, 'size-category', 'size-category-container');
                    resetDropdowns(subSubCategorySelect, subSubCategoryContainer);
                } else {
                    loadSubcategories(subCategoryId, 'sub-sub-category', 'sub-sub-category-container');

                    // Hide gender and size categories
                    resetDropdowns(genderCategorySelect, genderCategoryContainer);
                    resetDropdowns(sizeCategorySelect, sizeCategoryContainer);
                }
            });

            // Load initial subcategories with preselected values
            @if ($selectedMainCategory)
                loadSubcategories('{{ $selectedMainCategory->id }}', 'sub-category', 'sub-category-container',
                    '{{ $selectedSubCategory ? $selectedSubCategory->id : '' }}');
            @endif
            @if ($selectedSubCategory && $selectedSubCategory->id != 60)
                loadSubcategories('{{ $selectedSubCategory->id }}', 'sub-sub-category',
                    'sub-sub-category-container',
                    '{{ $selectedSubSubCategory ? $selectedSubSubCategory->id : '' }}');
            @endif
            @if ($selectedSubCategory && $selectedSubCategory->id == 60)
                loadSubcategories(160, 'gender-category', 'gender-category-container',
                    '{{ $selectedGenderCategory ? $selectedGenderCategory->id : '' }}');
                loadSubcategories(164, 'size-category', 'size-category-container',
                    '{{ $selectedSizeCategory ? $selectedSizeCategory->id : '' }}');
            @endif
        });

        document.addEventListener('DOMContentLoaded', function() {
            var productSale = document.getElementById('product_sale');
            var productRent = document.getElementById('product_rent');
            var priceField = document.getElementById('price_field');
            var pricePerDayField = document.getElementById('price_per_day_field');
            var rentalFields = document.getElementById('availability_fields');
            var rentalAvailability = document.getElementById('rental_availability');

            var availabilityFromField = document.getElementById('availability_from');
            var availabilityToField = document.getElementById('availability_to');

            function toggleFields() {
                if (productSale.checked) {
                    priceField.style.display = 'block';
                    pricePerDayField.style.display = 'none';
                    rentalFields.style.display = 'none';
                    rentalAvailability.style.display = 'none';

                    document.getElementById('price').setAttribute('required', 'required');
                    document.getElementById('price_per_day').removeAttribute('required');
                    availabilityFromField.removeAttribute('required');
                    availabilityToField.removeAttribute('required');
                } else if (productRent.checked) {
                    priceField.style.display = 'none';
                    pricePerDayField.style.display = 'block';
                    rentalFields.style.display = 'block';
                    rentalAvailability.style.display = 'block';

                    document.getElementById('price').removeAttribute('required');
                    document.getElementById('price_per_day').setAttribute('required', 'required');
                    availabilityFromField.setAttribute('required', 'true');
                    availabilityToField.setAttribute('required', 'true');
                }
            }

            productSale.addEventListener('change', toggleFields);
            productRent.addEventListener('change', toggleFields);

            // Initialize on page load
            toggleFields();
        });

        function previewImage() {
            var fileInput = document.getElementById('image');
            var file = fileInput.files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                var preview = document.getElementById('currentImage');
                if (preview) {
                    preview.src = reader.result;
                }
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
    <style>
        /* General Styles */
        body {
            font-family: 'Helvetica Neue', sans-serif;
            background-color: #f4f6f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            font-size: 2.5em;
            color: #2c3e50;
            margin-bottom: 40px;
        }

        /* Button Styles */
        .btn {
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 25px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-secondary {
            background-color: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
        }

        /* Form Styles */
        form {
            max-width: 600px;
            margin: auto;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #34495e;
        }

        .form-control,
        .form-control-file {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus,
        .form-control-file:focus {
            border-color: #3498db;
            outline: 0;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }

        /* Image Styles */
        #currentImage {
            display: block;
            margin: 20px auto;
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Container Styles */
        .container {
            padding: 20px;
        }
    </style>
@endsection
