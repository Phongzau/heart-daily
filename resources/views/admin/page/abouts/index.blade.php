@extends('layouts.admin')

@section('title')
    {{ $generalSettings->site_name }} || Về chúng tôi
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Giới thiệu</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4>Giới thiệu về chúng tôi</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.abouts.update') }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Nội dung</label>
                                    <textarea name="content" class="summernote">{!! @$about->content !!}</textarea>
                                </div>
                                @can('edit-abouts')
                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                @endcan
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
