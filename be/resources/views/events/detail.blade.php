@if(session('message'))
    <script>
        alert("{{ session('message') }}")
    </script>
@endif

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
                    <span>{{$event->name }}</span>
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
            <div class="border-bottom mb-3 pt-3 pb-2 event-title">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2">{{$event->name }}</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href="{{ route('event.edit', $event) }}" class="btn btn-sm btn-outline-secondary">Sửa sự kiện</a>
                        </div>
                    </div>
                </div>
                <span class="h6">{{$event->date }}</span>
            </div>

            <!-- Tickets -->
            <div id="tickets" class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Vé</h2>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href="{{ route('ticket.create', $event) }}" class="btn btn-sm btn-outline-secondary">
                                Tạo vé mới
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row tickets">
                @foreach($event->tickets as $ticket)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $ticket->name }}</h5>
                            <p class="card-text">{{ $ticket->cost }}</p>
                            @if(isset($ticket->special_validity))
                            <?php $data = json_decode(($ticket->special_validity)) ?>
                                @if($data->type == 'date')
                                <p class="card-text">có sẵn đến ngày {{ $data->date }}</p>
                                @else
                                <p class="card-text">{{ $data->amount }} vé sẵn có</p>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Sessions -->
            <div id="sessions" class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Phiên</h2>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href="{{ route('session.create', $event) }}" class="btn btn-sm btn-outline-secondary">
                                Tạo phiên mới
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive sessions">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Thời gian</th>
                        <th>Loại</th>
                        <th class="w-100">Tiêu đề</th>
                        <th>Người trình bày</th>
                        <th>Kênh</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($event->channels as $channel)
                    @foreach($channel->rooms as $room)
                    @foreach($room->sessions as $session)
                    <tr>
                        <td class="text-nowrap">{{$session->start}} - {{$session->end}}</td>
                        <td>Talk</td>
                        <td><a href="{{ route('session.edit', ['event'=> $event, 'session'=>$session]) }}">{{$session->title}}</a></td>
                        <td class="text-nowrap">{{$session->speaker}}</td>
                        <td class="text-nowrap">{{ $channel->name }} / {{ $room->name }}</td>
                    </tr>
                    @endforeach
                    @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Channels -->
            <div id="channels" class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Kênh</h2>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href="channels/create.html" class="btn btn-sm btn-outline-secondary">
                                Tạo kênh mới
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row channels">
            @foreach($event->channels as $channel)

                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $channel->name }}</h5>
                            <?php 
                            $countroom = 0;
                            $countsession = 0;
                            foreach($channel->rooms as $room) {
                                $countroom++;
                                foreach($room->sessions as $session){
                                    $countsession++;
                                }
                            }?>
                            <p class="card-text">{{$countsession}} Phiên, {{$countroom}} phòng</p>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>

            <!-- Rooms -->
            <div id="rooms" class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Phòng</h2>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <a href="{{ route('room.create', $event) }}" class="btn btn-sm btn-outline-secondary">
                                Tạo phòng mới
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive rooms">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Tên</th>
                        <th>Công suất</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($event->channels as $channel)
                    @foreach($channel->rooms as $room)
                    <tr>
                        <td>{{ $room->name }}</td>
                        <td>{{ $room->capacity }}</td>
                    </tr>
                    @endforeach
                    @endforeach
                    
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</div>

@endsection
