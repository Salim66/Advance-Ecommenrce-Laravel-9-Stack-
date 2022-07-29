@extends('layouts.front_layout.front_layout')

@section('content')
<div class="span9">
    <ul class="breadcrumb">
        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
        <li class="active">Login</li>
    </ul>
    <h3> Forgot Password</h3>
    <hr class="soft"/>
    @if(session()->has('success_message'))
    <div class="alert alert-success" role="alert">
        {{ session()->get('success_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if(session()->has('error_message'))
    <div class="alert alert-danger" role="alert">
        {{ session()->get('error_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="row">
        <div class="span4">
            <div class="well">
            <h5>Forgot Password</h5><br/>
            Enter your e-mail to create new password.<br/><br/>
            <form id="forgotPasswordForm" action="{{ url('forgot_password') }}" method="POST">
                @csrf
                <div class="control-group">
                    <label class="control-label" for="email">Email address</label>
                    <div class="controls">
                        <input class="span3"  type="email" id="email" name="email" placeholder="Email" required>
                    </div>
                </div>
                <div class="controls">
                <button type="submit" class="btn block">Forgot Password</button>
                </div>
            </form>
        </div>
        </div>
        <div class="span1"> &nbsp;</div>
        <div class="span4">
            <div class="well">
            <h5>ALREADY REGISTERED ?</h5>
            <form id="loginForm" action="{{ url('login') }}" method="POST">
                @csrf
                <div class="control-group">
                    <label class="control-label" for="email">Email address</label>
                    <div class="controls">
                        <input class="span3"  type="email" id="email" name="email" placeholder="Email">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="password">Password</label>
                    <div class="controls">
                        <input class="span3"  type="password" id="password" name="password">
                    </div>
                </div>
            <div class="control-group">
                <div class="controls">
                <button type="submit" class="btn">Sign in</button> <a href="{{ url('forgot_password') }}">Forgot password?</a>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
