@extends('admin.layouts.master')

@section('wrapper')
    <div class="container-fluid" dir="rtl">

        <form action="{{ route('admin.categories.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="card">

                <div class="card-header">
                    <h5 class="card-title mb-0">
                        افزودن دسته‌بندی
                    </h5>
                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">
                                عنوان
                            </label>

                            <input type="text"
                                   name="title"
                                   class="form-control"
                                   value="{{ old('title') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                اسلاگ
                            </label>

                            <input type="text"
                                   name="slug"
                                   class="form-control"
                                   value="{{ old('slug') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                دسته والد
                            </label>

                            <select name="parent_id"
                                    class="form-select">

                                <option value="">
                                    بدون والد
                                </option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                تصویر
                            </label>

                            <input type="file"
                                   name="image"
                                   class="form-control">
                        </div>

                    </div>

                </div>

                <div class="card-footer text-end">

                    <button class="btn btn-success">
                        ذخیره دسته‌بندی
                    </button>

                </div>

            </div>

        </form>

    </div>
@endsection
