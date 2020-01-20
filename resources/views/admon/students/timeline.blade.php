@extends('layouts.adminLTEAdmon')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Expediente Electrónico de {{ $student->name }} {{ $student->last_name }}
                        {{ $student->mother_last_name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Alumnos</a></li>
                        <li class="breadcrumb-item active">Expediente</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Timelime example  -->
            <div class="row">
                <div class="col-md-12">
                    @forelse($inscriptions as $key => $value)
                    <!-- The time line -->
                    <div class="timeline">
                        <!-- timeline time label -->
                        <div class="time-label">
                            <span class="bg-blue">{{ $value->created_at }}</span>
                        </div>
                        <!-- /.timeline-label -->
                        <!-- timeline item -->
                        <div>
                            <i class="fas fa-user-graduate bg-blue"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> 12:05</span>
                                <h3 class="timeline-header"><a href="#">Diplomado: </a> {{ $value->diplomat }} <a href="#">Generación:</a> {{ $value->generation }}</h3>

                                <div class="timeline-body">
                                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                    weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                    jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                    quora plaxo ideeli hulu weebly balihoo...
                                </div>
                                <div class="timeline-footer">
                                    <a class="btn btn-primary btn-sm">Read more</a>
                                    <a class="btn btn-danger btn-sm">Delete</a>
                                </div>
                            </div>
                        </div>
                        <!-- END timeline item -->
                        <!-- timeline item -->
                        <div>
                            <i class="fas fa-user bg-green"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> 5 mins ago</span>
                                <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend
                                    request</h3>
                            </div>
                        </div>
                        <!-- END timeline item -->
                        <!-- timeline item -->
                        <div>
                            <i class="fas fa-comments bg-yellow"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> 27 mins ago</span>
                                <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
                                <div class="timeline-body">
                                    Take me to your leader!
                                    Switzerland is small and neutral!
                                    We are more like Germany, ambitious and misunderstood!
                                </div>
                                <div class="timeline-footer">
                                    <a class="btn btn-warning btn-sm">View comment</a>
                                </div>
                            </div>
                        </div>
                        <!-- END timeline item -->
                    </div>
                    @empty

                    @endforelse
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.timeline -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
