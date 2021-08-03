@extends('web.layouts.web')

@section('content')
<section id="about" class="about">
    <div class="container" data-aos="fade-up" style="margin-top: 110px;">

        <div class="section-title">
            <h2>Profil Kami</h2>
            <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit
                sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias
                ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

        <div class="row">
            <div class="col-lg-6" data-aos="fade-right">
                <img src="{{asset('medicio/assets/img/about.jpg')}}" class="img-fluid" alt="">
            </div>
            <div class="col-lg-6 pt-4 pt-lg-0 content" data-aos="fade-left">
                <h3>Voluptatem dignissimos provident quasi corporis voluptates sit assumenda.</h3>
                <p class="font-italic">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                    labore et dolore
                    magna aliqua.
                </p>
                <p>
                    Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                    reprehenderit in voluptate
                    velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in
                    culpa qui officia deserunt mollit anim id est laborum
                </p>
                {{-- <ul>
                    <li><i class="icofont-check-circled"></i> Ullamco laboris nisi ut aliquip ex ea commodo
                        consequat.</li>
                    <li><i class="icofont-check-circled"></i> Duis aute irure dolor in reprehenderit in
                        voluptate velit.</li>
                    <li><i class="icofont-check-circled"></i> Ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperda
                        mastiro dolore eu fugiat nulla pariatur.</li>
                </ul> --}}
                <p>
                    Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                    reprehenderit in voluptate
                    velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in
                    culpa qui officia deserunt mollit anim id est laborum
                </p>
            </div>
        </div>

    </div>
</section>
@endsection