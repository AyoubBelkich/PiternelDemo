@extends('layouts.app')

@section('content')
    <div class="category-header">
        <h1>Kind Products</h1>
    </div>

    <div class="container">
        <div class="row">
            <!-- Filter Section -->
            <div class="col-md-3">
                <form action="{{ route('kind.filter') }}" method="GET">
                    <div class="filter-section">
                        <h3>Filter by Subcategories</h3>
                        @foreach ($subcategories as $subcategory)
                            @php
                                $isAnySubSubcategoryChecked = collect(request()->input('subcategories', []))->contains(
                                    function ($value) use ($subcategory) {
                                        return $subcategory->children->pluck('id')->contains($value);
                                    },
                                );
                                $areAllSubSubcategoriesChecked =
                                    $subcategory->children->count() > 0 &&
                                    $subcategory->children
                                        ->pluck('id')
                                        ->diff(request()->input('subcategories', []))
                                        ->isEmpty();
                            @endphp
                            <div class="form-check">
                                <input type="checkbox" name="subcategories[]" value="{{ $subcategory->id }}"
                                    class="form-check-input subcategory-checkbox" id="subcategory{{ $subcategory->id }}"
                                    {{ in_array($subcategory->id, request()->input('subcategories', [])) || $areAllSubSubcategoriesChecked ? 'checked' : '' }}>
                                <label class="form-check-label" for="subcategory{{ $subcategory->id }}">
                                    {{ $subcategory->name }}
                                </label>
                                <button type="button" class="btn btn-link toggle-btn" data-toggle="collapse"
                                    data-target="#sub-subcategories-{{ $subcategory->id }}">
                                    {{ $isAnySubSubcategoryChecked ? '-' : '+' }}
                                </button>
                            </div>
                            <div id="sub-subcategories-{{ $subcategory->id }}"
                                class="collapse sub-subcategory-list {{ $isAnySubSubcategoryChecked ? 'show' : '' }}">
                                @foreach ($subcategory->children as $subSubcategory)
                                    <div class="form-check">
                                        <input type="checkbox" name="subcategories[]" value="{{ $subSubcategory->id }}"
                                            class="form-check-input sub-subcategory-checkbox"
                                            id="subSubcategory{{ $subSubcategory->id }}"
                                            {{ in_array($subSubcategory->id, request()->input('subcategories', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="subSubcategory{{ $subSubcategory->id }}">
                                            {{ $subSubcategory->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary mt-3">Filter</button>
                    </div>
                </form>
            </div>

            <!-- Products Section -->
            <div class="col-md-9">
                <div class="products-grid">
                    @foreach ($products as $product)
                        <div class="product-card">
                            @include('components.products.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .category-header {
            text-align: center;
            margin: 20px 0;
        }

        .filter-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 20%;
            float: left;
        }

        .filter-section h3 {
            margin-bottom: 15px;
            font-size: 18px;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .form-check-input {
            margin-right: 10px;
        }

        .toggle-btn {
            font-size: 12px;
            padding: 0;
            margin-left: 5px;
        }

        .sub-subcategory-list {
            padding-left: 20px;
            display: none;
            /* Hidden by default */
        }

        .products-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            width: 75%;
            float: right;
        }

        .product-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            width: 200px;
            transition: transform 0.3s;
        }

        .product-card img {
            max-width: 100%;
            height: auto;
        }

        .product-card h2 {
            font-size: 18px;
            margin: 10px 0;
        }

        .product-card p {
            color: #555;
            font-size: 14px;
            margin: 10px 0;
        }

        .product-card:hover {
            transform: scale(1.05);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle sub-subcategory display
            document.querySelectorAll('.toggle-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const target = document.querySelector(this.getAttribute('data-target'));
                    if (target.style.display === 'block') {
                        target.style.display = 'none';
                        this.textContent = '+';
                    } else {
                        target.style.display = 'block';
                        this.textContent = '-';
                    }
                });
            });

            // Handle parent-child checkbox behavior
            document.querySelectorAll('.subcategory-checkbox').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const subcategoryId = this.value;
                    const subSubcategoryList = document.querySelector(
                        `#sub-subcategories-${subcategoryId}`);
                    if (this.checked) {
                        subSubcategoryList.querySelectorAll('.sub-subcategory-checkbox').forEach(
                            function(subSubCheckbox) {
                                subSubCheckbox.checked = true;
                            });
                    } else {
                        subSubcategoryList.querySelectorAll('.sub-subcategory-checkbox').forEach(
                            function(subSubCheckbox) {
                                subSubCheckbox.checked = false;
                            });
                    }
                });
            });

            document.querySelectorAll('.sub-subcategory-checkbox').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const parentSubcategoryId = this.closest('.collapse').id.replace(
                        'sub-subcategories-', '');
                    const parentCheckbox = document.querySelector(
                        `#subcategory${parentSubcategoryId}`);
                    const allSubSubCheckboxes = this.closest('.collapse').querySelectorAll(
                        '.sub-subcategory-checkbox');
                    const allCheckedSubSubCheckboxes = this.closest('.collapse').querySelectorAll(
                        '.sub-subcategory-checkbox:checked');
                    parentCheckbox.checked = allSubSubCheckboxes.length ===
                        allCheckedSubSubCheckboxes.length;
                });
            });

            // Show sub-subcategories if any are checked
            document.querySelectorAll('.sub-subcategory-list').forEach(function(list) {
                const anyChecked = list.querySelectorAll('.sub-subcategory-checkbox:checked').length > 0;
                if (anyChecked) {
                    list.style.display = 'block';
                    const parentButton = list.previousElementSibling.querySelector('.toggle-btn');
                    parentButton.textContent = '-';
                }
            });
        });
    </script>
@endpush
