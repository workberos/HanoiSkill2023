@extends('layout.main')

@section('content')

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="events/index.html">Quản lý sự kiện</a></li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>{{$event->name}}</span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link active" href="events/detail.html">Tổng quan</a></li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Báo cáo</span>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item"><a class="nav-link" href="reports/index.html">Công suất phòng</a></li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="border-bottom mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2">{{$event->name}}</h1>
                </div>
                <span class="h6">{{$event->date}}</span>
            </div>

            <div class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Tạo phòng mới</h2>
                </div>
            </div>

            <form class="needs-validation" novalidate action="{{ route('room.store', $event) }}" method = "post">

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputName">Tên</label>
                        <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
                        <input type="text" class="form-control @error('name')is-invalid @enderror" id="inputName" 
                        name="name" placeholder="" value="{{ old('name') }}">
                        @error('name')
                        <div class="invalid-feedback">
                            Tên không được để trống.
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="selectChannel">Kênh</label>
                        <select class="form-control" id="selectChannel" name="channel">
                            @foreach($event->channels as $channel)
                            <option value="{{ $channel->id }}" {{old('channel') == $channel->id? 'selected': ''}}>{{ $channel->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputCapacity">Công suất</label>
                        <input type="number" class="form-control @error('capacity')is-invalid @enderror" id="inputCapacity" 
                        name="capacity" placeholder="" value="{{ old('capacity')}}">
                        @error('name')
                        <div class="invalid-feedback">
                            Công xuất không được để trống.
                        </div>
                        @enderror
                    </div>
                </div>

                <hr class="mb-4">
                <button class="btn btn-primary" type="submit">Lưu phòng</button>
                <a href="events/detail.html" class="btn btn-link">Bỏ qua</a>
            </form>

        </main>
    </div>
</div>

@endsection
