<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SpiceNews - Date Search</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="{{ URL::asset('js/jquery-3.3.1.min.js') }}" ></script>
        <script src="{{ URL::asset('js/bootstrap.min.js') }}" ></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
                z-index: 999;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
            <div class="container">
                <div class="position-ref">
                    <div class="top-right links">
                        <a href="{{ url('/') }}">Home</a>
                        <a href="{{ url('/topicSearch') }}">Topic Search</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="section-heading">Spice News - Date Search</h2>
                        <h3 class="section-subheading text-muted"></h3>
                    </div>
                </div>
                <form action="" type="">
                    <div class="row text-center">
                        <div class="col-md-12">
                            <label class="col-md-2">Domain</label>
                            <div class="col-md-2">
                                <select id="domain" name="domain" class="form-control" required>
                                    <option value=""><- Select -></option>
                                    <option @if($domain=="bbc-news") selected @endif value="bbc-news">BBC News</option>
                                    <option @if($domain=="cnn") selected @endif value="cnn">CNN</option>
                                    <option @if($domain=="the-hindu") selected @endif value="the-hindu">The Hindu</option>
                                    <option @if($domain=="espn") selected @endif value="espn">ESPN</option>
                                </select>
                            </div>
                            <label class="col-md-2">From & To Date</label>
                            <div class="col-md-2"><input type="date" class="form-control" required id="fromDate" name="fromDate" max="@php echo date('Y-m-d'); @endphp" value="{{$fromDate}}"></div>
                            <div class="col-md-2"><input type="date" class="form-control" required id="toDate" name="toDate" max="@php echo date('Y-m-d'); @endphp" value="{{$toDate}}"></div>
                            <div class="col-md-2">
                                <button type="submit" class="form-control btn btn-primary" name="search" id="search" value="search">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
                @if(count($posts) > 0 && $posts['totalResults'] > 0)
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end">
                            <li class="page-item @php if($page == 1) echo 'disabled'; @endphp " >
                                <a class="page-link" href="{{url('dateSearch')}}?domain={{$domain}}&fromDate={{$fromDate}}&toDate={{$toDate}}&search=searchpage={{$page-1}}" tabindex="-1" aria-disabled="true" >Previous</a>
                            </li>
                            <li class="page-item @php if($pageCount == $page) echo 'disabled'; @endphp " >
                                <a class="page-link" href="{{url('dateSearch')}}?domain={{$domain}}&fromDate={{$fromDate}}&toDate={{$toDate}}&search=search&page={{$page+1}}" >Next</a>
                            </li>
                        </ul>
                    </nav>
                    <div class="list-group">
                        @foreach($posts['articles'] as $article)
                            <a href="{{$article['url']}}" class="list-group-item list-group-item-action flex-column align-items-start" style="display:inline-block;width:100%" target="_blank">
                                <div class="col-md-12">
                                    <div class="col-md-9">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{$article['title']}}</h5>
                                            <small>{{$article['publishedAt']}}</small>
                                        </div>
                                        <p class="mb-1">{{$article['description']}}</p>
                                        <small>{{$article['source']['name']}}</small>
                                    </div>
                                    <div class="col-md-3">
                                        <img style="width: 150px; height: 150px" src="{{$article['urlToImage']}}" id="" name="" alt="{{$article['author']}}" class="img-responsive"/>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end">
                            <li class="page-item @php if($page == 1) echo 'disabled'; @endphp " >
                                <a class="page-link" href="{{url('dateSearch')}}?domain={{$domain}}&fromDate={{$fromDate}}&toDate={{$toDate}}&search=searchpage={{$page-1}}" tabindex="-1" aria-disabled="true" >Previous</a>
                            </li>
                            <li class="page-item @php if($pageCount == $page) echo 'disabled'; @endphp " >
                                <a class="page-link" href="{{url('dateSearch')}}?domain={{$domain}}&fromDate={{$fromDate}}&toDate={{$toDate}}&search=search&page={{$page+1}}" >Next</a>
                            </li>
                        </ul>
                    </nav>
            </div>
            @endif
            </div>
    </body>
</html>