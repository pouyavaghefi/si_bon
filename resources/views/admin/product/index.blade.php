@extends('admin.layouts.master')

@section('wrapper')
    <div class="container-fluid" dir="rtl">

        <div class="row justify-content-center py-4">
            <div class="col-xxl-6 col-xl-8 text-center">
                <span class="badge badge-default fw-normal shadow px-3 py-2 mb-2 fs-xxs">
                    <i data-lucide="package" class="fs-sm me-1"></i>
                    مدیریت محصولات
                </span>

                <h3 class="fw-bold mb-2">
                    لیست محصولات
                </h3>

                <p class="fs-md text-muted mb-0">
                    در این بخش می‌توانید محصولات ثبت‌شده را مشاهده، ویرایش یا حذف کنید.
                </p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-12">

                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">

                        <h5 class="card-title mb-0">
                            محصولات
                        </h5>

                        <div class="d-flex align-items-center gap-2">

                            <a href="{{ route('admin.products.create') }}"
                               class="btn btn-primary btn-sm">
                                <i class="ti ti-package me-1"></i>
                                افزودن محصول چاپ
                            </a>

                            <a href="{{ route('admin.products.createTaki') }}"
                               class="btn btn-success btn-sm">
                                <i class="ti ti-shopping-bag me-1"></i>
                                افزودن محصول تکی
                            </a>

                        </div>

                    </div>

                    <div class="card-body p-0">

                        <div class="table-responsive">
                            <table class="table table-custom table-hover align-middle mb-0">

                                <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                                <tr class="text-uppercase fs-xxs">
                                    <th>#</th>
                                    <th>نام محصول</th>
                                    <th>دسته‌بندی</th>
                                    <th>برند</th>
                                    <th>قیمت</th>
                                    <th>واحد فروش</th>
                                    <th>موجودی</th>
                                    <th>وضعیت</th>
                                    <th style="width: 1%;">عملیات</th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>
                                            <div class="fw-semibold">
                                                {{ $product->title }}
                                            </div>

                                            <small class="text-muted">
                                                {{ $product->slug }}
                                            </small>
                                        </td>

                                        <td>
                                            {{ $product->category?->title ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $product->brand?->title ?? '-' }}
                                        </td>

                                        <td>
                                            {{ number_format($product->price) }}
                                            تومان
                                        </td>

                                        <td>
                                            {{ $product->sale_unit }}
                                        </td>

                                        <td>
                                            {{ $product->stock }}
                                        </td>

                                        <td>
                                            @if ($product->status === 'published')
                                                <span class="badge badge-label badge-soft-success">
                                                        منتشر شده
                                                    </span>
                                            @elseif ($product->status === 'draft')
                                                <span class="badge badge-label badge-soft-warning">
                                                        پیش‌نویس
                                                    </span>
                                            @else
                                                <span class="badge badge-label badge-soft-danger">
                                                        غیرفعال
                                                    </span>
                                            @endif
                                        </td>

                                        <td class="text-end">
                                            <div class="dropdown text-muted">

                                                <a href="#"
                                                   class="dropdown-toggle drop-arrow-none fs-xxl link-reset p-0"
                                                   data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-end">

                                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                                       class="dropdown-item">
                                                        <i class="ti ti-edit me-1"></i>
                                                        ویرایش
                                                    </a>

                                                    <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('آیا از حذف این محصول مطمئن هستید؟')">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                                class="dropdown-item text-danger">
                                                            <i class="ti ti-trash me-1"></i>
                                                            حذف
                                                        </button>

                                                    </form>

                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9"
                                            class="text-center text-muted py-4">
                                            هنوز محصولی ثبت نشده است.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>

                            </table>
                        </div>

                    </div>

                    @if ($products instanceof \Illuminate\Pagination\AbstractPaginator)
                        <div class="card-footer">
                            {{ $products->links() }}
                        </div>
                    @endif

                </div>

            </div>
        </div>

    </div>
@endsection
