@extends('layouts.front_layout.front_layout')

@section('content')
<div class="span9">
    <div id="mainBody">
        <div class="container">
            <div class="row">
                <div class="span4">
                <h4>Contact Details</h4>
                <p>	18 Fresno,<br/> CA 93727, USA
                    <br/><br/>
                    info@sitemakers.in<br/>
                    ﻿Tel 00000-00000<br/>
                    Fax 00000-00000<br/>
                    web: https://www.youtube.com/threesixtydegree
                </p>
                </div>
                <div class="span4">
                <h4>Email Us</h4>
                @if(session()->has('success_message'))
                    <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                        {{ session()->get('success_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger mt-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="form-horizontal" action="{{ url('/contact') }}" method="POST">
                    @csrf
                <fieldset>
                  <div class="control-group">

                      <input type="text" name="name" placeholder="name" class="input-xlarge"/>

                  </div>
                   <div class="control-group">

                      <input type="text" name="email" placeholder="email" class="input-xlarge"/>

                  </div>
                   <div class="control-group">

                      <input type="text" name="subject" placeholder="subject" class="input-xlarge"/>

                  </div>
                  <div class="control-group">
                      <textarea rows="3" name="message" id="message" class="input-xlarge"></textarea>

                  </div>

                    <button class="btn btn-large" type="submit">Send Messages</button>

                </fieldset>
              </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
