@extends('admin.layouts.master')

@section('wrapper')
    <div class="container-fluid" dir="rtl">

        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h5 class="card-title mb-0">
                    دسته‌بندی محصولات
                </h5>

                <a href="{{ route('admin.categories.create') }}"
                   class="btn btn-primary btn-sm">
                    افزودن دسته‌بندی
                </a>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>تصویر</th>
                            <th>عنوان</th>
                            <th>اسلاگ</th>
                            <th>والد</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($categories as $category)
                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    @if ($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}"
                                             width="50"
                                             class="rounded border">
                                    @endif
                                </td>

                                <td>
                                    {{ $category->title }}
                                </td>

                                <td>
                                    {{ $category->slug }}
                                </td>

                                <td>
                                    {{ $category->parent?->title ?? '-' }}
                                </td>

                                <td>

                                    <div class="d-flex gap-2">

                                        <a href="{{ route('admin.categories.edit', $category->id) }}"
                                           class="btn btn-warning btn-sm">
                                            ویرایش
                                        </a>

                                        <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                              method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('حذف شود؟')">
                                                حذف
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    دسته‌بندی یافت نشد
                                </td>
                            </tr>
                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
@endsection
