@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add New Product</h1>
        <form id="productForm" action="{{ route('user.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Product fields -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="image">Select Image</label>
                <input type="file" name="image" id="image" class="form-control-file" onchange="previewImage()">
            </div>

            <!-- Category Selection -->
            <div class="form-group">
                <label for="main-category">Main Category:</label>
                <select id="main-category" name="main_category" class="form-control">
                    <option value="">Select Main Category</option>
                    @foreach ($mainCategories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" id="sub-category-container" style="display: none;">
                <label for="sub-category">Sub Category:</label>
                <select id="sub-category" name="sub_category" class="form-control">
                    <option value="">Select Sub Category</option>
                </select>
            </div>

            <div class="form-group" id="sub-sub-category-container" style="display: none;">
                <label for="sub-sub-category">Sub Sub Category:</label>
                <select id="sub-sub-category" name="sub_sub_category" class="form-control">
                    <option value="">Select Sub Sub Category</option>
                </select>
            </div>

            <div class="form-group" id="gender-category-container" style="display: none;">
                <label for="gender-category">Gender:</label>
                <select id="gender-category" name="gender_category" class="form-control">
                    <option value="">Select Gender</option>
                </select>
            </div>

            <div class="form-group" id="size-category-container" style="display: none;">
                <label for="size-category">Size:</label>
                <select id="size-category" name="size_category" class="form-control">
                    <option value="">Select Size</option>
                </select>
            </div>

            <!-- Product type selection -->
            <div class="form-group">
                <label for="product_type">Product Type</label><br>
                <input type="radio" name="product_type" id="product_type_sale" value="1" checked required>
                <label for="product_type_sale">For Sale</label>
                <input type="radio" name="product_type" id="product_type_rent" value="2" required>
                <label for="product_type_rent">For Rent</label>
            </div>
            <div class="form-group" id="price_field" style="display: block;">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" class="form-control" min="0">
            </div>
            <div class="form-group" id="rental_fields" style="display: none;">
                <label for="price_per_day">Price Per Day</label>
                <input type="number" name="price_per_day" id="price_per_day" class="form-control" min="0">
            </div>
            <div class="form-group" id="availability_fields" style="display: none;">
                <label for="availability_from">Availability From</label>
                <input type="date" name="availability_from" id="availability_from" class="form-control"
                    min="{{ date('Y-m-d') }}">
                <label for="availability_to">Availability To</label>
                <input type="date" name="availability_to" id="availability_to" class="form-control"
                    min="{{ date('Y-m-d') }}">
            </div>
            <div class="form-group" id="rental_availability" style="display: none;">
                <label for="rental_available">Rental Availability</label><br>
                <input type="checkbox" name="rental_available" id="rental_available" value="1">
            </div>
            <div class="form-group">
                <label for="stock_quantity">Stock Quantity</label>
                <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" required
                    min="0">
            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>

    <!-- Ensure jQuery is included before your script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function toggleFields() {
                const productSale = document.getElementById('product_type_sale');
                const productRent = document.getElementById('product_type_rent');
                const priceField = document.getElementById('price_field');
                const rentalFields = document.getElementById('rental_fields');
                const availabilityFields = document.getElementById('availability_fields');
                const rentalAvailability = document.getElementById('rental_availability');

                if (productSale.checked) {
                    priceField.style.display = 'block';
                    rentalFields.style.display = 'none';
                    availabilityFields.style.display = 'none';
                    rentalAvailability.style.display = 'none';

                    document.getElementById('price').setAttribute('required', 'required');
                    document.getElementById('price_per_day').removeAttribute('required');
                } else if (productRent.checked) {
                    priceField.style.display = 'none';
                    rentalFields.style.display = 'block';
                    availabilityFields.style.display = 'block';
                    rentalAvailability.style.display = 'block';

                    document.getElementById('price').removeAttribute('required');
                    document.getElementById('price_per_day').setAttribute('required', 'required');
                }
            }

            document.getElementById('product_type_sale').addEventListener('change', toggleFields);
            document.getElementById('product_type_rent').addEventListener('change', toggleFields);

            toggleFields();

            function previewImage() {
                const fileInput = document.getElementById('image');
                const file = fileInput.files[0];
                const reader = new FileReader();

                reader.onloadend = function() {
                    let preview = document.getElementById('currentImage');
                    if (!preview) {
                        preview = document.createElement('img');
                        preview.id = 'currentImage';
                        preview.style.maxWidth = '300px';
                        document.getElementById('image').insertAdjacentElement('afterend', preview);
                    }
                    preview.src = reader.result;
                }

                if (file) {
                    reader.readAsDataURL(file);
                }
            }

            function loadSubcategories(parentId, targetId, containerId) {
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
                                target.innerHTML += '<option value="' + subcategory.id + '">' +
                                    subcategory.name + '</option>';
                            });
                            document.getElementById(containerId).style.display = 'block';
                        }
                    });
                } else {
                    document.getElementById(containerId).style.display = 'none';
                    document.getElementById(targetId).innerHTML = '<option value="">Select</option>';
                }
            }

            document.getElementById('main-category').addEventListener('change', function() {
                const mainCategoryId = this.value;
                loadSubcategories(mainCategoryId, 'sub-category', 'sub-category-container');

                // Reset sub-sub-category
                document.getElementById('sub-sub-category-container').style.display = 'none';
                document.getElementById('sub-sub-category').innerHTML = '<option value="">Select</option>';

                // Reset gender and size categories
                document.getElementById('gender-category-container').style.display = 'none';
                document.getElementById('gender-category').innerHTML = '<option value="">Select</option>';
                document.getElementById('size-category-container').style.display = 'none';
                document.getElementById('size-category').innerHTML = '<option value="">Select</option>';
            });

            document.getElementById('sub-category').addEventListener('change', function() {
                const subCategoryId = this.value;
                if (subCategoryId == 60) { // Assuming 60 is the ID for Kledij under BABY
                    loadSubcategories(62, 'gender-category', 'gender-category-container');
                    loadSubcategories(66, 'size-category', 'size-category-container');
                    document.getElementById('sub-sub-category-container').style.display = 'none';
                } else {
                    loadSubcategories(subCategoryId, 'sub-sub-category', 'sub-sub-category-container');

                    // Hide gender and size categories
                    document.getElementById('gender-category-container').style.display = 'none';
                    document.getElementById('gender-category').innerHTML =
                        '<option value="">Select</option>';
                    document.getElementById('size-category-container').style.display = 'none';
                    document.getElementById('size-category').innerHTML = '<option value="">Select</option>';
                }
            });

            document.getElementById('productForm').addEventListener('submit', function(event) {
                const availabilityFrom = document.getElementById('availability_from').value;
                const availabilityTo = document.getElementById('availability_to').value;
                const today = new Date().toISOString().split('T')[0];

                if (availabilityFrom && availabilityTo && availabilityFrom > availabilityTo) {
                    alert(
                        'The "Availability To" date must be later than or equal to the "Availability From" date.'
                        );
                    event.preventDefault();
                } else if ((availabilityFrom && availabilityFrom < today) || (availabilityTo &&
                        availabilityTo < today)) {
                    alert('The dates cannot be earlier than today.');
                    event.preventDefault();
                }
            });
        });
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
